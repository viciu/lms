<?php

/*
 * LMS version 1.6-cvs
 *
 *  (C) Copyright 2001-2005 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 *  $Id$
 */

$DB->Execute("BEGIN");
$DB->Execute("CREATE TEMP TABLE nodes_t AS SELECT * FROM nodes");
$DB->Execute("DROP TABLE nodes");
$DB->Execute("CREATE TABLE nodes (
	id integer PRIMARY KEY,
	name varchar(16) 	DEFAULT '' NOT NULL,
	mac varchar(20) 	DEFAULT '' NOT NULL,
	ipaddr bigint 		DEFAULT 0 NOT NULL,
	ownerid integer 	DEFAULT 0 NOT NULL,
	netdev integer 		DEFAULT 0 NOT NULL,
	linktype smallint	DEFAULT 0 NOT NULL,
	creationdate integer 	DEFAULT 0 NOT NULL,
	moddate integer 	DEFAULT 0 NOT NULL,
	creatorid integer 	DEFAULT 0 NOT NULL,
	modid integer 		DEFAULT 0 NOT NULL,
	access smallint 	DEFAULT 1 NOT NULL,
	warning smallint 	DEFAULT 0 NOT NULL,
	lastonline integer	DEFAULT 0 NOT NULL,
	UNIQUE (name),
	UNIQUE (ipaddr)
)");
$DB->Execute("INSERT INTO nodes(id, name, mac, ipaddr, ownerid, netdev, creationdate, moddate, creatorid, modid, access, warning, lastonline) 
		SELECT id, name, mac, ipaddr, ownerid, netdev, creationdate, moddate, creatorid, modid, access, warning, lastonline 
		FROM nodes_t");
$DB->Execute("DROP TABLE nodes_t");

$DB->Execute("CREATE TEMP TABLE nl_t AS SELECT * FROM netlinks");
$DB->Execute("DROP TABLE netlinks");
$DB->Execute("CREATE TABLE netlinks (
	id integer 		PRIMARY KEY,
	src integer 		DEFAULT 0 NOT NULL,
	dst integer 		DEFAULT 0 NOT NULL,
	type smallint		DEFAULT 0 NOT NULL,
	UNIQUE (src, dst)
)");
$DB->Execute("INSERT INTO netlinks(id, src, dst) SELECT id, src, dst FROM nl_t");
$DB->Execute("DROP TABLE nl_t");

$DB->Execute("UPDATE dbinfo SET keyvalue = '2004101800' WHERE keytype = 'dbversion'");
$DB->Execute("COMMIT");

?>