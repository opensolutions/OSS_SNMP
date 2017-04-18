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

}
