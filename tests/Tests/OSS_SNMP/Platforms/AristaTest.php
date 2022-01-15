<?php
/**
 * Created by PhpStorm.
 * User: barryo
 * Date: 18/04/2017
 * Time: 13:59
 */

namespace Tests\OSS_SNMP\Platforms;

use OSS_SNMP\TestPlatform as TestOSSPlatform;

class AristaTest extends Platform
{

    const ARISTA_A = 'Arista Networks EOS version 4.14.2F running on an Arista Networks DCS-7504';

    public function testAristaA() {

        $p = new TestOSSPlatform( self::ARISTA_A );

        $this->assertEquals( 'Arista', $p->getVendor() );
        $this->assertEquals( 'DCS-7504', $p->getModel() );
        $this->assertEquals( 'EOS', $p->getOs() );
        $this->assertEquals( '4.14.2F', $p->getOsVersion() );
        $this->assertNull( $p->getOsDate() );
    }

    const ARISTA_B = 'Arista Networks EOS version 4.17.3F running on an Arista Networks DCS-7050SX-96-SSD';

    public function testAristaB() {

        $p = new TestOSSPlatform( self::ARISTA_B );

        $this->assertEquals( 'Arista', $p->getVendor() );
        $this->assertEquals( 'DCS-7050SX-96-SSD', $p->getModel() );
        $this->assertEquals( 'EOS', $p->getOs() );
        $this->assertEquals( '4.17.3F', $p->getOsVersion() );
        $this->assertNull( $p->getOsDate() );
    }


}
