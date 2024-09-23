<?php
/**
 * Created by PhpStorm.
 * User: barryo
 * Date: 18/04/2017
 * Time: 13:59
 */

namespace Tests\OSS_SNMP\Platforms;

use OSS_SNMP\TestPlatform as TestOSSPlatform;

class HuaweiTest extends Platform
{

    const HUAWEI_A = 'Huawei Integrated Access Software';

    public function testHuaweiA() {

        $p = new TestOSSPlatform( self::HUAWEI_A, '.1.3.6.1.4.1.2011.2.123' );

        $this->assertEquals( $p->getVendor(),    'Huawei' );
        $this->assertNull( $p->getOs() );
        $this->assertEquals( $p->getOsVersion(), 'PHPUnit' );
        $this->assertNull( $p->getOsDate() );
        $this->assertEquals( $p->getModel(),     'MA5603T' );
    }

    const HUAWEI_B = 'HUAWEI TECH. INC. SNMP AGENT FOR MA5300';

    public function testHuaweiB() {

        $p = new TestOSSPlatform( self::HUAWEI_A, '.1.3.6.1.4.1.2011.2.6.6.1' );

        $this->assertEquals( $p->getVendor(),    'Huawei' );
        $this->assertNull( $p->getOs() );
        $this->assertEquals( $p->getOsVersion(), 'PHPUnit' );
        $this->assertNull( $p->getOsDate() );
        $this->assertEquals( $p->getModel(),     'MA5300V1' );
    }

    const HUAWEI_C = 'S6720-30C-EI-24S-AC Huawei Versatile Routing Platform Software VRP (R) software,Version 5.160 (S6720 V200R009C00SPC500) Copyright (C) 2007 Huawei Technologies Co., Ltd.';

    public function testHuaweiC() {

        $p = new TestOSSPlatform( self::HUAWEI_C, '' );

        $this->assertEquals( $p->getVendor(),    'Huawei' );
        $this->assertEquals( $p->getOs(), 'Huawei Versatile Routing Platform Software VRP' );
        $this->assertEquals( $p->getOsVersion(), '5.160' );
        $this->assertNull( $p->getOsDate() );
        $this->assertEquals( $p->getModel(),     'S6720-30C-EI-24S-AC' );
    }

    const HUAWEI_D = 'S6720-54C-EI-48S-AC Huawei Versatile Routing Platform Software VRP (R) software,Version 5.170 (S6720 V200R010C00SPC600) Copyright (C) 2007 Huawei Technologies Co., Ltd.';

    public function testHuaweiD() {

        $p = new TestOSSPlatform( self::HUAWEI_D, '' );

        $this->assertEquals( $p->getVendor(),    'Huawei' );
        $this->assertEquals( $p->getOs(), 'Huawei Versatile Routing Platform Software VRP' );
        $this->assertEquals( $p->getOsVersion(), '5.170' );
        $this->assertNull( $p->getOsDate() );
        $this->assertEquals( $p->getModel(),     'S6720-54C-EI-48S-AC' );
    }

    const HUAWEI_E = 'Huawei Versatile Routing Platform Software
VRP (R) software, Version 8.150 (CE6870EI V200R002C50SPC800)
Copyright (C) 2012-2017 Huawei Technologies Co., Ltd.
HUAWEICE6870-24S6CQ-EI';

    public function testHuaweiE() {

        $p = new TestOSSPlatform( self::HUAWEI_E, '' );

        $this->assertEquals( $p->getVendor(),    'Huawei' );
        $this->assertEquals( $p->getOs(), 'Huawei Versatile Routing Platform Software' );
        $this->assertEquals( $p->getOsVersion(), '8.150' );
        $this->assertNull( $p->getOsDate() );
        $this->assertEquals( $p->getModel(),     'HUAWEICE6870-24S6CQ-EI' );
    }

    // https://github.com/opensolutions/OSS_SNMP/issues/72
    const HUAWEI_F = 'S6720-54C-EI-48S-AC
Huawei Versatile Routing Platform Software
VRP (R) software,Version 5.170 (S6720 V200R010C00SPC600)
Copyright (C) 2007 Huawei Technologies Co., Ltd.';

    public function testHuaweiF() {

        $p = new TestOSSPlatform( self::HUAWEI_F, '' );

        $this->assertEquals( $p->getVendor(),    'Huawei' );
        $this->assertEquals( $p->getOs(), 'Huawei Versatile Routing Platform Software VRP' );
        $this->assertEquals( $p->getOsVersion(), '5.170' );
        $this->assertNull( $p->getOsDate() );
        $this->assertEquals( $p->getModel(),     'S6720-54C-EI-48S-AC' );
    }

    // https://github.com/opensolutions/OSS_SNMP/issues/67
    const HUAWEI_G = 'Huawei Versatile Routing Platform Software
VRP (R) software, Version 8.100 (CE6810LI V100R005C10SPC200)
Copyright (C) 2012-2015 Huawei Technologies Co., Ltd.
HUAWEI CE6810-48S4Q-LI uptime is 1497 days, 5 hours, 7 minutes';

    public function testHuaweiG() {

        $p = new TestOSSPlatform( self::HUAWEI_G, '' );

        $this->assertEquals( 'Huawei', $p->getVendor() );
        $this->assertEquals( 'Huawei Versatile Routing Platform Software', $p->getOs() );
        $this->assertEquals( '8.100', $p->getOsVersion()  );
        $this->assertNull( $p->getOsDate() );
        $this->assertEquals( 'CE6810-48S4Q-LI', $p->getModel()    );
    }

    // https://github.com/opensolutions/OSS_SNMP/issues/79
    const HUAWEI_H = 'Huawei Versatile Routing Platform Software 
VRP (R) software, Version 8.191 (CE6870EI V200R019C10SPC800) 
Copyright (C) 2012-2020 Huawei Technologies Co., Ltd. 
HUAWEI CE6870-48S6CQ-EI';

    public function testHuaweiH() {

        $p = new TestOSSPlatform( self::HUAWEI_H, '' );

        $this->assertEquals( 'Huawei', $p->getVendor() );
        $this->assertEquals( 'Huawei Versatile Routing Platform Software', $p->getOs() );
        $this->assertEquals( '8.191', $p->getOsVersion()  );
        $this->assertNull( $p->getOsDate() );
        $this->assertEquals( 'CE6870-48S6CQ-EI', $p->getModel() );
    }

}
