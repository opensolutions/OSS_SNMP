#! /usr/bin/php
<?php

/*
    Copyright (c) 2012, Open Source Solutions Limited, Dublin, Ireland
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
    DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
    DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
    (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
    LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
    ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
    (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
    SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

// This is an example script for OSS_SNMP Asterisk MIBs
//
// It needs to be called with a hostname / IP address and a community string

if( count( $argv ) != 3 )
{
    echo <<< HELPTEXT

OSS_SNMP - A PHP SNMP library for people who hate SNMP MIBs and OIDs!
Copyright (c) 2012, Open Source Solutions Limited, Dublin, Ireland
All rights reserved.

See: https://github.com/opensolutions/OSS_SNMP/

This is an example script to show how to use OSS_SNMP. It requires two arguments:

 - the IP address of hostname of a SNMP capable host (with Asterisk SNMP enabled)
 - the SNMP v2 community string for that host
 
For example:

    {$argv[0]} 192.168.10.20 public


HELPTEXT;

    exit( 1 );
}

require_once( dirname( __FILE__ ) . '/../OSS/SNMP.php' );

$host = new \OSS\SNMP( $argv[1], $argv[2] );

echo "\n\n";

echo "Asterisk version running on {$argv[1]}: " . $host->useAsterisk()->version() . "\n";
echo "Asterisk SVN tag running on {$argv[1]}: " . $host->useAsterisk()->tag() . "\n";
echo "Asterisk on {$argv[1]} up for: " . ( $host->useAsterisk()->uptime() / 100 / 60 / 60 ) . " hours\n";
echo "Asterisk on {$argv[1]} reloaded: " . ( $host->useAsterisk()->reloadTime() / 100 / 60 / 60 ) . " hours ago\n";
echo "Asterisk PID: " . $host->useAsterisk()->pid() . "\n";
echo "Asterisk control socket: " . $host->useAsterisk()->controlSocket() . "\n";
echo "Calls active: " . $host->useAsterisk()->callsActive() . "\n";
echo "Calls processed: " . $host->useAsterisk()->callsProcessed() . "\n";
echo "Modules compiled in: " . $host->useAsterisk()->modules() . "\n";

echo "\n\n";

echo "Indications defined: " . $host->useAsterisk_Indications()->number() . "\n";
echo "Default indications zone: " . $host->useAsterisk_Indications()->defaultZone() . "\n";

echo "Indication country codes:\n\n";
print_r(  $host->useAsterisk_Indications()->countryCodes() );
echo "\n\n";

echo "Indication descriptions:\n\n";
print_r(  $host->useAsterisk_Indications()->descriptions() );
echo "\n\n";

echo "Channels active: " . $host->useAsterisk_Channels()->active() . "\n";
echo "Channels supported: " . $host->useAsterisk_Channels()->supported() . "\n";

/*
echo "Channel type names:\n\n";
print_r(  $host->useAsterisk_Channels()->names() );
echo "\n\n";

echo "Channel type descriptions:\n\n";
print_r(  $host->useAsterisk_Channels()->descriptions() );
echo "\n\n";

echo "Channel type device state capability:\n\n";
print_r(  $host->useAsterisk_Channels()->deviceStates() );
echo "\n\n";

echo "Channel type progress indication capability:\n\n";
print_r(  $host->useAsterisk_Channels()->progressIndications() );
echo "\n\n";

echo "Channel type transfer capability:\n\n";
print_r(  $host->useAsterisk_Channels()->transfers() );
echo "\n\n";

echo "Active calls on supported channel types:\n\n";
print_r(  $host->useAsterisk_Channels()->activeCalls() );
echo "\n\n";
*/

echo "Supported channel details:\n\n";
print_r(  $host->useAsterisk_Channels()->details() );
echo "\n\n";

echo "Channels bridged: " . $host->useAsterisk_Channels()->bridged() . "\n";


echo "\n\n";

exit( 0 );

