<?php

// Works with sysDescr such as:
//
// 'Huawei Integrated Access Software'
// 'HUAWEI TECH. INC. SNMP AGENT FOR MA5300'

if( substr( strtolower($sysDescr), 0, 6 ) == 'huawei' )
{
    $this->setVendor( 'Huawei' );

    switch( $sysObjectId )
    {
        case '.1.3.6.1.4.1.2011.2.123':
            $this->setModel( "MA5603T" );
            break;
        case '.1.3.6.1.4.1.2011.2.169':
            $this->setModel( "MA5616" );
            break;
        case '.1.3.6.1.4.1.2011.2.80.8':
            $this->setModel( "MA5600T" );
            break;
        case '.1.3.6.1.4.1.2011.2.6.6.1':
            $this->setModel( "MA5300V1" );
            break;
        default:
            $this->setModel( null );
    }

    $this->setOs( null );
    $this->setOsVersion( $this->getSNMPHost()->useHuawei_System()->softwareVersion() );
    $this->setOsDate( null );

}