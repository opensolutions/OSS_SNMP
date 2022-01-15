<?php
/**
 * Created by PhpStorm.
 * User: barryo
 * Date: 18/04/2017
 * Time: 13:59
 */

namespace Tests\OSS_SNMP\Platforms;

use OSS_SNMP\TestPlatform as TestOSSPlatform;

class JuniperTest extends Platform
{

    const JUNIPER_A = 'Juniper Networks, Inc. ex4500-40f Ethernet Switch, kernel JUNOS 12.3R3.4, Build date: 2013-06-14 01:37:19 UTC Copyright (c) 1996-2013 Juniper Networks, Inc.';

    public function testJuniperA() {

        $p = new TestOSSPlatform( self::JUNIPER_A );

        $this->assertEquals( 'Juniper Networks', $p->getVendor() );
        $this->assertEquals( 'ex4500-40f', $p->getModel() );
        $this->assertEquals( 'JUNOS', $p->getOs() );
        $this->assertEquals( '12.3R3.4', $p->getOsVersion() );
        $this->assertEquals( '2013-06-14 01:37:19', $p->getOsDate()->format('Y-m-d H:i:s') );
    }

}
