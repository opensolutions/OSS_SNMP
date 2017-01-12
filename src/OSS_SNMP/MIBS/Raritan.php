<?php

/* * ********************************************************************
 * 
 *
 *  CREATED BY MODULESGARDEN       ->        http://modulesgarden.com
 *  AUTHOR                         ->     konrad.bi@modulesgarden.com
 *  CONTACT                        ->       contact@modulesgarden.com
 *
 *
 *
 * This software is furnished under a license and may be used and copied
 * only  in  accordance  with  the  terms  of such  license and with the
 * inclusion of the above copyright notice.  This software  or any other
 * copies thereof may not be provided or otherwise made available to any
 * other person.  No title to and  ownership of the  software is  hereby
 * transferred.
 *
 *
 * ******************************************************************** */

/**
 * Raritan PDU SNMP Driver
 * 
 * @author Konrad Bieda <konrad.bi@modulesgarden.com>
 * @link http://modulesgarden.com ModulesGarden - Top Quality Custom Software Development
 * @package EasyDCIM
 * @license http://www.modulesgarden.com/terms_of_service
 */

namespace OSS_SNMP\MIBS;

class Raritan extends \OSS_SNMP\MIB
{
    const OID_OUT_INDEX                   = '.1.3.6.1.4.1.13742.4.1.2.2.1.1'; //outletIndex [Integer]
    const OID_OUT_NAME                    = '.1.3.6.1.4.1.13742.4.1.2.2.1.2'; //outletLabel [String]
    const OID_OUT_STATUS                  = '.1.3.6.1.4.1.13742.4.1.2.2.1.3'; //outletOperationalState [Integer]
    const OID_OUT_CURRENT                 = '.1.3.6.1.4.1.13742.4.1.2.2.1.4'; //outletCurrent [MilliAmps]
    const OID_OUT_CURRENT_MAX             = '.1.3.6.1.4.1.13742.4.1.2.2.1.5'; //outletMaxCurrent [MilliAmps]
    const OID_OUT_VOLTAGE                 = '.1.3.6.1.4.1.13742.4.1.2.2.1.6'; //outletVoltage [MilliVolts]
    const OID_OUT_ACTIVE_POWER            = '.1.3.6.1.4.1.13742.4.1.2.2.1.7'; //outletActivePower [Watts]
    const OID_OUT_APPARENT_POWER          = '.1.3.6.1.4.1.13742.4.1.2.2.1.8'; //outletApparentPower [VoltAmps]
    const OID_OUT_POWER_FACTOR            = '.1.3.6.1.4.1.13742.4.1.2.2.1.9'; //outletPowerFactor [PowerFactorPercentage]
    const OID_OUT_COMMAND                 = '.1.3.6.1.4.1.13742.4.1.2.2.1.3';

    const OID_OUT_CURRENT_UPPER_WARNING   = '.1.3.6.1.4.1.13742.4.1.2.2.1.20'; //outletCurrentUpperWarning [MilliAmps]
    const OID_OUT_CURRENT_UPPER_CRITICAL  = '.1.3.6.1.4.1.13742.4.1.2.2.1.21'; //outletCurrentUpperCritical [MilliAmps]
    const OID_OUT_CURRENT_LOWER_WARNING   = '.1.3.6.1.4.1.13742.4.1.2.2.1.22'; //outletCurrentLowerWarning [MilliAmps]
    const OID_OUT_CURRENT_LOWER_CRITICAL  = '.1.3.6.1.4.1.13742.4.1.2.2.1.23'; //outletCurrentLowerCritical [MilliAmps]
    const OID_OUT_CURRENT_RATING          = '.1.3.6.1.4.1.13742.4.1.2.2.1.30'; //outletCurrentRating [MilliAmps]
    const OID_OUT_WATT_HOURS              = '.1.3.6.1.4.1.13742.4.1.2.2.1.32'; //outletWattHours [WattHours]
    
    /**
     * Text representation of outlet status
     *
     * @var array Text representations of outlet status.
     */
    public static $OUTLET_STATUSES = array(
        0   => 'down',
        1   => 'up',
        2   => 'reset',
    );
    
    /**
     * Text representation of outlet commands
     *
     * @var array Text representations of outlet command.
     */
    public static $OUTLET_COMMANDS = array(
        'down'      => 0,
        'up'        => 1,
        'reset'     => 2,
    );
    
