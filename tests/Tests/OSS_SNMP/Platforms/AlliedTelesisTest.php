<?php
/**
 */

namespace Tests\OSS_SNMP\Platforms;

use OSS_SNMP\TestPlatform as TestOSSPlatform;

class AlliedTelesisTest extends Platform
{

    const AT_A = 'Allied Telesis router/switch, AW+ v5.4.7-2.5';

    public function testA() {

        $p = new TestOSSPlatform( self::AT_A, '' );

        $this->assertEquals( $p->getVendor(),    'Allied Telesis' );
        $this->assertEquals( $p->getModel(),     'Unknown' );
        $this->assertEquals( $p->getOs(),        'AW+' );
        $this->assertEquals( $p->getOsVersion(), '5.4.7-2.5' );

        $this->assertNull( $p->getOsDate() );
    }

}
