#! /usr/bin/php
<?php

/*
    Copyright (c) 2012 - 2015, Open Source Solutions Limited, Dublin, Ireland
    All rights reserved.

    Contact: Barry O'Donovan - barry (at) opensolutions (dot) ie
    http://www.opensolutions.ie/

    This file is part of the OSS_SNMP package.

    Redistribution and use in source and binary forms, with or without
    modification, are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright
    notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
    notice, this list of conditions and the following disclaimer in the
    documentation and/or other materials provided with the distribution.
    * Neither the name of Open Source Solutions Limited nor the
    names of its contributors may be used to endorse or promote products
    derived from this software without specific prior written permission.

    THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
    ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
    WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
    DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY
    DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
    (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
    LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
    ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
    (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
    SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

// This is an example script for OSS_SNMP
//
// It needs to be called with a hostname / IP address and a community string

if( count( $argv ) != 3 && count( $argv ) != 4 )
{
    echo <<< HELPTEXT

OSS_SNMP - A PHP SNMP library for people who hate SNMP MIBs and OIDs!
Copyright (c) 2012, Open Source Solutions Limited, Dublin, Ireland
All rights reserved.

See: https://github.com/opensolutions/OSS_SNMP/

This is an example script to show how to use OSS_SNMP. It requires two or three arguments:

 - the IP address of hostname of a SNMP capable host
 - the SNMP v2 community string for that host

For example:

    {$argv[0]} 192.168.10.20 public


HELPTEXT;

    exit( 1 );
}

require_once( dirname( __FILE__ ) . '/../OSS_SNMP/SNMP.php' );

$host = new \OSS_SNMP\SNMP( $argv[1], $argv[2] );

if( count( $argv ) == 3 )
{
    echo "\nNumber of interfaces on {$argv[1]}: " . $host->useIface()->numberofInterfaces() . "\n\n";

    echo "ID:  Name  - Descrition - Type - Admin/Operational State\n\n";

    foreach( $host->useMAU()->types( true ) as $id => $type )
    {
        echo "{$id}: {$type}\n";
    }

    echo "\n";
    exit( 0 );
}


exit( 0 );