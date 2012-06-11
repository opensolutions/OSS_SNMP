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
    const OID_IF_NUMBER                  = '.1.3.6.1.2.1.2.1.0';
    const OID_IF_DESCRIPTION             = '.1.3.6.1.2.1.2.2.1.2';
    const OID_IF_TYPE                    = '.1.3.6.1.2.1.2.2.1.3';
    const OID_IF_MTU                     = '.1.3.6.1.2.1.2.2.1.4';
    const OID_IF_SPEED                   = '.1.3.6.1.2.1.2.2.1.5';
    const OID_IF_PHYS_ADDRESS            = '.1.3.6.1.2.1.2.2.1.6';
    const OID_IF_ADMIN_STATUS            = '.1.3.6.1.2.1.2.2.1.7';
    const OID_IF_OPER_STATUS             = '.1.3.6.1.2.1.2.2.1.8';
    const OID_IF_LAST_CHANGE             = '.1.3.6.1.2.1.2.2.1.9';

    const OID_IF_IN_OCTETS               = '.1.3.6.1.2.1.2.2.1.10';
    const OID_IF_IN_UNICAST_PACKETS      = '.1.3.6.1.2.1.2.2.1.11';
    const OID_IF_IN_NON_UNICAST_PACKETS  = '.1.3.6.1.2.1.2.2.1.12';
    const OID_IF_IN_DISCARDS             = '.1.3.6.1.2.1.2.2.1.13';
    const OID_IF_IN_ERRORS               = '.1.3.6.1.2.1.2.2.1.14';
    const OID_IF_IN_UNKNOWN_PROTOCOLS    = '.1.3.6.1.2.1.2.2.1.15';
    
    const OID_IF_OUT_OCTETS              = '.1.3.6.1.2.1.2.2.1.16';
    const OID_IF_OUT_UNICAST_PACKETS     = '.1.3.6.1.2.1.2.2.1.17';
    const OID_IF_OUT_NON_UNICAST_PACKETS = '.1.3.6.1.2.1.2.2.1.18';
    const OID_IF_OUT_DISCARDS            = '.1.3.6.1.2.1.2.2.1.19';
    const OID_IF_OUT_ERRORS              = '.1.3.6.1.2.1.2.2.1.20';
    const OID_IF_OUT_QUEUE_LENGTH        = '.1.3.6.1.2.1.2.2.1.21';
    
    const OID_IF_NAME                    = '.1.3.6.1.2.1.31.1.1.1.1';
    const OID_IF_ALIAS                   = '.1.3.6.1.2.1.31.1.1.1.18';

    /**
     * Get the number of network interfaces (regardless of
     * their current state) present on this system.
     *
     * @return int The number of network interfaces on the system
     */
    public function numberOfInterfaces()
    {
        return $this->getSNMP()->get( self::OID_IF_NUMBER );
    }


    /**
     * Get an array of device MTUs
     *
     * @return array An array of device MTUs
     */
    public function mtus()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_MTU );
    }
    
    /**
     * Get an array of the interfaces' physical addresses
     *
     * "The interface's address at the protocol layer
     * immediately `below' the network layer in the
     * protocol stack.  For interfaces which do not have
     * such an address (e.g., a serial line), this object
     * should contain an octet string of zero length."
     *
     * @return array An array of device physical addresses
     */
    public function physAddresses()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_PHYS_ADDRESS );
    }
    
    
    
    /**
     * Constant for possible value of interface admin status.
     * @see adminStates()
     */
    const IF_ADMIN_STATUS_UP = 1;

    /**
     * Constant for possible value of interface admin status.
     * @see adminStates()
     */
    const IF_ADMIN_STATUS_DOWN = 2;

    /**
     * Constant for possible value of interface admin status.
     * @see adminStates()
     */
    const IF_ADMIN_STATUS_TESTING = 3;

    /**
     * Text representation of interface admin status.
     *
     * @see adminStates()
     * @var array Text representations of interface admin status.
     */
    public static $IF_ADMIN_STATES = array(
        self::IF_ADMIN_STATUS_UP      => 'up',
        self::IF_ADMIN_STATUS_DOWN    => 'down',
        self::IF_ADMIN_STATUS_TESTING => 'testing'
    );
    
    /**
     * Get an array of device interface admin status (up / down)
     *
     * E.g. the follow SNMP output yields the shown array:
     *
     * .1.3.6.1.2.1.2.2.1.7.10128 = INTEGER: up(1)
     * .1.3.6.1.2.1.2.2.1.7.10129 = INTEGER: down(2)
     * ...
     *
     *      [10128] => 1
     *      [10129] => 2
     *
     * @see IF_ADMIN_STATES
     * @param boolean $translate If true, return the string representation
     * @return array An array of interface admin states
     */
    public function adminStates( $translate = false )
    {
        $states = $this->getSNMP()->walk1d( self::OID_IF_ADMIN_STATUS );

        if( !$translate )
            return $states;

        return $this->getSNMP()->translate( $states, self::$IF_ADMIN_STATES );
    }
        
    /**
     * Get an array of device interface last change times
     *
     * Value returned is timeticks (one hundreds of a second)
     *
     * "The value of sysUpTime at the time the interface
     * entered its current operational state.  If the
     * current state was entered prior to the last re-
     * initialization of the local network management
     * subsystem, then this object contains a zero
     * value."
     *
     * @see \OSS\SNMP\MIBS\System::uptime()
     * @return array Timeticks (or zero) since last change of the interfaces
     */
    public function lastChanges()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_LAST_CHANGE );
    }

    /**
     * Get an array of device interface in octets
     *
     * "The total number of octets received on the
     * interface, including framing characters."
     *
     * @return array The total number of octets received on interfaces
     */
    public function inOctets()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_IN_OCTETS );
    }

    /**
     * Get an array of device interface unicast packets in
     *
     * "The number of subnetwork-unicast packets
     * delivered to a higher-layer protocol."
     *
     * @return array The total number of unicast packets received on interfaces
     */
    public function inUnicastPackets()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_IN_UNICAST_PACKETS );
    }

    /**
     * Get an array of device interface non-unicast packets in
     *
     * "The number of non-unicast (i.e., subnetwork-
     * broadcast or subnetwork-multicast) packets
     * delivered to a higher-layer protocol."
     *
     * @return array The total number of non-unicast packets received on interfaces
     */
    public function inNonUnicastPackets()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_IN_NON_UNICAST_PACKETS );
    }

    /**
     * Get an array of device interface inbound discarded packets
     *
     * "The number of inbound packets which were chosen
     * to be discarded even though no errors had been
     * detected to prevent their being deliverable to a
     * higher-layer protocol.  One possible reason for
     * discarding such a packet could be to free up
     * buffer space."
     *
     * @return arrary The total number of discarded inbound packets received on interfaces
     */
    public function inDiscards()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_IN_DISCARDS );
    }

    /**
     * Get an array of device interface inbound error packets
     *
     * "The number of inbound packets that contained
     * errors preventing them from being deliverable to a
     * higher-layer protocol."
     *
     * @return array The total number of error inbound packets received on interfaces
     */
    public function inErrors()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_IN_ERRORS );
    }

    
    
    
    
    
    
    /**
     * Get an array of device interface out octets
     *
     * "The total number of octets transmitted out of the
     * interface, including framing characters."
     *
     * @return array The total number of octets transmitted on interfaces
     */
    public function outOctets()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_OUT_OCTETS );
    }
    
    /**
     * Get an array of device interface unicast packets out
     *
     * "The total number of packets that higher-level
     * protocols requested be transmitted to a
     * subnetwork-unicast address, including those that
     * were discarded or not sent."
     *
     * @return array The total number of unicast packets transmitted on interfaces
     */
    public function outUnicastPackets()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_OUT_UNICAST_PACKETS );
    }
    
    /**
     * Get an array of device interface non-unicast packets out
     *
     * "The total number of packets that higher-level
     * protocols requested be transmitted to a non-
     * unicast (i.e., a subnetwork-broadcast or
     * subnetwork-multicast) address, including those
     * that were discarded or not sent."
     *
     * @return array The total number of non-unicast packets requested sent interfaces
     */
    public function outNonUnicastPackets()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_OUT_NON_UNICAST_PACKETS );
    }
    
    /**
     * Get an array of device interface outbound discarded packets
     *
     * "The number of outbound packets which were chosen
     * to be discarded even though no errors had been
     * detected to prevent their being transmitted.  One
     * possible reason for discarding such a packet could
     * be to free up buffer space."
     *
     * @return arrary The total number of discarded outbound packets
     */
    public function outDiscards()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_OUT_DISCARDS );
    }
    
    /**
     * Get an array of device interface outbound error packets
     *
     * "The number of outbound packets that could not be
     * transmitted because of errors."
     *
     * @return array The total number of error outbound packets received on interfaces
     */
    public function outErrors()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_OUT_ERRORS );
    }
    
    /**
     * Get an array of interface outbound queue lengths
     *
     * "The length of the output packet queue (in packets)"
     *
     * @return array The total number of packets in the outbound queues
     */
    public function outQueueLength()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_OUT_QUEUE_LENGTH );
    }
    
    
    
    
    
    /**
     * Get an array of packets received on an interface of unknown protocol
     *
     * "The number of packets received via the interface
     * which were discarded because of an unknown or
     * unsupported protocol."
     *
     * @return array The number of packets received on an interface of unknown protocol
     */
    public function inUnknownProtocols()
    {
        return $this->getSNMP()->walk1d( self::OID_IF_IN_UNKNOWN_PROTOCOLS );
    }

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
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_OTHER = 1;

    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_REGULAR_1822 = 2;

    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_HDH_1822 = 3;

    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_DDN_X25 = 4;

    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_RFC877_X25 = 5;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_ETHERNET_CSMACD = 6;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_ISO88023_CSMACD = 7;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_ISO88024_TOKEN_BUS = 8;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_ISO88025_TOKEN_RING = 9;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_ISO88026_MAN = 10;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_STAR_LAN = 11;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_PROTEON_10MBIT = 12;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_PROTEON_80MBIT = 13;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_HYPERCHANNEL = 14;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_FDDI = 15;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_LAPB = 16;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_SDLC = 17;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_DSL = 18;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_E1 = 19;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_BASIC_ISDN = 20;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_PRIMARY_ISDN = 21;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_PROP_POINT_TO_POINT_SERIAL = 22;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_PPP = 23;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_SOFTWARE_LOOPBACK = 24;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_EON = 25;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_ETHERNET_3MBIT = 26;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_NSIP = 27;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_SLIP = 28;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_ULTRA = 29;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_DS3 = 30;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_SIP = 31;
    
    /**
     * Constant for possible type of an interface
     * @see types()
     */
    const IF_TYPE_FRAME_RELAY = 32;
    
    
    
    /**
     * Text representation of interface types.
     *
     * @see types()
     * @var array Text representations of interface types.
     */
    public static $IF_TYPES = array(
        self::IF_TYPE_OTHER                      => 'other',
        self::IF_TYPE_REGULAR_1822               => 'regular1822',
        self::IF_TYPE_HDH_1822                   => 'hdh1822',
        self::IF_TYPE_DDN_X25                    => 'ddn-x25',
        self::IF_TYPE_RFC877_X25                 => 'rfc877-x25',
        self::IF_TYPE_ETHERNET_CSMACD            => 'ethernet-csmacd',
        self::IF_TYPE_ISO88023_CSMACD            => 'iso88023-csmacd',
        self::IF_TYPE_ISO88024_TOKEN_BUS         => 'iso88024-tokenBus',
        self::IF_TYPE_ISO88025_TOKEN_RING        => 'iso88025-tokenRing',
        self::IF_TYPE_ISO88026_MAN               => 'iso88026-man',
        self::IF_TYPE_STAR_LAN                   => 'starLan',
        self::IF_TYPE_PROTEON_10MBIT             => 'proteon-10Mbit',
        self::IF_TYPE_PROTEON_80MBIT             => 'proteon-80Mbit',
        self::IF_TYPE_HYPERCHANNEL               => 'hyperchannel',
        self::IF_TYPE_FDDI                       => 'fddi',
        self::IF_TYPE_LAPB                       => 'lapb',
        self::IF_TYPE_SDLC                       => 'sdlc',
        self::IF_TYPE_DSL                        => 'ds1',
        self::IF_TYPE_E1                         => 'e1',
        self::IF_TYPE_BASIC_ISDN                 => 'basicISDN',
        self::IF_TYPE_PRIMARY_ISDN               => 'primaryISDN',
        self::IF_TYPE_PROP_POINT_TO_POINT_SERIAL => 'propPointToPointSerial',
        self::IF_TYPE_PPP                        => 'ppp',
        self::IF_TYPE_SOFTWARE_LOOPBACK          => 'softwareLoopback',
        self::IF_TYPE_EON                        => 'eon',
        self::IF_TYPE_ETHERNET_3MBIT             => 'ethernet-3Mbit',
        self::IF_TYPE_NSIP                       => 'nsip',
        self::IF_TYPE_SLIP                       => 'slip',
        self::IF_TYPE_ULTRA                      => 'ultra',
        self::IF_TYPE_DS3                        => 'ds3',
        self::IF_TYPE_SIP                        => 'sip',
        self::IF_TYPE_FRAME_RELAY                => 'frame-relay'
    );
    
    /**
     * Get an array of device interface types
     *
     * @see $IF_TYPES
     * @param boolean $translate If true, return the string representation
     * @return array An array of interface types
    */
    public function types( $translate = false )
    {
        $types = $this->getSNMP()->walk1d( self::OID_IF_TYPE );
    
        if( !$translate )
            return $types;
    
        return $this->getSNMP()->translate( $types, self::$IF_TYPES );
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


