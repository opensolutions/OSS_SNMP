<?php

// Works with sysDescr such as:
//
// 'Huawei Integrated Access Software'
// 'HUAWEI TECH. INC. SNMP AGENT FOR MA5300'
//
// "Huawei Versatile Routing Platform Software
//VRP (R) software, Version 8.150 (CE6870EI V200R002C50SPC800)
//Copyright (C) 2012-2017 Huawei Technologies Co., Ltd.
//HUAWEICE6870-24S6CQ-EI
//"

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
    if( stripos( $sysDescr, 'Huawei Versatile Routing Platform Software' ) !== false ) {
        $this->setOs( 'Huawei Versatile Routing Platform Software' );
    }

    $matches = [];
    preg_match_all( '/^Huawei\s+.*\s+[Vv]ersion\s+([\w\.]+)\s+.*\s+([\w\-]+)\s*$/ims', $sysDescr, $matches );

    if( isset( $matches[1][0] ) ) {
        $this->setOsVersion( $matches[1][0] );
    } else if( $this instanceof \OSS_SNMP\TestPlatform ) {
        $this->setOsVersion('PHPUnit');
    } else {
        $this->setOsVersion($this->getSNMPHost()->useHuawei_System()->softwareVersion());
    }

    if( isset( $matches[2][0] ) ) {
        $this->setModel($matches[2][0]);
    }

    $this->setOsDate( null );

}

// 'S6720-30C-EI-24S-AC Huawei Versatile Routing Platform Software VRP (R) software,Version 5.160 (S6720 V200R009C00SPC500) Copyright (C) 2007 Huawei Technologies Co., Ltd.'
// https://github.com/opensolutions/OSS_SNMP/issues/41
//
// 'S6720-54C-EI-48S-AC Huawei Versatile Routing Platform Software VRP (R) software,Version 5.170 (S6720 V200R010C00SPC600) Copyright (C) 2007 Huawei Technologies Co., Ltd.'
// https://github.com/opensolutions/OSS_SNMP/issues/59
else if( preg_match( '/^(S\d+\-[A-Z0-9\-]+)\s+Huawei Versatile Routing Platform Software\s+VRP \(R\) software,Version ([0-9\.]+) \((S[0-9]+) [A-Z0-9]+\)\s+Copyright \(C\) 2007 Huawei Technologies.*$/',
                $sysDescr, $matches ) ) {

    $this->setVendor( 'Huawei' );
    $this->setModel( $matches[1] );
    $this->setOs( 'Huawei Versatile Routing Platform Software VRP' );
    $this->setOsVersion( $matches[2] );
    $this->setOsDate( null );
}
