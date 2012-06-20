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

namespace OSS_SNMP\MIBS\Asterisk;

/**
 * A class for performing SNMP V2 queries on Asterisk
 *
 * @see https://wiki.asterisk.org/wiki/display/AST/Asterisk+MIB+Definitions
 * @copyright Copyright (c) 2012, Open Source Solutions Limited, Dublin, Ireland
 * @author Barry O'Donovan <barry@opensolutions.ie>
 */
class Channels extends \OSS_SNMP\MIB
{

    const OID_ASTERISK_CHANNELS_ACTIVE      = '.1.3.6.1.4.1.22736.1.5.1.0';

    const OID_ASTERISK_CHANNELS_SUPPORTED   = '.1.3.6.1.4.1.22736.1.5.3.0';

    const OID_ASTERISK_CHANNEL_TYPE_NAME        = '.1.3.6.1.4.1.22736.1.5.4.1.2';
    const OID_ASTERISK_CHANNEL_TYPE_DESCRIPTION = '.1.3.6.1.4.1.22736.1.5.4.1.3';
    const OID_ASTERISK_CHANNEL_TYPE_STATE       = '.1.3.6.1.4.1.22736.1.5.4.1.4';
    const OID_ASTERISK_CHANNEL_TYPE_INDICATION  = '.1.3.6.1.4.1.22736.1.5.4.1.5';
    const OID_ASTERISK_CHANNEL_TYPE_TRANSFER    = '.1.3.6.1.4.1.22736.1.5.4.1.6';
    const OID_ASTERISK_CHANNEL_TYPE_CHANNELS    = '.1.3.6.1.4.1.22736.1.5.4.1.7';

    const OID_ASTERISK_CHANNELS_BRIDGED     = '.1.3.6.1.4.1.22736.1.5.5.1.0';

    /**
     * Returns the current number of active channels.
     *
     * > Current number of active channels.
     *
     * @return int The current number of active channels.
     */
    public function active()
    {
        return $this->getSNMP()->get( self::OID_ASTERISK_CHANNELS_ACTIVE );
    }


    /**
     * Returns the number of channel types (technologies) supported.
     *
     * > Number of channel types (technologies) supported.
     *
     * @return int The number of channel types (technologies) supported.
     */
    public function supported()
    {
        return $this->getSNMP()->get( self::OID_ASTERISK_CHANNELS_SUPPORTED );
    }


    /**
     * Array of supported channel type names
     *
     * > Unique name of the technology we are describing.
     *
     * @return array Supported channel type names
     */
    public function names()
    {
        return $this->getSNMP()->walk1d( self::OID_ASTERISK_CHANNEL_TYPE_NAME );
    }

    /**
     * Array of supported channel type descriptions
     *
     * > Description of the channel type (technology).
     *
     * @return array Supported channel type descriptions
     */
    public function descriptions()
    {
        return $this->getSNMP()->walk1d( self::OID_ASTERISK_CHANNEL_TYPE_DESCRIPTION );
    }

    /**
     * Array of supported channel type device state capability
     *
     * > Whether the current technology can hold device states.
     *
     * @return array Whether the current technology can hold device states.
     */
    public function deviceStates()
    {
        return $this->getSNMP()->ppTruthValue( $this->getSNMP()->walk1d( self::OID_ASTERISK_CHANNEL_TYPE_STATE ) );
    }

    /**
     * Array of supported channel type progress indication capability
     *
     * > Whether the current technology supports progress indication.
     *
     * @return array Whether the current technology supports progress indication.
     */
    public function progressIndications()
    {
        return $this->getSNMP()->ppTruthValue( $this->getSNMP()->walk1d( self::OID_ASTERISK_CHANNEL_TYPE_INDICATION ) );
    }

    /**
     * Array of supported channel type transfer capability
     *
     * > Whether the current technology supports transfers, where
     * > Asterisk can get out from inbetween two bridged channels.
     *
     * @return array Whether the current technology transfers
     */
    public function transfers()
    {
        return $this->getSNMP()->ppTruthValue( $this->getSNMP()->walk1d( self::OID_ASTERISK_CHANNEL_TYPE_TRANSFER ) );
    }

    /**
     * Array of active calls on supported channels
     *
     * > Number of active channels using the current technology.
     *
     * @return array Active calls on supported channels
     */
    public function activeCalls()
    {
        return $this->getSNMP()->walk1d( self::OID_ASTERISK_CHANNEL_TYPE_CHANNELS );
    }

    /**
     * Number of channels currently in a bridged state.
     *
     * > Number of channels currently in a bridged state.
     *
     * @return int Array of active calls on supported channels
     */
    public function bridged()
    {
        return $this->getSNMP()->get( self::OID_ASTERISK_CHANNELS_BRIDGED );
    }

    /**
     * Utility function to gather channel details together in an associative array.
     *
     * Returns an array of support channel types. For example:
     *
     *     Array
     *     (
     *         ....
     *         [SIP] => Array
     *             (
     *                 [name] => SIP
     *                 [index] => 5
     *                 [description] => Session Initiation Protocol (SIP)
     *                 [hasDeviceState] => 1
     *                 [hasProgressIndications] => 1
     *                 [canTransfer] => 1
     *                 [activeCalls] => 0
     *             )
     *         ....
     *     )
     *
     * If you chose to index by SNMP table entries, the above element would be indexed with `5` rather than `SIP`.
     *
     * @param bool $useIndex If true, the array is indexed using the SNMP table index rather than the unique channel type name
     * @return array Channel details as an associative array
     */
    public function details( $useIndex = false )
    {
        $details = [];

        foreach( $this->names() as $index => $name )
        {
            if( $useIndex )
                $idx = $index;
            else
                $idx = $name;

            $details[ $idx ]['name']                   = $name;
            $details[ $idx ]['index']                  = $index;
            $details[ $idx ]['description']            = $this->descriptions()[$index];
            $details[ $idx ]['hasDeviceState']         = $this->deviceStates()[$index];
            $details[ $idx ]['hasProgressIndications'] = $this->progressIndications()[$index];
            $details[ $idx ]['canTransfer']            = $this->transfers()[$index];
            $details[ $idx ]['activeCalls']            = $this->activeCalls()[$index];
        }

        return $details;
    }



}
