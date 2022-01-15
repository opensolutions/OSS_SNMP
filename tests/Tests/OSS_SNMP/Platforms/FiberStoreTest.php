<?php
/**
 * Created by PhpStorm.
 * User: barryo
 * Date: 18/04/2017
 * Time: 13:59
 */

namespace Tests\OSS_SNMP\Platforms;

use OSS_SNMP\TestPlatform as TestOSSPlatform;

class FiberStoreTest extends Platform
{

    const FIBERSTORE_A = 'FSOS software, S5850 software (S5850 48S6Q), Version 7.2.2
Copyright (C) 2019 by FS.COM. All rights reserved.
Compiled Dec 10 09:12:14 2019';

    public function testFiberStoreA() {

        $p = new TestOSSPlatform( self::FIBERSTORE_A, '.1.3.6.1.4.1.52642.99.5803' );

        $this->assertEquals( 'FiberStore', $p->getVendor() );
        $this->assertEquals( 'FSOS', $p->getOs() );
        $this->assertEquals( '7.2.2', $p->getOsVersion() );
        $this->assertNull( $p->getOsDate() );
        $this->assertEquals( 'S5850 48S6Q', $p->getModel() );
    }
}
