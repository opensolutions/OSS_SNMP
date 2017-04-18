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


}
