#! /bin/sh

ROOT=`dirname $0`/..

phpdoc -c $ROOT/etc/phpdoc.tpl.xml -d $ROOT/OSS_SNMP -t $ROOT/doc/ $*


