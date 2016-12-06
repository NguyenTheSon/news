<?php
$myServer = "sddb0040049374.cgidb";
$myUser = "sd_dba_MjU0MDE1";
$myPass = "OTKDauOE";
$myDB = "sddb0040049374"; 

echo 'setup message app';

//connection to the database
$dbhandle = mssql_connect($myServer, $myUser, $myPass)
  or die("Couldn't connect to SQL Server on $myServer"); 

//select a database to work with
$selected = mssql_select_db($myDB, $dbhandle)
  or die("Couldn't open database $myDB"); 

//declare the SQL statement that will query the database
$query = "CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_id` int(100) unsigned DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` varchar(1200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mes_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `read_count` int(10) unsigned NOT NULL DEFAULT '1',
  `remain_count` int(10) unsigned NOT NULL DEFAULT '1',
  `end_time` int(100) unsigned DEFAULT NULL,
  `expired` int(10) NOT NULL DEFAULT '0',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=315 ;"

//execute the SQL query and return records
mssql_query($query);

//declare the SQL statement that will query the database
$query = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(1) DEFAULT '0',
  `tokenhash` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tokensecret` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social` int(10) unsigned DEFAULT '0',
  `social_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT AUTO_INCREMENT=98 ;"

//execute the SQL query and return records
mssql_query($query);


//declare the SQL statement that will query the database
$query = "CREATE TABLE IF NOT EXISTS `users_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_id` int(10) unsigned NOT NULL,
  `token` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `registed` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=945 ;"

//execute the SQL query and return records
mssql_query($query);

//close the connection
mssql_close($dbhandle);
?>