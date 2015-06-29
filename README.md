OSS_SNMP
========

A PHP SNMP Library for People Who HATE SNMP, MIBs and OIDs!
------------------------------------------------------------

I ([Barry O'Donovan](http://www.barryodonovan.com/)) hate SNMP! But I have
to use it on a daily basis with my company, [Open
Solutions](http://www.opensolutions.ie/) and our customers.

Don't get me wrong, it's an essential tool in the trade of network engineering
but it's also a serious PITA. Finding MIBs, OIBs, making them work, translating
them, cross-vendor translations, etc, blah, blah. And then, when you do find what
you need, you'll have forgotten it months later when you need it again.

Anyway, while trying to create some automatic L2 topology graphing tools
(via Cisco/Foundry Discovery Protocol for example) and also some per VLAN
RSTP tools to show port states, I started writing this library which has turned
out to be very useful. It is presented here in the hope that the wider network 
engineering community will find it useful and also contribute back *MIBs*.


Documentation
-------------

Please see [the wiki](https://github.com/opensolutions/OSS_SNMP/wiki).

Example Usage
-------------

First, we need to instantiate an SNMP object with a hostname / IP address and
a community string:

    $ciscosw = new \OSS_SNMP\SNMP( $ip, $community );

Assuming the above is a standard Cisco switch, let's say I want to get an
associate array of VLAN names indexed by the VLAN ids:

    print_r( $ciscosw->useCisco_VTP()->vlanNames() );

This yields something like the following:

    Array
    (
        [1] => default
        [2] => mgmt
        [100] => cust-widgets
        [1002] => fddi-default
        ...
    )

It really is that easy. As another example, if you wanted to get the system contact:

    echo $ciscosw->useSystem()->contact();


License
-------

This software library is released under the *New BSD License* (also known as the
*Modified BSD License*). See the `LICENSE` file or the header of all other files
for the full text.


MIBS - The Bad News... with some Good News
------------------------------------------

The, what I'm calling, *MIBs* are defined in `OSS_SNMP/MIBS` and these define the 
functionality as per the examples above.

There's only a handful of MIBs currently defined - essentially what I've needed so
far for other projects.

But it's **really easy** to add your own. And **please** send me a pull request for those.

For the MIBs I've written, `Iface` (`MIBS/Iface.php`) is fully complete as an example 
to help future contributors. But there's some *really* useful
functionality in the others. For example the Cisco/CDP MIB can discover your entire L2 network
topology recursively. Another project we've released, [NOCtools](https://github.com/opensolutions/NOCtools/wiki), 
give concreate examples of this with GraphViz.

Supports SNMP v1, v2c and v3. It's read only as, at time of writing, I have no current requirement to set SNMP values via PHP.


Requirements
------------

PHP 5.4 is a requirement. The reason for 5.4 (besides the fact it's long been regarded as stable), 
is that we can now dereference an array directly from a function call:

    $name = $ciscosw->useCisco_VTP()->vlanNames()[ $vlanid ];

rather than the old way:

    $vlanNames = $ciscosw->useCisco_VTP()->vlanNames();
    $name = $vlanNames[ $vlanid ];

And as most of the defined MIBs *walk* a given tree, almost all defined functions return an array.

The only other requirement is the php5-snmp library.


Code / phpDoc Documentation
---------------------------

Documentation can be generated from the root directory by executing:

    ./bin/phpdoc.sh --force

and it will be found under the `doc/` directory. There is
[an online version available here](http://opensolutions.github.com/OSS_SNMP/doc/).

