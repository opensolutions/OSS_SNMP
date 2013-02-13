<?php

/*
    Copyright (c) 2013, Open Source Solutions Limited, Dublin, Ireland
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

namespace OSS_SNMP\MIBS\Cisco;

/**
 * A class for performing SNMP V2 queries on Cisco devices
 *
 * @copyright Copyright (c) 2012 - 2013, Open Source Solutions Limited, Dublin, Ireland
 * @author Barry O'Donovan <barry@opensolutions.ie>
 */
class SMST extends \OSS_SNMP\MIBS\Cisco
{

    const OID_STP_X_SMST_MAX_INSTANCES         = '.1.3.6.1.4.1.9.9.82.1.14.1.0'; 
    const OID_STP_X_SMST_MAX_INSTANCE_ID       = '.1.3.6.1.4.1.9.9.82.1.14.2.0'; 
    const OID_STP_X_SMST_REGION_REVISION       = '.1.3.6.1.4.1.9.9.82.1.14.3.0'; 
    
    const OID_STP_X_SMST_REMAINING_HOP_COUNT   = '.1.3.6.1.4.1.9.9.82.1.14.5.1.4'; 

    
    /**
     * Returns the maximum number of MST instances
     *
     * > "The maximum number of MST instances
     * > that can be supported by the device for IEEE MST"
     *
     * @return string The maximum number of MST instances
     */
    public function maxInstances()
    {
        return $this->getSNMP()->get( self::OID_STP_X_SMST_MAX_INSTANCES );
    }

    /**
     * Returns the maximum MST instance ID
     *
     * > "The maximum MST (Multiple Spanning Tree) instance id, 
     * > that can be supported by the device for IEEE MST"
     *
     * @return string The maximum MST instance ID
     */
    public function maxInstanceId()
    {
        return $this->getSNMP()->get( self::OID_STP_X_SMST_MAX_INSTANCE_ID );
    }

    /**
     * Returns the operational SMST region revision.
     *
     * @return string The operational SMST region revision
     */
    public function regionRevision()
    {
        return $this->getSNMP()->get( self::OID_STP_X_SMST_REGION_REVISION );
    }
    

    /**
     * Returns the remaining hop count for all MST instances
     *
     * > "The remaining hop count for this MST instance. If this object
     * > value is not applicable on an MST instance, then the value
     * > retrieved for this object for that MST instance will be -1. 
     * > 
     * > This object is only instantiated when the object value of
     * > stpxSpanningTreeType is mst(4)."
     *
     * @return array The remaining hop count for all MST instances
     */
    public function remainingHopCount()
    {
        return $this->getSNMP()->walk1d( self::OID_STP_X_SMST_REMAINING_HOP_COUNT );
    }
    
    /**
     * Returns an array of running MST instances.
     *
     * This is a hack on the remainingHopCount() as the MIB of this
     * is empty on my test box (.1.3.6.1.4.1.9.9.82.1.14.5.1.1)
     *
     * We name the instances as well based on the region name / use specified string.
     *
     * @param string $name If null, then instances are named using the MST region name. Else this is the root of the name.
     * @return array The running MST instances
     */
    public function instances( $name = null )
    {
        if( $name === null )
            $name = $this->getSNMP()->useCisco_MST()->regionName() . '.';
            
        $hops = $this->remainingHopCount();
        
        $instances = [];
        foreach( $hops as $i => $h )
            if( $h != -1 )
                $instances[ $i ] = "{$name}{$i}";
        
        return $instances;
    }
    


}
