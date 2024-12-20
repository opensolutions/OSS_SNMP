<?php

/*
    Copyright (c) 2012 - 2017, Open Source Solutions Limited, Dublin, Ireland
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

if( substr( $sysDescr, 0, 7 ) == 'Cumulus' )
{
    $this->setVendor( 'Cumulus Networks' );
    $this->setOs( 'Cumulus Linux' );
    $this->setOsDate( null );

    // 'Cumulus Linux 3.4.0 (Linux Kernel 4.1.33-1+cl3u9)'
    // 'Cumulus-Linux 4.2.0 (Linux Kernel 4.19.94-1+cl4u5)'
    // 'Cumulus-linux 5.10.1 (Linux Kernel 6.1.90-4+cl5.10.1u5)'
    preg_match( '/Cumulus.[lL]inux\s+([\d\.]+)\s+/', $sysDescr, $matches );
    $this->setOsVersion( $matches[1] );
    
    // 'Edgecore x86_64-accton_as5812_54x-r0 5812-54X-O-AC-F Chassis'
    // 'Mellanox x86_64-mlnx_x86-r0 MSN2100 Chassis'
    preg_match( '/^(\S+)\s+.*\s+(\S+)\s+Chassis/',
                $this->getSNMPHost()->get( '.1.3.6.1.2.1.47.1.1.1.1.2.1' ), $matches );

    $this->setModel( $matches[1]." ".$matches[2] );

    $this->setSerialNumber( $this->getSNMPHost()->get( '.1.3.6.1.2.1.47.1.1.1.1.11.1' ) );
}
