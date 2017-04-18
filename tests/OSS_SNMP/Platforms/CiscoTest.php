<?php
/**
 * Created by PhpStorm.
 * User: barryo
 * Date: 18/04/2017
 * Time: 13:59
 */

namespace Tests\OSS_SNMP\Platforms;

use OSS_SNMP\TestPlatform as TestOSSPlatform;

include 'Platform.php';



class CiscoTest extends Platform
{

    const CISCO_A = 'Cisco IOS Software, s72033_rp Software (s72033_rp-ADVENTERPRISE_WAN-VM), Version 12.2(33)SXI5, RELEASE SOFTWARE (fc2)';

    public function testCiscoA() {

        $p = new TestOSSPlatform( self::CISCO_A, '' );

        $this->assertEquals( $p->getVendor(),    'Cisco Systems' );
        $this->assertEquals( $p->getOs(),        'IOS' );
        $this->assertEquals( $p->getOsVersion(), '12.2(33)SXI5' );
        $this->assertEquals( $p->getModel(),     'PHPUnit' );
        $this->assertNull( $p->getOsDate() );
    }



    const CISCO_B = 'Cisco IOS Software, IOS-XE Software, Catalyst 4500 L3 Switch  Software (cat4500es8-UNIVERSAL-M), Version 03.08.02.E RELEASE SOFTWARE (fc2)';

    public function testCiscoB() {

        $p = new TestOSSPlatform( self::CISCO_B, '' );

        $this->assertEquals( $p->getVendor(),    'Cisco Systems' );
        $this->assertEquals( $p->getOs(),        'IOS-XE' );
        $this->assertEquals( $p->getOsVersion(), '03.08.02.E' );
        $this->assertEquals( $p->getModel(),     'Catalyst 4500 L3 Switch' );
        $this->assertNull( $p->getOsDate() );
    }


    const CISCO_C = 'Cisco NX-OS(tm) n9000, Software (n9000-dk9), Version 6.1(2)I2(2b), RELEASE SOFTWARE Copyright (c) 2002-2013 by Cisco Systems, Inc. Compiled 8/7/2014 15:00:00';

    public function testCiscoC() {

        $p = new TestOSSPlatform( self::CISCO_C, '' );

        $this->assertEquals( $p->getVendor(),    'Cisco Systems' );
        $this->assertEquals( $p->getOs(),        'NX-OS' );
        $this->assertEquals( $p->getOsVersion(), '6.1(2)I2(2b)' );
        $this->assertEquals( $p->getModel(),     'n9000' );

        $dt = new \DateTime( "2014/08/07 15:00:00 +0000" );
        $dt->setTimezone( new \DateTimeZone( 'UTC' ) );

        $this->assertEquals( $dt, $p->getOsDate() );
    }

    const CISCO_D = 'Cisco NX-OS(tm) n3500, Software (n3500-uk9), Version 6.0(2)A1(1d), RELEASE SOFTWARE Copyright (c) 2002-2012 by Cisco Systems, Inc. Device Manager Version nms.sro not found, Compiled 1/30/2014 9:00:00';

    public function testCiscoD() {

        $p = new TestOSSPlatform( self::CISCO_D, '' );

        $this->assertEquals( $p->getVendor(),    'Cisco Systems' );
        $this->assertEquals( $p->getOs(),        'NX-OS' );
        $this->assertEquals( $p->getOsVersion(), '6.0(2)A1(1d)' );
        $this->assertEquals( $p->getModel(),     'n3500' );

        $dt = new \DateTime( "2014/01/30 09:00:00 +0000" );
        $dt->setTimezone( new \DateTimeZone( 'UTC' ) );

        $this->assertEquals( $dt, $p->getOsDate() );
    }



}
