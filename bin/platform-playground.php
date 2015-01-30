#!/usr/bin/php
<?php

date_default_timezone_set( 'Europe/Dublin' );

//id( 'Brocade NetIron CES, IronWare Version V5.2.0cT183 Compiled on Oct 28 2011 at 02:58:44 labeled as V5.2.00c' );
//id( 'Brocade NetIron MLX (System Mode: MLX), IronWare Version V5.4.0cT163 Compiled on Mar 25 2013 at 17:08:16 labeled as V5.4.00c' );
//id( 'Foundry Networks, Inc. FES12GCF, IronWare Version 04.1.01eTc1 Compiled on Mar 06 2011 at 17:05:36 labeled as FES04101e' );
//id( 'Brocade Communications Systems, Inc. FCX624, IronWare Version 07.2.02aT7f1 Compiled on Feb 16 2011 at 05:29:10 labeled as FCXS07202a' );
id( 'Foundry Networks, Inc. BigIron RX, IronWare Version V2.7.2aT143 Compiled on Sep 29 2009 at 17:15:24 labeled as V2.7.02a' );



function id( $sysDescr )
{
    if( preg_match( '/Foundry Networks, Inc. (.+),\sIronWare\sVersion\s(.+)\sCompiled\son\s(([a-zA-Z]+)\s(\d+)\s(\d+)\s)at\s((\d\d):(\d\d):(\d\d))\slabeled\sas\s(.+)/',
            $sysDescr, $matches ) )
    {
        echo "Vendor:   " . 'Foundry Networks' . "\n";
        echo "Model:    {$matches[1]}\n";
        echo "OS:       IronWare\n";
        echo "OS Ver:   " . $matches[3] . "\n";
        $d = new \DateTime( "{$matches[5]}/{$matches[4]}/{$matches[6]}:{$matches[7]} +0000" );
        $d->setTimezone( new \DateTimeZone( 'UTC' ) );
        echo "OS Date:  " . $d->format( 'Y-m-d H:i:s' ) . "\n\n";
    }
    else if( preg_match( '/Brocade Communication[s]* Systems, Inc. (.+),\s([a-zA-Z]+)\sVersion\s(.+)\sCompiled\son\s(([a-zA-Z]+)\s(\d+)\s(\d+)\s)at\s((\d\d):(\d\d):(\d\d))\slabeled\sas\s(.+)/',
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
