<?php
/**
 * File containing the eZPaymentObject class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZPaymentObject ezpaymentobject.php
  \brief This is a base class for objects, which
  uses in redirectional payment gateways.
  They stores in database information about payment processing.
  These objects are temporary and will be destroyed after
  payment approvement.

*/

class eZPaymentObject extends eZPersistentObject
{
    const STATUS_NOT_APPROVED = 0;
    const STATUS_APPROVED = 1;

    /*!
    Constructor.
    */
    function eZPaymentObject( $row )
    {
        $this->eZPersistentObject( $row );
    }

    /*!
     \static
    Creates new object.
    */
    static function createNew( $workflowprocessID, $orderID, $paymentType )
    {
        return new eZPaymentObject( array( 'workflowprocess_id'  => $workflowprocessID,
                                           'order_id'            => $orderID,
                                           'payment_string'      => $paymentType ) );
    }

    /*!
    Approves payment.
    */
    function approve()
    {
        $this->setAttribute( 'status', self::STATUS_APPROVED );
        $this->store();
    }

    function approved()
    {
        return ( $this->attribute( 'status' ) == self::STATUS_APPROVED );
    }

    static function definition()
    {
        return array( 'fields' => array( 'id' => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default'  => 0,
                                                        'required' => true ),
                                         'workflowprocess_id' => array( 'name' => 'WorkflowProcessID',
                                                                        'datatype'=> 'integer',
                                                                        'default' => 0,
                                                                        'required'=> true,
                                                                        'foreign_class' => 'eZWorkflowProcess',
                                                                        'foreign_attribute' => 'id',
                                                                        'multiplicity' => '1..*' ),
                                         'order_id' => array( 'name' => 'OrderID',
                                                              'datatype'=> 'integer',
                                                              'default' => 0,
                                                              'required'=> false,
                                                              'foreign_class' => 'eZOrder',
                                                              'foreign_attribute' => 'id',
                                                              'multiplicity' => '1..*' ),
                                         'payment_string' => array( 'name' => 'PaymentString',
                                                                    'datatype'=> 'string',
                                                                    'default' => 'Payment',
                                                                    'required'=> false ),
                                         'status' => array( 'name' => 'Status',
                                                            'datatype'=> 'integer',
                                                            'default' => 0,
                                                            'required'=> true ) ),
                      'keys' => array( 'id' ),
                      'increment_key' => 'id',
                      'class_name' => 'eZPaymentObject',
                      'name' => 'ezpaymentobject' );
    }

    /*!
     \static
    Returns eZPaymentObject by 'id'.
    */
    static function fetchByID( $transactionID )
    {
        return eZPersistentObject::fetchObject( eZPaymentObject::definition(),
                                                null,
                                                array( 'id' => $transactionID ) );
    }

    /*!
     \static
    Returns eZPaymentObject by 'id' of eZOrder.
    */
    static function fetchByOrderID( $orderID )
    {
        return eZPersistentObject::fetchObject( eZPaymentObject::definition(),
                                                null,
                                                array( 'order_id' => $orderID ) );
    }

    /*!
     \static
    Returns eZPaymentObject by 'id' of eZWorkflowProcess.
    */
    static function fetchByProcessID( $workflowprocessID )
    {
        return eZPersistentObject::fetchObject( eZPaymentObject::definition(),
                                                null,
                                                array( 'workflowprocess_id' => $workflowprocessID ) );
    }

    /*!
     \static
    Continues workflow after approvement.
    */
    static function continueWorkflow( $workflowProcessID )
    {
        $operationResult =  null;
        $theProcess      = eZWorkflowProcess::fetch( $workflowProcessID );
        if ( $theProcess != null )
        {
            //restore memento and run it
            $bodyMemento = eZOperationMemento::fetchChild( $theProcess->attribute( 'memento_key' ) );
            if ( $bodyMemento === null )
            {
                eZDebug::writeError( $bodyMemento, "Empty body memento in workflow.php" );
                return $operationResult;
            }
            $bodyMementoData =  $bodyMemento->data();
            $mainMemento     = $bodyMemento->attribute( 'main_memento' );
            if ( !$mainMemento )
            {
                return $operationResult;
            }

            $mementoData = $bodyMemento->data();
            $mainMementoData = $mainMemento->data();
            $mementoData['main_memento'] = $mainMemento;
            $mementoData['skip_trigger'] = false;
            $mementoData['memento_key'] = $theProcess->attribute( 'memento_key' );
            $bodyMemento->remove();

            $operationParameters = array();
            if ( isset( $mementoData['parameters'] ) )
                $operationParameters = $mementoData['parameters'];

            $operationResult = eZOperationHandler::execute( $mementoData['module_name'],
                                                            $mementoData['operation_name'],
                                                            $operationParameters,
                                                            $mementoData );
        }

        return $operationResult;
    }
}
?>
