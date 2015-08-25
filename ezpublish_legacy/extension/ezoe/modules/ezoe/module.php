<?php
//
// Created on: <30-Jul-2007 00:00:00 ar>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Online Editor extension for eZ Publish
// SOFTWARE RELEASE: 5.0
// COPYRIGHT NOTICE: Copyright (C) 1999-2014 eZ Systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
// 
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
// 
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
// 
// 
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//


$Module = array( 'name' => 'eZ Online Editor Module Views, for dialoges and internal ajax use!' );

$ViewList = array();
$ViewList['relations'] = array(
    'functions' => array( 'editor' ),
    'ui_context' => 'edit',
    'script' => 'relations.php',
    'params' => array( 'ObjectID', 'ObjectVersion', 'ContentType', 'EmbedID', 'EmbedInline', 'EmbedSize' )
    );

$ViewList['upload'] = array(
    'functions' => array( 'editor' ),
    'ui_context' => 'edit',
    'script' => 'upload.php',
    'params' => array( 'ObjectID', 'ObjectVersion', 'ContentType', 'ForcedUpload' )
    );

$ViewList['tags'] = array(
    'functions' => array( 'editor' ),
    'ui_context' => 'edit',
    'script' => 'tags.php',
    'params' => array( 'ObjectID', 'ObjectVersion', 'TagName', 'CustomTagName' )
    );

$ViewList['dialog'] = array(
    'functions' => array( 'editor' ),
    'ui_context' => 'edit',
    'script' => 'dialog.php',
    'params' => array( 'ObjectID', 'ObjectVersion', 'Dialog' )
    );

$ViewList['embed_view'] = array(
    'functions' => array( 'editor' ),
    'script' => 'embed_view.php',
    'params' => array( 'EmbedID' )
    );

$ViewList['load'] = array(
    'functions' => array( 'editor' ),
    'script' => 'load.php',
    'params' => array( 'EmbedID', 'DataMap', 'ImagePreGenerateSizes' )
    );

$ViewList['spellcheck_rpc'] = array(
    'functions' => array( 'editor' ),
    'script' => 'spellcheck_rpc.php',
    'params' => array( )
    );

$ViewList['atd_rpc'] = array(
    'functions' => array( 'editor' ),
    'script' => 'atd_rpc.php',
    'params' => array( )
    );


/*
$ClassID = array(
    'name'=> 'Class',
    'values'=> array(),
    'path' => 'classes/',
    'file' => 'ezcontentclass.php',
    'class' => 'eZContentClass',
    'function' => 'fetchList',
    'parameter' => array( 0, false, false, array( 'name' => 'asc' ) )
    );

$SectionID = array(
    'name'=> 'Section',
    'values'=> array(),
    'path' => 'classes/',
    'file' => 'ezsection.php',
    'class' => 'eZSection',
    'function' => 'fetchList',
    'parameter' => array( false )
    );

$Assigned = array(
    'name'=> 'Owner',
    'values'=> array(
        array(
            'Name' => 'Self',
            'value' => '1')
        )
    );

$Node = array(
    'name'=> 'Node',
    'values'=> array()
    );

$Subtree = array(
    'name'=> 'Subtree',
    'values'=> array()
    );


$FunctionList = array();
$FunctionList['relations'] = array( 'Class' => $ClassID,
                               'Section' => $SectionID,
                               'Owner' => $Assigned,
                               'Node' => $Node,
                               'Subtree' => $Subtree);

$FunctionList['editor'] = array( 'Class' => $ClassID,
                               'Section' => $SectionID,
                               'Owner' => $Assigned,
                               'Node' => $Node,
                               'Subtree' => $Subtree);
*/

$FunctionList = array();
$FunctionList['relations'] = array();
$FunctionList['editor'] = array();
$FunctionList['search'] = array();// only used by template code to see if user should see this feature in ezoe
$FunctionList['browse'] = array();// only used by template code to see if user should see this feature in ezoe
$FunctionList['disable_editor'] = array();



?>