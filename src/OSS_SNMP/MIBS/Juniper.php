<?php

/*
    Copyright (c) 2012 - 2025, Open Source Solutions Limited, Dublin, Ireland
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

namespace OSS_SNMP\MIBS;

/**
 * A class for performing SNMP V2 queries on Extreme devices
 *
 * @copyright Copyright (c) 2012 - 2013, Open Source Solutions Limited, Dublin, Ireland
 * @author Barry O'Donovan <barry@opensolutions.ie>
 */
class Juniper extends \OSS_SNMP\MIB
{

    /**
     * Since Junos 11.3 release, a new set of MIBs were introduced to track the Routing Engine's CPU Load 
     * Averages for 1, 5, and 15 minute timespans. The relevant MIBs are listed under the jnxOperatingEntry tree:
     */
    const OID_JNX_OPERATING_ENTRY_1MIN_LOAD_AVG  = '.1.3.6.1.4.1.2636.3.1.13.1.20.9.1.0.0';
    const OID_JNX_OPERATING_ENTRY_5MIN_LOAD_AVG  = '.1.3.6.1.4.1.2636.3.1.13.1.21.9.1.0.0';
    const OID_JNX_OPERATING_ENTRY_15MIN_LOAD_AVG = '.1.3.6.1.4.1.2636.3.1.13.1.22.9.1.0.0';

    /**
     * Use the following OID to get the system booted time:
     * Name    jnxBoxInstalled
     */
    const OID_BOOT_TIME               = '.1.3.6.1.4.1.2636.3.1.5.0';


    /**
     * PSU name
     */
    const OID_PSU1_NAME = '.1.3.6.1.4.1.2636.3.58.1.2.4.1.2.2.1.0.0';
    const OID_PSU2_NAME = '.1.3.6.1.4.1.2636.3.58.1.2.4.1.2.2.2.0.0';

    /**
     * PSU state
     */
    const OID_PSU1_STATE = '.1.3.6.1.4.1.2636.3.58.1.2.4.1.8.2.1.0.0';
    const OID_PSU2_STATE = '.1.3.6.1.4.1.2636.3.58.1.2.4.1.8.2.2.0.0';


    /**
     * Get the device's 1min load average
     *
     * @return int The device's 1min load average
     */
    public function loadAverage1min()
    {
        return $this->getSNMP()->get( self::OID_JNX_OPERATING_ENTRY_1MIN_LOAD_AVG );
    }

    /**
     * Get the device's 5min load average
     *
     * @return int The device's 5min load average
     */
    public function loadAverage5min()
    {
        return $this->getSNMP()->get( self::OID_JNX_OPERATING_ENTRY_5MIN_LOAD_AVG );
    }

    /**
     * Get the device's 15min load average
     *
     * @return int The device's 15min load average
     */
    public function loadAverage15min()
    {
        return $this->getSNMP()->get( self::OID_JNX_OPERATING_ENTRY_15MIN_LOAD_AVG );
    }


    /**
     * @return int Boot time as timeticks since booted
     */
    public function bootTime()
    {
        return $this->getSNMP()->get( self::OID_BOOT_TIME );
    }


    public function psu1Name()
    {
        return $this->getSNMP()->get( self::OID_PSU1_NAME );
    }

    public function psu2Name()
    {
        return $this->getSNMP()->get( self::OID_PSU2_NAME );
    }

    public function psu1State()
    {
        return $this->getSNMP()->get( self::OID_PSU1_STATE );
    }

    public function psu2State()
    {
        return $this->getSNMP()->get( self::OID_PSU2_STATE );
    }


}
