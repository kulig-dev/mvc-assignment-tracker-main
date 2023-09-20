<?php
// app/config/db_handler.php

require_once 'config_db.php';

try {
    /**
     * Create a new PDO instance for database connection.
     *
     * @var PDO $db Database connection instance.
     */
    $db = new PDO("mysql:host=$host;dbname=$dbname", $dbUser, $dbPass);
    
    /**
     * Set PDO error mode to exception for better error handling.
     */
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    /**
     * Handle database connection error and display an error message.
     */
    echo "Database connection error: " . $e->getMessage();
    die();
}
?>