<?php

/*
    Copyright (c) 2012 - 2013, Open Source Solutions Limited, Dublin, Ireland
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


// Works with sysDescr such as:
//
// 'Cisco IOS Software, s72033_rp Software (s72033_rp-ADVENTERPRISE_WAN-VM), Version 12.2(33)SXI5, RELEASE SOFTWARE (fc2)'
//
// 'Cisco Internetwork Operating System Software IOS (tm) C2950 Software (C2950-I6Q4L2-M), Version 12.1(13)EA1, RELEASE SOFTWARE.*'

if( substr( $sysDescr, 0, 18 ) == 'Cisco IOS Software' )
{
    preg_match( '/Cisco IOS Software, (.+) Software \((.+)\), Version\s([0-9A-Za-z\(\)\.]+), RELEASE SOFTWARE\s\((.+)\)/',
            $sysDescr, $matches );

    $this->setVendor( 'Cisco Systems' );
    try {
        $this->setModel( $this->getSNMPHost()->useEntity()->physicalName()[1] );
    } catch( \OSS_SNMP\Exception $e ) {
        $this->setModel( 'Unknown' );
    }
    $this->setOs( 'IOS' );
    $this->setOsVersion( $matches[3] );
    $this->setOsDate( null );
}
else if( substr( $sysDescr, 0, 48 ) == 'Cisco Internetwork Operating System Software IOS' )
{
    $sysDescr = trim( preg_replace( '/\s+/', ' ', $sysDescr ) );
    preg_match( '/Cisco(.+)C2950 Software(.+)Version\s([0-9A-Za-z\(\)\.]+),\sRELEASE SOFTWARE.*/',
            $sysDescr, $matches );

    $this->setVendor( 'Cisco Systems' );
    $this->setModel( 'C2950' );
    $this->setOs( 'IOS' );
    $this->setOsVersion( $matches[3] );
    $this->setOsDate( null );
} 
else if( substr( $sysDescr, 0, 21 ) == 'Cisco IOS XR Software' )
{
    // 'Cisco IOS XR Software (Cisco ASR9K Series),  Version 4.3.2[Default]\r\nCopyright (c) 2013 by Cisco Systems, Inc., referer: http://10.0.35.20/ixp/switch/add-by-snmp'

    preg_match( '/Cisco IOS XR Software \((.+ Series)\),\s+Version\s([0-9A-Za-z\(\)\.\[\]]+)\s+Copyright \(c\) [0-9]+ by Cisco Systems, Inc.*/',
            $sysDescr, $matches );
    $this->setVendor( 'Cisco Systems' );
    $this->setModel( $matches[1] );
    $this->setOs( 'IOS XR' );
    $this->setOsVersion( $matches[2] );
    $this->setOsDate( null );
}

