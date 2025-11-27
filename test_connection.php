<?php
/*
 * Simple script to test the database connection
 *
 * Include db_connect.php and attempt to obtain a connection. The script
 * echoes whether the connection succeeded or failed so you can verify
 * your configuration. Ensure your database server is running and
 * the credentials in config.php are correct before running this
 * script via a web server or the PHP CLI.
 */

require_once __DIR__ . '/db_connect.php';

$connection = getConnection();

if ($connection instanceof PDO) {
    echo 'Connection successful';
    // Optionally, you can close the connection by setting it to null
    
    $connection = null;
} else {
    echo 'Connection failed';
}

// End of script; no closing PHP tag to prevent accidental output