<?php

/**
 * APC SNMP Driver
 * 
 * @author Dominik Gacek <gac3k@yahoo.pl>
 */

namespace OSS_SNMP\MIBS;

class Apc extends \OSS_SNMP\MIB
{
    const OID_OUT_INDEX                   = '.1.3.6.1.4.1.318.1.1.12.3.5.1.1.1';
    const OID_OUT_NAME                    = '.1.3.6.1.4.1.318.1.1.12.3.5.1.1.2';
    const OID_OUT_STATUS                  = '.1.3.6.1.4.1.318.1.1.4.4.2.1.3';
    const OID_OUT_PHASE                   = '.1.3.6.1.4.1.318.1.1.12.3.3.1.1.3';
    const OID_OUT_COMMAND                 = '.1.3.6.1.4.1.318.1.1.12.3.3.1.1.4';
    const OID_OUT_LOAD                    = '.1.3.6.1.4.1.318.1.1.12.2.3.1.1.2.1';
    
    const OID_PDU_MODEL                   = '.1.3.6.1.4.1.318.1.1.4.1.4.0';
    const OID_PDU_UPTIME                  = '.1.3.6.1.2.1.1.3.0';
    const OID_PDU_FIRMWARE                = '.1.3.6.1.4.1.318.1.1.12.1.3.0';
    const OID_PDU_MAN_DATE                = '.1.3.6.1.4.1.318.1.1.12.1.4.0';
    
    /**
     * Text representation of outlet status
     *
     * @var array Text representations of outlet status.
     */
    public static $OUTLET_STATUSES = array(
        1   => 'outletOn',
        2   => 'outletOff',
        3   => 'outletReboot',
        4   => 'outletUnknown',
        5   => 'outletOnWithDelay',
        6   => 'outletOffWithDelay',
        7   => 'outletRebootWithDelay',
    );
    
    /**
     * Text representation of outlet phases
     *
     * @var array Text representations of outlet phase.
     */
    public static $OUTLET_PHASES = array(
        1   => 'phase1',
        2   => 'phase2',
        3   => 'phase3',
        4   => 'phase1-2',
        5   => 'phase2-3',
        6   => 'phase3-1',
    );
    
    /**
     * Text representation of outlet commands
     *
     * @var array Text representations of outlet command.
     */
    public static $OUTLET_COMMANDS = array(
        1   => 'immediateOn',
        2   => 'immediateOff',
        3   => 'immediateReboot',
        4   => 'delayedOn',
        5   => 'delayedOff',
        6   => 'delayedReboot',
        7   => 'cancelPendingCommand',
    );
    
    /**
     * Text representation of outlet status after perform command
     *
     * @var array Text representations of outlet status after perform command
     */
    public static $OUTLET_ACTION_COMMANDS = array(
        1   => 'outletOn',
        2   => 'outletOff',
        3   => 'outletReboot',
        4   => 'outletOnWithDelay',
        5   => 'outletOffWithDelay',
        6   => 'outletRebootWithDelay',
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
        $phases     = $this->phases();
        
        $results = array();
        
        foreach ($indexes as $value) 
        {
            if(! empty($outlets))
            {
                if(in_array($value, $outlets))
                {
                    $results[$value]['index'] = $value;
                    $results[$value]['name']  =  $names[$value];
                    $results[$value]['phase'] =  $phases[$value];
                    $results[$value]['phaseTranslate'] =  $this->translate($phases[$value], self::$OUTLET_PHASES);
                    $results[$value]['state'] =  $statuses[$value];
                    $results[$value]['stateTranslate'] = $this->translate($statuses[$value], self::$OUTLET_STATUSES);
                }
            }
            else
            {
                $results[$value]['index'] = $value;
                $results[$value]['name']  =  $names[$value];
                $results[$value]['phase'] =  $phases[$value];
                $results[$value]['phaseTranslate'] =  $this->translate($phases[$value], self::$OUTLET_PHASES);
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
     * Get an array of device outlet phases
     *
     * The phase/s associated with this outlet.
     * For single phase devices, this object will always return phase1(1).
     * For 3-phase devices, this object will return phase1 (1), phase2 (2), or phase3 (3) for outlets tied to a single phase.  
     * For outlets tied to two phases, this object will return phase1-2 (4) for phases 1 and 2, phase2-3 (5) for phases 2 and 3, 
     * and phase3-1 (6) for phases 3 and 1.. 
     *
     * @param boolean $translate If true, return the string representation
     * @return array An array of outlet phases
     */
    
    public function phases($translate = false)
    {
        $phases = $this->getSNMP()->walk1d(self::OID_OUT_PHASE);

        if( !$translate )
        {
            return $phases;
        }
            

        return $this->translate($phases, self::$OUTLET_PHASES);
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
     * Setting to immediateOff (2) will immediately turn the outlet off.
     * Setting to immediateReboot (3) will immediately reboot the outlet.
     * Setting to delayedOn (4) will turn the outlet on after the rPDUOutletConfigPowerOnTime OID time has elapsed.
     * Setting to delayedOff (5) will turn the outlet off after the rPDUOutletConfigPowerOffTime OID time has elapsed.
     * Setting to delayedReboot  (6) will cause the Switched Rack PDU to perform a delayedOff command, wait the rPDUOutletConfigRebootDuration OID time, and then perform a delayedOn command.
     * Setting to cancelPendingCommand (7) will cause any pending command to this outlet to be canceled.
     *
     * @param mixed $value A scalar or array or values to translate
     * @return mixed The translated scalar or array
     */
    
    public function performAction($index, $command)
    {
        if(is_string($command))
        {
            $command = array_search($command, self::$OUTLET_COMMANDS);
        }
        
        try 
        {
            $this->getSNMP()->set(self::OID_OUT_COMMAND.'.'.$index, $command);
        } 
        catch (\Exception $exc) 
        {
            return array_get(self::$OUTLET_ACTION_COMMANDS, $command, 'Unknown');
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
    
    public function load() 
    {
        return $this->getSNMP()->get(self::OID_OUT_LOAD);
    }
    
    public function uptime() 
    {
        return $this->getSNMP()->get(self::OID_PDU_UPTIME);
    }
    
    public function firmware() 
    {
        return $this->getSNMP()->get(self::OID_PDU_FIRMWARE);
    }
    
    public function model() 
    {
        return $this->getSNMP()->get(self::OID_PDU_MODEL);
    }
    
    public function dataOfManufactor() 
    {
        return $this->getSNMP()->get(self::OID_PDU_MAN_DATE);
    }
    
    public function setOID($oid, $value)
    {
        $this->getSNMP()->set($oid, $value);
    }
}