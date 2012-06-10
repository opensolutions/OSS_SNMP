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

namespace OSS\SNMP\MIBS\Cisco;

/**
 * A class for performing SNMP V2 queries on Cisco devices
 *
 * @copyright Copyright (c) 2012, Open Source Solutions Limited, Dublin, Ireland
 * @author Barry O'Donovan <barry@opensolutions.ie>
 */
class CDP extends \OSS\SNMP\MIBS\Cisco
{

    const OID_CDP_INTERFACE_ENABLED    = '.1.3.6.1.4.1.9.9.23.1.1.1.1.2';
    const OID_CDP_INTERFACE_NAME       = '.1.3.6.1.4.1.9.9.23.1.1.1.1.6';
    const OID_CDP_NEIGHBOUR_ID         = '.1.3.6.1.4.1.9.9.23.1.2.1.1.6';
    const OID_CDP_NEIGHBOUR_PORT       = '.1.3.6.1.4.1.9.9.23.1.2.1.1.7';
    const OID_CDP_NEIGHBOUR_CAPABILITY = '.1.3.6.1.4.1.9.9.23.1.2.1.1.9';
    const OID_CDP_DEVICE_ID            = '.1.3.6.1.4.1.9.9.23.1.3.4.0';


    /**
     * Get the device's CDP (Cisco Discovery Protocol) ID
     *
     * @return string The device's CDP (Cisco Discovery Protocol) ID
     */
    public function id()
    {
        return $this->getSNMP()->get( self::OID_CDP_DEVICE_ID );
    }


    /**
     * Get the device's interfaces CDP enabled status
     *
     * Applies the TruthValue post processor (self::ppTruthValue()) to turn
     * SNMP values into true / false.
     *
     * @return array The device's interfaces CDP enabled status' (as boolean true / false)
     */
    public function interfaceEnabled()
    {
        return $this->getSNMP()->ppTruthValue( $this->getSNMP()->walk1d( self::OID_CDP_INTERFACE_ENABLED ) );
    }

    /**
     * Get the device's interface names as seen in CDP
     *
     * @return array The device's interface names as seen in CDP
     */
    public function interfaceNames()
    {
        return $this->getSNMP()->walk1d( self::OID_CDP_INTERFACE_NAME );
    }

    /**
     * Get the device's CDP neighbours (by their CDP ID) indexed by the current device's port ID
     *
     * @return array The device's CDP neighbours (by their CDP ID) indexed by the current device's port ID
     */
    public function neighbourId()
    {
        return $this->getSNMP()->subOidWalk( self::OID_CDP_NEIGHBOUR_ID, 15 );
    }

    /**
     * Get the device's CDP neighbours connected port *description* indexed by the current device's port ID
     *
     * E.g. a sample call may return:
     *
     * Array
     * (
     *     [10101] => GigabitEthernet0/1
     *     [10102] => FastEthernet0/2
     *     [10103] => GigabitEthernet1/0/24
     *     [10105] => GigabitEthernet1/0/2
     * )
     *
     * meaning, for example, that our local port with ID 10101 is connected to port GigabitEthernet0/1 on the neighbour
     * connected to that local port. You can discover the neighbour ID via neighbourId().
     *
     * @see neighbourId()
     * @return array The device's CDP neighbours connected port *description* indexed by the current device's port ID
     */
    public function neighbourPort()
    {
        return $this->getSNMP()->subOidWalk( self::OID_CDP_NEIGHBOUR_PORT, 15 );
    }

    /**
     * Get the device's CDP neighbour capabilities (as a decimal integer) indexed by the current device's port ID
     *
     * @return array The device's CDP neighbour capabilities (as a decimal integer) indexed by the current device's port ID
     */
    public function neighbourCapability()
    {
        $rtn = $this->getSNMP()->subOidWalk( self::OID_CDP_NEIGHBOUR_CAPABILITY, 15 );

        foreach( $rtn as $k => $v )
            $rtn[$k] = (int)hexdec( $v );

        return $rtn;
    }

    /**
     * CDP utility function to get all CDP neighbours and their connected ports.
     *
     * Returns an array of neighbours indexed by the neighbour CDP ID. For example:
     *
     *
     * Array
     * (
     *     [cr-sw03.ixdub1.opensolutions.ie] => Array
     *         (
     *            [0] => Array
     *                (
     *                     [localPortId] => 10101
     *                     [localPort] => GigabitEthernet1/0/1
     *                     [remotePort] => GigabitEthernet0/1
     *                 )
     *
     *             [1] => Array
     *                 (
     *                     [localPortId] => 10102
     *                     [localPort] => GigabitEthernet1/0/2
     *                     [remotePort] => FastEthernet0/2
     *                 )
     *
     *         )
     *     [ ... ]
     * )
     *
     * @see neighbourId()
     * @see \OSS\SNMP\MIBS\Interface::descriptions()
     * @see neighbourPort()
     * @return array CDP neighbours and their connected ports
     */
    public function neighbours()
    {
        $neighbours = array();

        foreach( $this->neighbourId() as $localPortId => $neighbourCdpId )
        {
            if( !isset( $neighbours[ $neighbourCdpId ] ) )
            {
                $neighbours[ $neighbourCdpId ] = array();
                $count = 0;
            }
            else
                $count = count( $neighbours[ $neighbourCdpId ] );

            $neighbours[ $neighbourCdpId ][$count]['localPortId']   = $localPortId;
            $neighbours[ $neighbourCdpId ][$count]['localPortName'] = $this->getSNMP()->useIface()->names()[$localPortId];
            $neighbours[ $neighbourCdpId ][$count]['localPort']     = $this->getSNMP()->useIface()->descriptions()[$localPortId];
            $neighbours[ $neighbourCdpId ][$count]['isLAG']         = $this->getSNMP()->useLAG()->isAggregatePorts()[$localPortId];
            $neighbours[ $neighbourCdpId ][$count]['remotePort']    = $this->neighbourPort()[$localPortId];
        }

        return $neighbours;
    }

