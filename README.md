OSS_SNMP
========

A PHP SNMP library for people who *hate* SNMP MIBs and OIDs!
------------------------------------------------------------

I ([Barry O'Donovan](http://www,barryodonovan.com/)) hate SNMP! But I have
to use it on a daily basis with my company, [Open
Solutions](http://www.opensolutions.ie/).  Don't get me wrong, it's an
essential tool in the trade of network engineering but it's also a serious
pain in the arse.  Finding MIBs, OIBs, making them work, translating them,
cross-vendor translating them, blah, blah.  And then, when you do find what
you need, you'll have forgotten it months later when you need it again. 

Anyway, while trying to create some automatic L2 topology graphing tools
(via Cisco/Foundry Discovery Protocol for example) and also some per VLAN
RSTP tools to show port states, I started writing this library. As I wrote I
realised it was actually very useful and present it here now in the hopes
that the wider network engineering community will find it useful and also
contribute back 'MIBs'.


Example Usage
-------------

Let's say I want to get an associate array indexed by VLAN ids contained the
VLAN names from a Cisco switch with IP address `$ip` and SNMP community
`$community`. Easy peasy:

    $ciscosw = new \OSS\SNMP( $ip, $community );
    print_r( $ciscosw->useCisco_VTP()->vlanNames() );


Huh? That easy? Yes!



