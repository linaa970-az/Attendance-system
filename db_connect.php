<?php
/*
 * Database connection helper
 *
 * This script centralizes the creation of a PDO connection using the
 * configuration defined in config.php. It returns a PDO instance on
 * success or null on failure. Errors are caught and optionally
 * recorded to a local log file.
 */

require_once __DIR__ . '/config.php';

/**
 * Establish a connection to the MySQL database using PDO.
 *
 * @return PDO|null Returns a PDO object if the connection is successful; otherwise null.
 */
function getConnection()
{
    try {
        // First, connect without specifying a database to check connection
        $dsn = 'mysql:host=' . DB_HOST . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS);

        // Create the database if it doesn't exist
        $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);

        // Now connect to the specific database
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);

        return $pdo;
    } catch (PDOException $e) {
        // Handle error and log it
        $message = '[' . date('Y-m-d H:i:s') . "] Database connection failed: " . $e->getMessage() . PHP_EOL;
        $logFile = DIR . '/db_error.log';
        @file_put_contents($logFile, $message, FILE_APPEND);
        return null;
    }
}

// End of connection helper; no closing PHP tag to prevent accidental output
?>