    /**
     * Text representation of outlet status after perform command
     *
     * @var array Text representations of outlet status after perform command
     */
    public static $OUTLET_ACTION_COMMANDS = array(
        0   => 'down',
        1   => 'up',
        2   => 'reset',
    );
    
     /**
     * Gets general information
     * 
     * @var Executor
     */
    
    public function general()
    {
        return $this->getSNMP()->useSystem()->getAll();
    }
    
    public function interfacesList($outlets = array())
    {
        $indexes    = $this->indexes();
        $names      = $this->names();
        $statuses   = $this->statuses();
        
        $results = array();
        
        foreach ($indexes as $value) 
        {
            if(! empty($outlets))
            {
                if(in_array($value, $outlets))
                {
                    $results[$value]['index'] = $value;
                    $results[$value]['name']  =  $names[$value];
                    $results[$value]['phase'] =  '';
                    $results[$value]['phaseTranslate'] =  '';
                    $results[$value]['state'] =  $statuses[$value];
                    $results[$value]['stateTranslate'] = $this->translate($statuses[$value], self::$OUTLET_STATUSES);
                }
            }
            else
            {
                $results[$value]['index'] = $value;
                $results[$value]['name']  =  $names[$value];
                $results[$value]['phase'] =  '';
                $results[$value]['phaseTranslate'] =  '';
                $results[$value]['state'] =  $statuses[$value];
                $results[$value]['stateTranslate'] = $this->translate($statuses[$value], self::$OUTLET_STATUSES);
            }
        }
        
        return $results;
    }
 
    /**
     * Get an array of device outlets indexes

     * @return array An array of outlets indexes
     */
    public function indexes()
    {
        return $this->getSNMP()->walk1d(self::OID_OUT_INDEX);
    }
    
    /**
     * Get an array of device outltes names

     * @return array An array of outltes names
     */
    public function names()
    {
        return $this->getSNMP()->walk1d(self::OID_OUT_NAME);
    }
    
    /**
     * Get an array of device outlet status
     *
     * If the outlet is on, the outletOn (1) value will be returned.
     * If the outlet is off, the outletOff (2) value will be returned.
     * If the state of the outlet cannot be determined, the outletUnknown (4) value will be returned. 
     * If the outletUnknown condition should occur, all devices powered by the PDU should be shut down. 
     * 
     *
     * @param boolean $translate If true, return the string representation
     * @return array An array of outlet status
     */
    
    public function statuses($translate = false)
    {
        $states = $this->getSNMP()->walk1d(self::OID_OUT_STATUS);

        if( !$translate )
        {
            return $states;
        }
            

        return $this->translate($states, self::$OUTLET_STATUSES);
    }
    
    /**
     * Utility function to translate one value(s) to another via an associated array
     *
     * I.e. all elements '$value' will be replaced with $translator( $value ) where
     * $translator is an associated array.
     *
     * @param mixed $values A scalar or array or values to translate
     * @param array $translator An associated array to use to translate the values
     * @return mixed The translated scalar or array
     */
    
    public static function translate($values, $translator)
    {
        if(! is_array($values))
        {
            if(isset($translator[$values]))
            {
                return $translator[$values];
            }
            else
            {
                return "*** UNKNOWN ***";
            }  
        }

        foreach($values as $k => $v)
        {
            if(isset($translator[$v]))
            {
                $values[$k] = $translator[$v];
            }
            else
            {
                $values[$k] = "*** UNKNOWN ***";
            }   
        }

        return $values;
    }
    
    /**
     * Setting the outlet command
     *
     * Setting to immediateOn (1) will immediately turn the outlet on.
     * Setting to immediateOff (0) will immediately turn the outlet off.
     *
     * @param mixed $value A scalar or array or values to translate
     * @return mixed The translated scalar or array
     */
    
    public function performAction($index, $command)
    {
        $action = array_get(self::$OUTLET_COMMANDS, $command, $command);

        try 
        {
            $this->getSNMP()->set(self::OID_OUT_COMMAND.'.'.$index, $action);
        } 
        catch (\Exception $exc) 
        {
            return array_get(self::$OUTLET_ACTION_COMMANDS, $command, $command);
        }

        $status = $this->status($index, true);

        return $status;
    }
    
    public function status($index, $translate = false)       
    {
        $status = $this->getSNMP()->get(self::OID_OUT_STATUS.'.'.$index);
        
        if( !$translate )
        {
            return $status;
        }

        return $this->translate($status, self::$OUTLET_STATUSES);
    }
    
    public function setOID($oid, $value)
    {
        $this->getSNMP()->set($oid, $value);
    }

}


