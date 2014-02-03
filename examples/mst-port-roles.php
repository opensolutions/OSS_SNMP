#! /usr/bin/php
<?php

/*
    Copyright (c) 2012, Open Source Solutions Limited, Dublin, Ireland
    All rights reserved.

    Contact: Barry O'Donovan - barry (at) opensolutions (dot) ie
    http://www.opensolutions.ie/

    This file is part of the OSS_SNMP package.

    Redistribution and use in source and binary forms, with or without
    modification, are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright
    notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
    notice, this list of conditions and the following disclaimer in the
    documentation and/or other materials provided with the distribution.
    * Neither the name of Open Source Solutions Limited nor the
    names of its contributors may be used to endorse or promote products
    derived from this software without specific prior written permission.

    THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
    ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
    WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
    DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY
    DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
    (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
    LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
    ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
    (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
    SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

// This is an example script (in practical use by the author) which demonstrates
// OSS_SNMP's MST querying capabilities. See the following link for more details
// and a screenshot:
//
// 

// SNMP community of the devices. Assumes all devices have the same community.
// Script can easiy be augmented to put this detail in the $ports array below.
$community = 'public';

// Array or arrays of switches and ports to collect MST information from.
//
// Format of each individual port array is:
//
// [
//     'host'     => 'hostname or IP address of device',
//     'port'     => ifName of the port to query
//     'linkedTo' => index of another port array to which this port connects.
//                   Set to null to ignore. Displayed the connected to in the
//                   output which can be useful.
// ]
//
$ports = [
    0   => [ 'host' => 'sw01',             'port' => 'Gi1/1/1',  'linkedTo' => 10   ],
    10  => [ 'host' => 'sw01.example.com', 'port' => 'Gi0/11',   'linkedTo' => 0    ],
    20  => [ 'host' => '192.0.2.67',       'port' => 'Gi1/0/6',  'linkedTo' => null ],
    // ...
];

// Path to your OSS_SNMP installation.
// https://github.com/opensolutions/OSS_SNMP
require_once( dirname( __FILE__ ) . '/../OSS_SNMP/SNMP.php' );


///////////
// No need to change anything else from here.
///////////


// array of OSS_SNMP host objects
$hosts = [];

// array of MST instances on each host (indexed by hostname / IP from $ports array)
$hosts_msts = [];

// array of MST port roles per MST instance for each host (indexed by hostname / IP from $ports array)
$hosts_msts_portroles = [];

// maps ifName to ifIndex as we allow ports to be specified by ifName for ease of use
$portNameToIndex = [];


// iterate over each port array (from $ports) and:
//   - instantiate the OSS_SNMP object for the device (once per device)
//   - populate the $hosts_msts array with device MST instance information
//   - populate the port ifName to ifIndex array
//   - get the port roles for all MST instances on the device
//
foreach( $ports as $id => $conf )
{
    if( !isset( $hosts[ $conf['host'] ] ) )
    {
        $hosts[ $conf['host'] ] = new \OSS_SNMP\SNMP( $conf['host'], $community );
        $hosts_msts[ $conf['host'] ] = $hosts[ $conf['host'] ]->useCisco_SMST()->instances( '' );
        $portNameToIndex[ $conf['host'] ] = array_flip( $hosts[ $conf['host'] ]->useIface()->names() );

        foreach( $hosts_msts[ $conf['host'] ] as $id => $instance )
            $hosts_msts_portroles[ $conf['host'] ][$instance] = $hosts[ $conf['host'] ]->useCisco_MST()->portRoles( $instance, true );
    }
}

// For our tabular output, we need to know what the maximum instance number is:
$maxMstInstance = 0;
foreach( $hosts_msts as $msts )
    if( max( $msts ) > $maxMstInstance )
        $maxMstInstance = max( $msts );

// Format and print our table header:
$title = "Device           - Port    :\tStatus Speed ";
for( $i = 0; $i <= $maxMstInstance; $i++ )
    $title .= sprintf( "MST%-9d", $i );

$title .= '  Connected to              ';

echo "{$title}\n";
echo str_repeat( '=', strlen( $title ) ) . "\n";

// Bash colouring.
// Ref: http://www.if-not-true-then-false.com/2010/php-class-for-coloring-php-command-line-cli-scripts-output-php-output-colorizing-using-bash-shell-colors/
function bashColour( $text, $fgColour ) {
    $colours = [
        'green' => '0;32',
        'red'   => '0;31'
    ];

    return "\033[{$colours[$fgColour]}m{$text}\033[0m";
}

// closure to print coloured port state of a specified column width
$colourisedPortState = function( $state, $width ) {
    $td = $state;
    while( strlen( $td ) < $width )
        $td .= ' ';

    if( $state == 'up' )
        return bashColour( $td, 'green' );
    else
        return bashColour( $td, 'red' );
};

// closure to print colours MST port roles of a specified column width
$colourisedMSTPortRole = function( $role, $width ) {
    $td = $role;
    while( strlen( $td ) < $width )
        $td .= ' ';

    switch( $role )
    {
        case 'designated':
            return bashColour( $td, 'green' );
            
        case 'root':
            return bashColour( $td, 'green' );

        case 'alternate':
            return bashColour( $td, 'red' );
    }

    return $td;
};

// iterate over all the ports we are insterested in and print its row:
foreach( $ports as $id => $conf )
{
    $ifIndex = $portNameToIndex[ $conf['host'] ][ $conf['port'] ];

    // print hostname/IP, port, port state, and port speed
    echo sprintf( "%-16s - %-8s:\t%s %-5s ", $conf['host'], $conf['port'], 
        $colourisedPortState( $hosts[ $conf['host'] ]->useIface()->operationStates( true )[ $ifIndex ], 6 ),
        $hosts[ $conf['host'] ]->useIface()->speeds()[$ifIndex] / 1000 / 1000 
    );

    // print MST port role 
    for( $i = 0; $i <= max( $hosts_msts[ $conf['host'] ] ); $i++ )
    {
        if( !isset( $hosts_msts[ $conf['host'] ][ $i ] ) )
            echo '- mst n/a - ';
        else if( !isset( $hosts_msts_portroles[ $conf['host'] ][ $i ][ $ifIndex ] ) )
            echo '- port n/a- ';
        else
            echo $colourisedMSTPortRole( $hosts_msts_portroles[ $conf['host'] ][ $i ][ $ifIndex ], 12 );
    }

    while( $i <= $maxMstInstance )
    {
        echo '- mst n/a - ';
        $i++;
    }

    echo '  ';

    if( $conf['linkedTo'] !== null )
        echo $ports[ $conf['linkedTo'] ]['host'] . ':' . $ports[ $conf['linkedTo'] ]['port'];
    
    echo "\n"; 
}


exit( 0 );

