<?php

define("DB_SERVER", "localhost");

define("DB_NAME", "CmsDevcm_v6");

define("DB_PREFIX", "v1_");

define("DB_USER", "CmsDevcm_admin");

define("DB_PASSWORD", "CmsDevd3d05B3");

// Standard ezSQL Libs

include_once "../shared/ez_sql_core.php";

include_once "ez_sql_mysql.php";



// Initialise singleton

$SKTDB = new ezSQL_mysql(DB_USER, DB_PASSWORD, DB_NAME);



// Cache expiry

$SKTDB->cache_timeout = 24; // Note: this is hours
// Specify a cache dir. Path is taken from calling script

$SKTDB->cache_dir = 'ezsql_cache';



// (1. You must create this dir. first!)
// (2. Might need to do chmod 775)
// Global override setting to turn disc caching off
// (but not on)

$SKTDB->use_disk_cache = true;



// By wrapping up queries you can ensure that the default
// is NOT to cache unless specified

$SKTDB->cache_queries = true;



// At last.. a query!

$SKTDB->get_results("SHOW TABLES");

$SKTDB->debug();



// Select * from use

$SKTDB->get_results("SELECT * FROM v1_content");

$SKTDB->debug();



// This ensures only the above querys are cached

$SKTDB->cache_queries = false;



// This query is NOT cached

$SKTDB->get_results("SELECT * FROM v1_content LIMIT 0,1");

$SKTDB->debug();



/*



  Of course, if you want to cache EVERYTHING just do..



  $SKTDB = new ezSQL_mysql('db_user', 'db_pass', 'db_name');

  $SKTDB->use_disk_cache = true;

  $SKTDB->cache_queries = true;

  $SKTDB->cache_timeout = 24;



 */
?>