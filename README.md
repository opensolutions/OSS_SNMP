OSS_SNMP
========

A PHP SNMP Library for People Who HATE SNMP, MIBs and OIDs!
------------------------------------------------------------

I ([Barry O'Donovan](http://www,barryodonovan.com/)) hate SNMP! But I have
to use it on a daily basis with my company, [Open
Solutions](http://www.opensolutions.ie/).

Don't get me wrong, it's an essential tool in the trade of network engineering
but it's also a serious PITA. Finding MIBs, OIBs, making them work, translating
them, cross-vendor translations, etc, blah, blah. And then, when you do find what
you need, you'll have forgotten it months later when you need it again.

Anyway, while trying to create some automatic L2 topology graphing tools
(via Cisco/Foundry Discovery Protocol for example) and also some per VLAN
RSTP tools to show port states, I started writing this library. As I wrote, I
realised it was actually very useful and present it here now in the hopes
that the wider network engineering community will find it useful and also
contribute back *MIBs*.


Example Usage
-------------

First, we need to instantiate an SNMP object with a hostname / IP address and
a community string:

    $ciscosw = new \OSS\SNMP( $ip, $community );

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


The Bad News... with some Good News
------------------------------------

The, what I'm calling, *MIBs* are defined in `OSS/SNMP/MIBS` and these define the functionality as per the examples above.

There's only a handful of MIBs currently defined - essentially what I've needed so far for other projects.

But it's **really easy** to add your own. And **please** send me a pull request for those.

For the MIBs I've written, only `Iface` (`MIBS/Iface.php`) is fully complete and I
just completed it as an exercise to help future contributors. But there's some *really* useful
functionality in the others. For example the Cisco/CDP MIB can discover your entire L2 network
topology recursively. Another project I'll release soon will give concreate examples of this
with GraphViz.

PHP 5.4 is a requirement. Yeah, I know. Not even the current Ubuntu ships this. But
look, 5.4 is released, it's stable, it's available on FreeBSD and
[from personal ports for Ubuntu](http://www.barryodonovan.com/index.php/2012/05/22/ubuntu-12-04-precise-pangolin-and-php-5-4-again).

The reason for 5.4, among other things, is that we can now dereference an array directly from a function call:

    $name = $ciscosw->useCisco_VTP()->vlanNames()[ $vlanid ];

rather than the old way:

    $vlanNames = $ciscosw->useCisco_VTP()->vlanNames();
    $name = $vlanNames[ $vlanid ];

And as most of the defined MIBs *walk* a given tree, almost all defined functions return an array.

Oh, and right now it's SNMP v2. This can be easily updated for multiple version support.


Code / phpDoc Documentation
---------------------------

Documentation can be generated from the root directory by executing:

    ./bin/phpdoc.sh --force

and it will be found under the `doc/` directory. There is 
[an online version available here](http://opensolutions.github.com/OSS_SNMP/).

Coming Soon
-----------

I've **just** puth this live. Over the coming hours and days, I'll be adding:

* documentation on the main SNMP class itself;
* instructions for writing a new MIB (with real world example);
* details on caching;
* link to online PHPdocs for the project.



