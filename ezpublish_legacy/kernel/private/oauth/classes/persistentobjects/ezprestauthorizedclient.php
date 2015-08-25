<?php
/**
 * File containing the definition of the RestAuthorizedClient persistent object.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$def = new ezcPersistentObjectDefinition();
$def->table = "ezprest_authorized_clients";
$def->class = "ezpRestAuthorizedClient";

$def->idProperty = new ezcPersistentObjectIdProperty;
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition( 'ezcPersistentSequenceGenerator', array( "sequence" => "ezprest_authorized_clients_s" ) );

$def->properties['rest_client_id'] = new ezcPersistentObjectProperty;
$def->properties['rest_client_id']->columnName = 'rest_client_id';
$def->properties['rest_client_id']->propertyName = 'rest_client_id';
$def->properties['rest_client_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['user_id'] = new ezcPersistentObjectProperty;
$def->properties['user_id']->columnName = 'user_id';
$def->properties['user_id']->propertyName = 'user_id';
$def->properties['user_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['created'] = new ezcPersistentObjectProperty;
$def->properties['created']->columnName = 'created';
$def->properties['created']->propertyName = 'created';
$def->properties['created']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;
?>
