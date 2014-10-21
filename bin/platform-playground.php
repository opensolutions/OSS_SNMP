#!/usr/bin/php
<?php

date_default_timezone_set( 'Europe/Dublin' );

//id( 'Brocade NetIron CES, IronWare Version V5.2.0cT183 Compiled on Oct 28 2011 at 02:58:44 labeled as V5.2.00c' );
//id( 'Brocade NetIron MLX (System Mode: MLX), IronWare Version V5.4.0cT163 Compiled on Mar 25 2013 at 17:08:16 labeled as V5.4.00c' );
//id( 'Foundry Networks, Inc. FES12GCF, IronWare Version 04.1.01eTc1 Compiled on Mar 06 2011 at 17:05:36 labeled as FES04101e' );
id( 'ProCurve J4903A Switch 2824, revision I.08.98, ROM I.08.07 (/sw/code/build/mako(ts_08_5))' );

function id( $sysDescr )
{
    if( preg_match( '/ProCurve (\w+) Switch ([0-9]+), revision ([A-Z0-9\.]+), ROM [A-Z0-9\.]+ .*/',
            $sysDescr, $matches ) )
    {
        echo "Vendor:   " . 'HP' . "\n";
        echo "Model:    Procurve Switch {$matches[2]} ({$matches[1]})\n";
        echo "OS:       " . 'ProCurve' . "\n";
        echo "OS Ver:   " . $matches[3] . "\n";
        //$d = new \DateTime( "{$matches[5]}/{$matches[4]}/{$matches[6]}:{$matches[7]} +0000" );
        //$d->setTimezone( new \DateTimeZone( 'UTC' ) );
        echo "OS Date:  (unknown)\n\n"; // . $d->format( 'Y-m-d H:i:s' ) . "\n\n";
    }
    else
        echo "No match\n\n";
}
