#!/usr/bin/php
<?php

date_default_timezone_set( 'Europe/Dublin' );

//id( 'Brocade NetIron CES, IronWare Version V5.2.0cT183 Compiled on Oct 28 2011 at 02:58:44 labeled as V5.2.00c' );
//id( 'Brocade NetIron MLX (System Mode: MLX), IronWare Version V5.4.0cT163 Compiled on Mar 25 2013 at 17:08:16 labeled as V5.4.00c' );
//id( 'Foundry Networks, Inc. FES12GCF, IronWare Version 04.1.01eTc1 Compiled on Mar 06 2011 at 17:05:36 labeled as FES04101e' );
id( 'Brocade Communications Systems, Inc. FCX624S, IronWare Version 08.0.10T7f1 Compiled on Jan 07 2014 at 09:13:59 labeled as FCXS08010' );

function id( $sysDescr )
{
    if( preg_match( '/Brocade Communication[s]* Systems, Inc. (.+),\s([a-zA-Z]+)\sVersion\s(.+)\sCompiled\son\s(([a-zA-Z]+)\s(\d+)\s(\d+)\s)at\s((\d\d):(\d\d):(\d\d))\slabeled\sas\s(.+)/',
            $sysDescr, $matches ) )
    {
        echo "Vendor:   " . 'Brocade' . "\n";
        echo "Model:    {$matches[1]}\n";
        echo "OS:       {$matches[2]}\n";
        echo "OS Ver:   " . $matches[3] . "\n";
        $d = new \DateTime( "{$matches[6]}/{$matches[5]}/{$matches[7]}:{$matches[8]} +0000" );
        $d->setTimezone( new \DateTimeZone( 'UTC' ) );
        echo "OS Date:  " . $d->format( 'Y-m-d H:i:s' ) . "\n\n";

    }
    else
        echo "No match\n\n";
}
