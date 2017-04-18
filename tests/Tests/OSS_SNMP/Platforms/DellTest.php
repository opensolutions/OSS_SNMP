<?php
/**
 * Created by PhpStorm.
 * User: barryo
 * Date: 18/04/2017
 * Time: 13:59
 */

namespace Tests\OSS_SNMP\Platforms;

use OSS_SNMP\TestPlatform as TestOSSPlatform;

class DellTest extends Platform
{

    const DELL_A = 'Dell Force10 OS Operating System Version: 1.0 Application Software Version: 8.3.12.1 Series: S4810 Copyright (c) 1999-2012 by Dell Inc. All Rights Reserved. Build Time: Sun Nov 18 11:05:15 2012';

    public function testA() {

        $p = new TestOSSPlatform( self::DELL_A, '' );

        $this->assertEquals( $p->getVendor(),    'Dell Force10' );
        $this->assertEquals( $p->getModel(),     'S4810' );
        $this->assertEquals( $p->getOs(),        'FTOS 1.0' );
        $this->assertEquals( $p->getOsVersion(), '8.3.12.1' );

        $dt = new \DateTime( "2012/11/18 11:05:15 +0000" );
        $dt->setTimezone( new \DateTimeZone( 'UTC' ) );
        $this->assertEquals( $dt, $p->getOsDate() );
    }

    const DELL_B = 'Dell Networking OS Operating System Version: 2.0 Application Software Version: 9.6(0.0) Series: S4810 Copyright (c) 1999-2014 by Dell Inc. All Rights Reserved. Build Time: Sun Sep 28 10:02:15 2014';

    public function testB() {

        $p = new TestOSSPlatform( self::DELL_B, '' );

        $this->assertEquals( $p->getVendor(),    'Dell Networking' );
        $this->assertEquals( $p->getModel(),     'S4810' );
        $this->assertEquals( $p->getOs(),        'FTOS 2.0' );
        $this->assertEquals( $p->getOsVersion(), '9.6(0.0)' );

        $dt = new \DateTime( "2014/09/28 10:02:15 +0000" );
        $dt->setTimezone( new \DateTimeZone( 'UTC' ) );
        $this->assertEquals( $dt, $p->getOsDate() );
    }

}
