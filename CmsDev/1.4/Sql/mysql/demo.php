<?php

/* * ********************************************************************
 *  ezSQL initialisation for mySQL
 */
// Include ezSQL core
include_once "../../../db.php";
include_once "../shared/ez_sql_core.php";

// Include ezSQL database specific component
include_once "ez_sql_mysql.php";

// Initialise database object and establish a connection
// at the same time - db_user / db_password / db_name / db_host
$SKTDB = new ezSQL_mysql(DB_USER, DB_PASSWORD, DB_NAME, DB_SERVER);

/* * ********************************************************************
 *  ezSQL demo for mySQL database
 */

// Demo of getting a single variable from the db
// (and using abstracted function sysdate)
$current_time = $SKTDB->get_var("SELECT " . $SKTDB->sysdate());
print "ezSQL demo for mySQL database run @ $current_time";

// Print out last query and results..
$SKTDB->debug();

// Get list of tables from current database..
$my_tables = $SKTDB->get_results("SHOW TABLES", ARRAY_N);

// Print out last query and results..
$SKTDB->debug();

// Loop through each row of results..
foreach ($my_tables as $table) {
    // Get results of DESC table..
    $SKTDB->get_results("DESC $table[0]");

    // Print out last query and results..
    $SKTDB->debug();
}
?>