    /**
     * Recursivily crawls all CDP neighbours to build up a flat array of all devices
     * indexed by the CDP device id.
     *
     * Array form is same as that returned by neighbours()
     *
     * @see neighbours()
     * @param array $devices Unless you're doing something funky, just pass an empty array. This is where the result will be found.
     * @param string $device CDP device ID of next host to crawl. On first pass, set to null - used internally when recursing
     * @param array $ignore An array of CDP device IDs to *ignore*. I.e. to not include in recursive crawling
     * @return array The resultant array of all crawled devices (same as that passed in the @param $devices parameter)
     */
    public function crawl( &$devices = array(), $device = null, $ignore = array() )
    {
        if( !count( $devices ) )
        {
            $device = $this->id();
            $devices[ $device ] = $this->neighbours();
        }

        foreach( $devices[ $device ] as $feNeighbour => $feConnections )
        {
            if( in_array( $feNeighbour, $ignore ) )
            {
                if( isset( $devices[ $device ][$feNeighbour] ) )
                    unset( $devices[ $device ][$feNeighbour] );

                continue;
            }

            if( !isset( $devices[ $feNeighbour ] ) )
            {
                $snmp = new \OSS\SNMP( $feNeighbour, $this->getSNMP()->getCommunity() );
                $devices[ $feNeighbour ] = $snmp->useCisco_CDP()->neighbours();
                unset( $snmp );
                $this->crawl( $devices, $feNeighbour, $ignore );
            }
        }

        return $devices;
    }


    /**
     * Find the layer 2 topology as an array with no link mentioned more than once.
     *
     * Huh? This function:
     *
     * * takes the result of crawl() (or calls crawl()) to get the CDP topology
     * * foreach device, builds an array of device to device links
     * * SO LONG as that link has already not been accounted for in the other direction.
     *
     * I.e. if a link is found A -> B, then the same B -> A link will not be included
     *
     * The array returned is, for example:
     *
     * [cr-sw04.degkcp.example.ie] => Array
     * (
     *      [cd-sw02.degkcp.example.ie] => Array
     *      (
     *          [GigabitEthernet1/0/3] => Array
     *          (
     *              [remotePort] => FastEthernet0/1
     *              [isLAG]      => false
     *      )
     *
     *      [cr-sw03.degkcp.example.ie] => Array
     *      (
     *          [GigabitEthernet1/0/23] => Array
     *          (
     *              [remotePort] => GigabitEthernet1/0/23
     *              [isLAG]      => false
     *          )
     *          [GigabitEthernet1/0/24] => Array
     *          (
     *              [remotePort] => GigabitEthernet1/0/24
     *              [isLAG]      => false
     *          )
     *      )
     * )
     *
     * This tells us that cr-sw04(GigabitEthernet1/0/3) is connected to cd-sw02(FastEthernet0/1).
     *
     * It also tells us that cr-sw04 has two connections to cr-sw03.
     *
     * You'll notice it also tells us if it's a LAG or not. More information can be added as needed.
     *
     * @see crawl()
     * @param array $devices The result of crawl() (if null, this function performs a crawl())
     * @return array L2 topology as described above.
     */
    public function linkTopology( $devices = null )
    {
        if( $devices == null )
            $devices = $this->crawl();

        $links = array();
        foreach( $devices as $feDevice => $feNeighbours )
        {
            foreach( $feNeighbours as $fe2Device => $fe2Links )
            {
                foreach( $fe2Links as $fe2Link )
                {
                    // have we already accounted for this link on the other side?
                    if( isset( $links[ $fe2Device ][ $feDevice ][ $fe2Link['remotePort'] ] ) )
                        continue;

                    if( !isset( $links[ $feDevice ] ) )
                        $links[ $feDevice ] = array();

                    if( !isset( $links[ $feDevice ][ $fe2Device ] ) )
                        $links[ $feDevice ][ $fe2Device ] = array();

                    $links[ $feDevice ][ $fe2Device ][ $fe2Link['localPort'] ] = array();
                    $links[ $feDevice ][ $fe2Device ][ $fe2Link['localPort'] ][ 'remotePort' ] = $fe2Link['remotePort'];
                    $links[ $feDevice ][ $fe2Device ][ $fe2Link['localPort'] ][ 'isLAG' ]      = $fe2Link['isLAG'];
                }
            }
        }

        return $links;
    }
}





















