<?php
//
// eZSetup - init part initialization
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$Module = $Params['Module'];


// Create new PDF Export
if ( $Module->isCurrentAction( 'NewExport' ) )
{
    return $Module->redirect( 'pdf', 'edit' );
}
//Remove existing PDF Export(s)
else if ( $Module->isCurrentAction( 'RemoveExport' ) && $Module->hasActionParameter( 'DeleteIDArray' ) )
{
    $deleteArray = $Module->actionParameter( 'DeleteIDArray' );
    foreach ( $deleteArray as $deleteID )
    {
        // remove draft if it exists:
        $pdfExport = eZPDFExport::fetch( $deleteID, true, eZPDFExport::VERSION_DRAFT );
        if ( $pdfExport )
        {
            $pdfExport->remove();
        }
        // remove default version:
        $pdfExport = eZPDFExport::fetch( $deleteID );
        if ( $pdfExport )
        {
            $pdfExport->remove();
        }
    }
}

$exportArray = eZPDFExport::fetchList();
$exportList = array();
foreach( $exportArray as $export )
{
    $exportList[$export->attribute( 'id' )] = $export;
}

$tpl = eZTemplate::factory();

$tpl->setVariable( 'pdfexport_list', $exportList );

$Result = array();
$Result['content'] = $tpl->fetch( "design:pdf/list.tpl" );
$Result['path'] = array( array( 'url' => 'kernel/pdf',
                                'text' => ezpI18n::tr( 'kernel/pdf', 'PDF Export' ) ) );

?>
