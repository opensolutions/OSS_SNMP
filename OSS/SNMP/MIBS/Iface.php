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

namespace OSS\SNMP\MIBS;

/**
 * A class for performing SNMP V2 queries on generic devices
 *
 * @copyright Copyright (c) 2012, Open Source Solutions Limited, Dublin, Ireland
 * @author Barry O'Donovan <barry@opensolutions.ie>
 */
class Iface extends \OSS\SNMP\MIB
{
    const OID_IF_DESCRIPTION   = '.1.3.6.1.2.1.2.2.1.2';
    const OID_IF_SPEED         = '.1.3.6.1.2.1.2.2.1.5';
    const OID_IF_OPER_STATUS   = '.1.3.6.1.2.1.2.2.1.8';
    const OID_IF_NAME          = '.1.3.6.1.2.1.31.1.1.1.1';
    const OID_IF_ALIAS         = '.1.3.6.1.2.1.31.1.1.1.18';

    /**
     * Get an array of device interface names
     *
     * E.g. the following SNMP output yields the shown array:
     *
     * .1.3.6.1.2.1.31.1.1.1.1.10128 = STRING: Gi1/0/28
     * .1.3.6.1.2.1.31.1.1.1.1.10129 = STRING: Gi1/0/29
     * ...
     *
     *      [10128] => "Gi1/0/28"
     *      [10129] => "Gi1/0/29"
     *
     * @return array An array of interface names
     */
    public function names()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_NAME );
    }

    /**
     * Get an array of device interface aliases (e.g. as set by the interface description / port-name parameter)
     *
     * E.g. the followig SNMP output yields the shown array:
     *
     * .1.3.6.1.2.1.2.2.1.2.18.10128 = STRING: Connection to switch2
     * .1.3.6.1.2.1.2.2.1.2.18.10129 = STRING: Connection to switch3
     * ...
     *
     *      [10128] => "Connection to switch2"
     *      [10129] => "Connection to switch3"
     *
     * @return array An array of interface aliases
     */
    public function aliases()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_ALIAS );
    }

    /**
     * Get an array of device interface descriptions
     *
     * E.g. the following SNMP output yields the shown array:
     *
     * .1.3.6.1.2.1.31.1.1.1.1.10128 = STRING: GigabitEthernet1/0/28
     * .1.3.6.1.2.1.31.1.1.1.1.10129 = STRING: GigabitEthernet1/0/29
     * ...
     *
     *      [10128] => "GigabitEthernet1/0/28"
     *      [10129] => "GigabitEthernet1/0/29"
     *
     * @return array An array of interface descriptions
     */
    public function descriptions()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_DESCRIPTION );
    }

    /**
     * Get an array of device interface (operating) speeds
     *
     * E.g. the following SNMP output yields the shown array:
     *
     * .1.3.6.1.2.1.2.2.1.5.10128 = Gauge32: 1000000000
     * .1.3.6.1.2.1.2.2.1.5.10129 = Gauge32: 100000000
     * ...
     *
     *      [10128] => 1000000000
     *      [10129] => 100000000
     *
     * NB: operating speed as opposed to maximum speed
     *
     * @return array An array of interface operating speeds
     */
    public function speeds()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_SPEED );
    }


    /**
     * Constant for possible value of interface operation status.
     * @see operationStates()
     */
    const IF_OPER_STATUS_UP               = 1;
    /**
     * Constant for possible value of interface operation status.
     * @see operationStates()
     */
    const IF_OPER_STATUS_DOWN             = 2;
    /**
     * Constant for possible value of interface operation status.
     * @see operationStates()
     */
    const IF_OPER_STATUS_TESTING          = 3;
    /**
     * Constant for possible value of interface operation status.
     * @see operationStates()
     */
    const IF_OPER_STATUS_UNKNOWN          = 4;
    /**
     * Constant for possible value of interface operation status.
     * @see operationStates()
     */
    const IF_OPER_STATUS_DORMANT          = 5;
    /**
     * Constant for possible value of interface operation status.
     * @see operationStates()
     */
    const IF_OPER_STATUS_NOT_PRESENT      = 6;
    /**
     * Constant for possible value of interface operation status.
     * @see operationStates()
     */
    const IF_OPER_STATUS_LOWER_LAYER_DOWN = 7;

    /**
     * Text representation of interface operating status.
     *
     * @see operationStates()
     * @var array Text representations of interface operating status.
     */
    public static $IF_OPER_STATES = array(
        self::IF_OPER_STATUS_UP                => 'up',
        self::IF_OPER_STATUS_DOWN              => 'down',
        self::IF_OPER_STATUS_TESTING           => 'testing',
        self::IF_OPER_STATUS_UNKNOWN           => 'unknown',
        self::IF_OPER_STATUS_DORMANT           => 'dormant',
        self::IF_OPER_STATUS_NOT_PRESENT       => 'notPresent',
        self::IF_OPER_STATUS_LOWER_LAYER_DOWN  => 'lowerLayerDown'
    );

    /**
     * Get an array of device interface operating status (up / down)
     *
     * E.g. the follow SNMP output yields the shown array:
     *
     * .1.3.6.1.2.1.2.2.1.8.10128 = INTEGER: up(1)
     * .1.3.6.1.2.1.2.2.1.8.10129 = INTEGER: down(2)
     * ...
     *
     *      [10128] => 1
     *      [10129] => 2
     *
     * @see IF_OPER_STATES
     * @param boolean $translate If true, return the string representation
     * @return array An array of interface states
     */
    public function operationStates( $translate = false )
    {
        $states = $this->getSNMP()->walk1d( self::OID_IF_OPER_STATUS );

        if( !$translate )
            return $states;

        return $this->getSNMP()->translate( $states, self::$IF_OPER_STATES );
    }


    /**
     * Returns an associate array of STP port IDs (key) to interface IDs (value)
     *
     * e.g.  [22] => 10122
     *
     *
     * @return array Associate array of STP port IDs (key) to interface IDs (value)
     */
    public function bridgeBasePortIfIndexes()
    {
        return $this->getSNMP()->walk1d( self::OID_BRIDGE_BASE_PORT_IF_INDEX );
    }

}


