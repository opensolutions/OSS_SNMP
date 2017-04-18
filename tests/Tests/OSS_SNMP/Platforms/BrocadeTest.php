<?php
/**
 * Created by PhpStorm.
 * User: barryo
 * Date: 18/04/2017
 * Time: 13:59
 */

namespace Tests\OSS_SNMP\Platforms;

use OSS_SNMP\TestPlatform as TestOSSPlatform;

class BrocadeTest extends Platform
{

    const BROCADE_A = 'Brocade Communications Systems, Inc. FESX624+2XG, IronWare Version 07.3.00cT3e1 Compiled on Apr 25 2012 at 17:01:00 labeled as SXS07300c';

    public function testA() {

        $p = new TestOSSPlatform( self::BROCADE_A, '' );

        $this->assertEquals( $p->getVendor(),    'Brocade' );
        $this->assertEquals( $p->getModel(),     'FESX624+2XG' );
        $this->assertEquals( $p->getOs(),        'IronWare' );
        $this->assertEquals( $p->getOsVersion(), '07.3.00cT3e1' );

        $dt = new \DateTime( "2012/04/25 17:01:00 +0000" );
        $dt->setTimezone( new \DateTimeZone( 'UTC' ) );
        $this->assertEquals( $dt, $p->getOsDate() );
    }

    const BROCADE_B = 'Foundry Networks, Inc. FES12GCF, IronWare Version 04.1.01eTc1 Compiled on Mar 06 2011 at 17:05:36 labeled as FES04101e';

    public function testB() {

        $p = new TestOSSPlatform( self::BROCADE_B, '' );

        $this->assertEquals( 'Foundry Networks', $p->getVendor() );
        $this->assertEquals( 'FES12GCF',         $p->getModel() );
        $this->assertEquals( 'IronWare',         $p->getOs() );
        $this->assertEquals( '04.1.01eTc1',      $p->getOsVersion()  );

        $dt = new \DateTime( "2011/03/06 17:05:36 +0000" );
        $dt->setTimezone( new \DateTimeZone( 'UTC' ) );
        $this->assertEquals( $dt, $p->getOsDate() );
    }

    const BROCADE_C = 'Foundry Networks, Inc. BigIron RX, IronWare Version V2.7.2aT143 Compiled on Sep 29 2009 at 17:15:24 labeled as V2.7.02a';

    public function testC() {

        $p = new TestOSSPlatform( self::BROCADE_C, '' );

        $this->assertEquals( $p->getVendor(),    'Foundry Networks' );
        $this->assertEquals( $p->getModel(),     'BigIron RX' );
        $this->assertEquals( $p->getOs(),        'IronWare' );
        $this->assertEquals( $p->getOsVersion(), 'V2.7.2aT143' );

        $dt = new \DateTime( "2009/09/29 17:15:24 +0000" );
        $dt->setTimezone( new \DateTimeZone( 'UTC' ) );
        $this->assertEquals( $dt, $p->getOsDate() );
    }

}
