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
// 'ExtremeXOS (X460-48t) version 15.2.2.7 v1522b7-patch1-1 by release-manager on Tue Nov 20 17:14:11 EST 2012'
// 'ExtremeXOS (X460-48x) version 15.2.2.7 v1522b7-patch1-6 by release-manager on Thu Jan 31 11:11:52 EST 2013'
// 'ExtremeXOS (X670V-48x) version 15.2.2.7 v1522b7-patch1-6 by release-manager on Thu Jan 31 11:11:52 EST 2013'
// 'ExtremeXOS version 12.5.3.9 v1253b9 by release-manager on Tue Apr 26 20:36:04 PDT 2011'
// 'ExtremeXOS (X695-48Y-8C) version 31.7.1.4 31.7.1.4-patch1-98 by release-manager on Fri Jan 20 09:12:35 EST 2023'
// 'ExtremeXOS (X870-32c) version 31.7.3.37 31.7.3.37 by release-manager on Fri 23 Feb 2024 08:19:37 AM UTC'
// 'ExtremeXOS (X695-48Y-8C) version 32.7.4.15 32.7.4.15 by release-manager on Tue Jun 2 05:03:57 PM EDT 2026'

if( substr( $sysDescr, 0, 11 ) == 'ExtremeXOS ' )
{
    $this->setVendor( 'Extreme Networks' );
    $this->setOs( 'ExtremeXOS' );

    if( substr( $sysDescr, 0, 18 ) == 'ExtremeXOS version' )
    {
        preg_match( '/ExtremeXOS\sversion\s([a-zA-Z0-9\.\-]+\s[a-zA-Z0-9\.\-]+)\sby\srelease-manager\son\s([a-zA-Z]+)\s([a-zA-Z]+)\s(\d+)\s((\d\d):(\d\d):(\d\d))\s([a-zA-Z]+)\s(\d\d\d\d)/',
            $sysDescr, $matches );
        
        $this->setOsVersion( $matches[1] );

        try {
            $this->setOsDate( new \DateTime( "{$matches[4]} {$matches[3]} {$matches[10]} {$matches[5]} +0000" ) );
            $this->getOsDate()->setTimezone( new \DateTimeZone( $matches[9] ) );
        } catch( \Exception $e ) {
            $this->setOsDate( null );
        }
        
        // the model is not included in the system description here so we need to pull it out of the entity MIB
        // this may need to be checked on a model by model basis.
        // Works for:
        if( $this instanceof \OSS_SNMP\TestPlatform ) {
            $this->setModel('PHPunit');
        } else {
            $this->setModel($this->getSNMPHost()->get('.1.3.6.1.2.1.47.1.1.1.1.2.1'));
        }
    }
    else if( substr( $sysDescr, 0, 12 ) == 'ExtremeXOS (' )
    {
        $sysDescrTrimmed = trim( $sysDescr );

        // Format 1 (24-hour time, year at end): 'Fri Jan 20 09:12:35 EST 2023'
        if( preg_match( '/ExtremeXOS\s\((.+)\)\sversion\s([a-zA-Z0-9\.\-]+\s[a-zA-Z0-9\.\-]+)\sby\srelease-manager\son\s([a-zA-Z]+)\s([a-zA-Z]+)\s(\d+)\s((\d\d?):(\d\d):(\d\d))\s([a-zA-Z]+)\s(\d{4})\s*$/', $sysDescrTrimmed, $matches ) )
        {
            $this->setModel( $matches[1] );
            $this->setOsVersion( $matches[2] );
            try {
                $this->setOsDate( new \DateTime( "{$matches[5]} {$matches[4]} {$matches[11]} {$matches[6]} +0000" ) );
                $this->getOsDate()->setTimezone( new \DateTimeZone( $matches[10] ) );
            } catch( \Exception $e ) {
                $this->setOsDate( null );
            }
        }
        // Format 2 (12-hour AM/PM time, year at end): 'Tue Jun 2 05:03:57 PM EDT 2026'
        else if( preg_match( '/ExtremeXOS\s\((.+)\)\sversion\s([a-zA-Z0-9\.\-]+\s[a-zA-Z0-9\.\-]+)\sby\srelease-manager\son\s([a-zA-Z]+)\s([a-zA-Z]+)\s(\d+)\s((\d\d?):(\d\d):(\d\d))\s(AM|PM)\s([a-zA-Z]+)\s(\d{4})\s*$/i', $sysDescrTrimmed, $matches ) )
        {
            $this->setModel( $matches[1] );
            $this->setOsVersion( $matches[2] );
            try {
                $this->setOsDate( new \DateTime( "{$matches[5]} {$matches[4]} {$matches[12]} {$matches[6]} {$matches[10]} +0000" ) );
                $this->getOsDate()->setTimezone( new \DateTimeZone( $matches[11] ) );
            } catch( \Exception $e ) {
                $this->setOsDate( null );
            }
        }
        // Format 3 (12-hour AM/PM time, timezone at end): 'Fri 23 Feb 2024 08:19:37 AM UTC'
        else if( preg_match( '/ExtremeXOS\s\((.+)\)\sversion\s([a-zA-Z0-9\.\-]+\s[a-zA-Z0-9\.\-]+)\sby\srelease-manager\son\s([a-zA-Z]+)\s(\d+)\s([a-zA-Z]+)\s(\d{4})\s((\d\d?):(\d\d):(\d\d))\s(AM|PM)\s([a-zA-Z]+)\s*$/i', $sysDescrTrimmed, $matches ) )
        {
            $this->setModel( $matches[1] );
            $this->setOsVersion( $matches[2] );
            try {
                $this->setOsDate( new \DateTime( "{$matches[4]} {$matches[5]} {$matches[6]} {$matches[7]} {$matches[11]} +0000" ) );
                $this->getOsDate()->setTimezone( new \DateTimeZone( $matches[12] ) );
            } catch( \Exception $e ) {
                $this->setOsDate( null );
            }
        }
        // Fallback for unlisted date structures
        else if( preg_match( '/ExtremeXOS\s\((.+)\)\sversion\s([a-zA-Z0-9\.\-]+\s[a-zA-Z0-9\.\-]+)/', $sysDescrTrimmed, $matches ) )
        {
            $this->setModel( $matches[1] );
            $this->setOsVersion( $matches[2] );
            $this->setOsDate( null );
        }
    }
    else
    {
        $this->setModel( 'Unknown' );
        $this->setOsVersion( 'Unknown' );
        $this->setOsDate( null );
    }

    try {
        $this->setSerialNumber( $this->getSNMPHost()->useExtreme_Chassis()->systemID() );
    } catch( Exception $e ) {
        $this->setSerialNumber( '(error)' );
    }
}

// 'Extreme BR-SLX9850-4 Router, SLX Operating System Version 18r.1.00a.'
if( substr( $sysDescr, 0, 10 ) == 'Extreme BR' )
{
    $this->setVendor( 'Extreme Networks' );
    $this->setOs( 'SLX' );

    preg_match( '/^Extreme ([\w\-]+) Router, SLX Operating System Version ([\w.\-]+)\.$/',
        $sysDescr, $matches );

    $this->setModel( $matches[1] );
    $this->setOsVersion( $matches[2] );
    $this->setOsDate( null );

}
