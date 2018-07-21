<?php
/**
 * Created by PhpStorm.
 * User: barryo
 * Date: 18/04/2017
 * Time: 13:59
 */

namespace Tests\OSS_SNMP\Platforms;

use OSS_SNMP\TestPlatform as TestOSSPlatform;

class IgniteNetTest extends Platform
{

    const IGNITENET_A = 'FNS-SFP-24';

    public function testIgnitenetA() {

        $p = new TestOSSPlatform( self::IGNITENET_A, '.1.3.6.1.4.1.259.6.10.120' );

        $this->assertEquals( $p->getVendor(),    'IgniteNet' );
        $this->assertNull( $p->getOs() );
        $this->assertNull( $p->getOsVersion() );
        $this->assertNull( $p->getOsDate() );
        $this->assertEquals( $p->getModel(),     'FNS-SFP-24' );
    }

}
