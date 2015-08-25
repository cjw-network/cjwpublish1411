<?php
//
// Definition of siblocksupdate cronjob
//
// Created on: <28-Apr-2008 10:06:19 jr>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ publish
// SOFTWARE RELEASE: 4.x.x
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

abstract class eZSIBlockHandler
{
    public function setTTL( $ttlString )
    {
        $this->TTL = $ttlString;
    }

    public function setKey( $keyString )
    {
        $this->Key = $keyString;
    }

    public function setSrc( $filePath )
    {
        $this->Src = $filePath;
    }

    public function validateKey()
    {
        if( !$this->Key )
        {
            return false;
        }

        return true;
    }

    public function TTLInSeconds()
    {
        $ttlInfos = $this->parseTTL();

        switch( $ttlInfos['ttl_unit'] )
        {
            case 'h' : $ttlInSeconds = $ttlInfos['ttl_value'] * 3600      ; break;
            case 'm' : $ttlInSeconds = $ttlInfos['ttl_value'] * 60        ; break;
            case 's' : $ttlInSeconds = $ttlInfos['ttl_value']             ; break;
            default  : $ttlInSeconds = $ttlInfos['ttl_value'] * 3600 * 24 ; break;
        }

        return $ttlInSeconds;
    }

    public function fileIsExpired( $mtime )
    {
        $TTLValue = $this->TTLInSeconds();
        return ( time() - $mtime ) >= $TTLValue;
    }

    public function parseTTL()
    {
        $ttlUnit  = substr( $this->TTL, -1);
        $ttlValue = (int)$this->TTL;

        return array( 'ttl_unit'  => $ttlUnit,
                      'ttl_value' => $ttlValue );
    }

    public function validateTTL()
    {
        // available time units are :
        // h : hours
        // m : minutes
        // s : seconds
        // d : days
        // units can not be combined

        $possibleUnits = array( 'h', 'm', 's', 'd' );

        $ttlInfos = $this->parseTTL();

        if( !in_array( $ttlInfos['ttl_unit'], $possibleUnits ) )
        {
            return false;
        }

        if( !$ttlInfos['ttl_value'] )
        {
            return false;
        }

        return true;
    }

    abstract public function generateMarkup();

    public $TTL = '';
    public $Key = '';
    public $Src = '';
}
?>