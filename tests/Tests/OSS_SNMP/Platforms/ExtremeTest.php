<?php
/**
 * Created by PhpStorm.
 * User: barryo
 * Date: 18/04/2017
 * Time: 13:59
 */

namespace Tests\OSS_SNMP\Platforms;

use OSS_SNMP\TestPlatform as TestOSSPlatform;

class ExtremeTest extends Platform
{

    const EXTREME_A = 'ExtremeXOS (X460-48t) version 15.2.2.7 v1522b7-patch1-1 by release-manager on Tue Nov 20 17:14:11 EST 2012';

    public function testExtremeA() {

        $p = new TestOSSPlatform( self::EXTREME_A );

        $this->assertEquals( 'Extreme Networks', $p->getVendor() );
        $this->assertEquals( 'X460-48t', $p->getModel() );
        $this->assertEquals( 'ExtremeXOS', $p->getOs() );
        $this->assertEquals( '15.2.2.7 v1522b7-patch1-1', $p->getOsVersion() );
        $this->assertEquals( '2012-11-20 17:14:11', $p->getOsDate()->setTimeZone( new \DateTimeZone('UTC') )->format('Y-m-d H:i:s') );
    }

    const EXTREME_B = 'ExtremeXOS (X460-48x) version 15.2.2.7 v1522b7-patch1-6 by release-manager on Thu Jan 31 11:11:52 EST 2013';

    public function testExtremeB() {

        $p = new TestOSSPlatform( self::EXTREME_B );

        $this->assertEquals( 'Extreme Networks', $p->getVendor() );
        $this->assertEquals( 'X460-48x', $p->getModel() );
        $this->assertEquals( 'ExtremeXOS', $p->getOs() );
        $this->assertEquals( '15.2.2.7 v1522b7-patch1-6', $p->getOsVersion() );
        $this->assertEquals( '2013-01-31 11:11:52', $p->getOsDate()->setTimeZone( new \DateTimeZone('UTC') )->format('Y-m-d H:i:s') );
    }

    const EXTREME_C = 'ExtremeXOS (X670V-48x) version 15.2.2.7 v1522b7-patch1-6 by release-manager on Thu Jan 31 11:11:52 EST 2013';

    public function testExtremeC() {

        $p = new TestOSSPlatform( self::EXTREME_C );

        $this->assertEquals( 'Extreme Networks', $p->getVendor() );
        $this->assertEquals( 'X670V-48x', $p->getModel() );
        $this->assertEquals( 'ExtremeXOS', $p->getOs() );
        $this->assertEquals( '15.2.2.7 v1522b7-patch1-6', $p->getOsVersion() );
        $this->assertEquals( '2013-01-31 11:11:52', $p->getOsDate()->setTimeZone( new \DateTimeZone('UTC') )->format('Y-m-d H:i:s') );
    }

    const EXTREME_D = 'ExtremeXOS version 12.5.3.9 v1253b9 by release-manager on Tue Apr 26 20:36:04 PDT 2011';

    public function testExtremeD() {

        $p = new TestOSSPlatform( self::EXTREME_D );

        $this->assertEquals( 'Extreme Networks', $p->getVendor() );
        $this->assertEquals( 'PHPunit', $p->getModel() );
        $this->assertEquals( 'ExtremeXOS', $p->getOs() );
        $this->assertEquals( '12.5.3.9 v1253b9', $p->getOsVersion() );
        $this->assertEquals( '2011-04-26 20:36:04', $p->getOsDate()->setTimeZone( new \DateTimeZone('UTC') )->format('Y-m-d H:i:s') );
    }

    // https://github.com/opensolutions/OSS_SNMP/issues/61
    const EXTREME_E = 'Extreme BR-SLX9850-4 Router, SLX Operating System Version 18r.1.00a.';

    public function testExtremeE() {

        $p = new TestOSSPlatform( self::EXTREME_E );

        $this->assertEquals( 'Extreme Networks', $p->getVendor() );
        $this->assertEquals( 'BR-SLX9850-4', $p->getModel() );
        $this->assertEquals( 'SLX', $p->getOs() );
        $this->assertEquals( '18r.1.00a', $p->getOsVersion() );
        $this->assertNull( $p->getOsDate() );
    }

    const EXTREME_F = 'ExtremeXOS (X670G2-48x-4q) version 31.7.2.28 31.7.2.28-patch1-75 by release-manager on Mon Jan 15 08:57:00 EST 2024';

    public function testExtremeF() {

        $p = new TestOSSPlatform( self::EXTREME_F );

        $this->assertEquals( 'Extreme Networks', $p->getVendor() );
        $this->assertEquals( 'X670G2-48x-4q', $p->getModel() );
        $this->assertEquals( 'ExtremeXOS', $p->getOs() );
        $this->assertEquals( '31.7.2.28 31.7.2.28-patch1-75', $p->getOsVersion() );
        $this->assertNotNull( $p->getOsDate() );
    }

    const EXTREME_G = 'ExtremeXOS (X670G2-48x-4q) version 31.7.3.37 31.7.3.37 by release-manager on Fri 23 Feb 2024 08:17:22 AM UTC';

    public function testExtremeG() {

        $p = new TestOSSPlatform( self::EXTREME_G );

        $this->assertEquals( 'Extreme Networks', $p->getVendor() );
        $this->assertEquals( 'X670G2-48x-4q', $p->getModel() );
        $this->assertEquals( 'ExtremeXOS', $p->getOs() );
        $this->assertEquals( '31.7.3.37 31.7.3.37', $p->getOsVersion() );
        $this->assertNotNull( $p->getOsDate() );
    }
}
