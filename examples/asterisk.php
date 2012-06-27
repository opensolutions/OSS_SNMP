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
    DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY
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

require_once( dirname( __FILE__ ) . '/../OSS_SNMP/SNMP.php' );

$host = new \OSS_SNMP\SNMP( $argv[1], $argv[2] );

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


echo "Supported channel details:\n\n";
print_r(  $host->useAsterisk_Channels()->details() );
echo "\n\n";

echo "Channels bridged: " . $host->useAsterisk_Channels()->bridged() . "\n";

/**


echo "\n\n\nchanName\n";
print_r( $host->useAsterisk_Channels()->chanName() );
echo "\n\n\nchanLanguage\n";
print_r( $host->useAsterisk_Channels()->chanLanguage() );
echo "\n\n\nchanType\n";
print_r( $host->useAsterisk_Channels()->chanType() );
echo "\n\n\nchanMusicClass\n";
print_r( $host->useAsterisk_Channels()->chanMusicClass() );
echo "\n\n\nchanBridge\n";
print_r( $host->useAsterisk_Channels()->chanBridge() );
echo "\n\n\nchanMasq\n";
print_r( $host->useAsterisk_Channels()->chanMasq() );
echo "\n\n\nchanMasqr\n";
print_r( $host->useAsterisk_Channels()->chanMasqr() );
echo "\n\n\nchanWhenHangup\n";
print_r( $host->useAsterisk_Channels()->chanWhenHangup() );
echo "\n\n\nchanApp\n";
print_r( $host->useAsterisk_Channels()->chanApp() );
echo "\n\n\nchanData\n";
print_r( $host->useAsterisk_Channels()->chanData() );
echo "\n\n\nchanContext\n";
print_r( $host->useAsterisk_Channels()->chanContext() );
echo "\n\n\nchanMacroContext\n";
print_r( $host->useAsterisk_Channels()->chanMacroContext() );
echo "\n\n\nchanMacroExten\n";
print_r( $host->useAsterisk_Channels()->chanMacroExten() );
echo "\n\n\nchanMacroPri\n";
print_r( $host->useAsterisk_Channels()->chanMacroPri() );
echo "\n\n\nchanExten\n";
print_r( $host->useAsterisk_Channels()->chanExten() );
echo "\n\n\nchanPri\n";
print_r( $host->useAsterisk_Channels()->chanPri() );
echo "\n\n\nchanAccountCode\n";
print_r( $host->useAsterisk_Channels()->chanAccountCode() );
echo "\n\n\nchanForwardTo\n";
print_r( $host->useAsterisk_Channels()->chanForwardTo() );
echo "\n\n\nchanUniqueId\n";
print_r( $host->useAsterisk_Channels()->chanUniqueId() );
echo "\n\n\nchanCallGroup\n";
print_r( $host->useAsterisk_Channels()->chanCallGroup() );
echo "\n\n\nchanPickupGroup\n";
print_r( $host->useAsterisk_Channels()->chanPickupGroup() );
echo "\n\n\nchanState\n";
print_r( $host->useAsterisk_Channels()->chanState(1) );
echo "\n\n\nchanMuted\n";
print_r( $host->useAsterisk_Channels()->chanMuted() );
echo "\n\n\nchanRings\n";
print_r( $host->useAsterisk_Channels()->chanRings() );
echo "\n\n\nchanCidDNID\n";
print_r( $host->useAsterisk_Channels()->chanCidDNID() );
echo "\n\n\nchanCidNum\n";
print_r( $host->useAsterisk_Channels()->chanCidNum() );
echo "\n\n\nchanCidName\n";
print_r( $host->useAsterisk_Channels()->chanCidName() );
echo "\n\n\nchanCidANI\n";
print_r( $host->useAsterisk_Channels()->chanCidANI() );
echo "\n\n\nchanCidRDNIS\n";
print_r( $host->useAsterisk_Channels()->chanCidRDNIS() );
echo "\n\n\nchanCidPresentation\n";
print_r( $host->useAsterisk_Channels()->chanCidPresentation() );
echo "\n\n\nchanCidANI2\n";
print_r( $host->useAsterisk_Channels()->chanCidANI2() );
echo "\n\n\nchanCidTON\n";
print_r( $host->useAsterisk_Channels()->chanCidTON() );
echo "\n\n\nchanCidTNS\n";
print_r( $host->useAsterisk_Channels()->chanCidTNS() );
echo "\n\n\nchanAMAFlags\n";
print_r( $host->useAsterisk_Channels()->chanAMAFlags(1) );
echo "\n\n\nchanADSI\n";
print_r( $host->useAsterisk_Channels()->chanADSI(1) );
echo "\n\n\nchanToneZone\n";
print_r( $host->useAsterisk_Channels()->chanToneZone() );
echo "\n\n\nchanHangupCause\n";
print_r( $host->useAsterisk_Channels()->chanHangupCause(1) );
echo "\n\n\nchanVariables\n";
print_r( $host->useAsterisk_Channels()->chanVariables() );
echo "\n\n\nchanFlags\n";
print_r( $host->useAsterisk_Channels()->chanFlags() );
echo "\n\n\nchanTransferCap\n";
print_r( $host->useAsterisk_Channels()->chanTransferCap(1) );

*/

echo "\n\n\nChannel Details\n";
print_r( $host->useAsterisk_Channels()->channelDetails( true, false ) );



echo "\n\n";

exit( 0 );

