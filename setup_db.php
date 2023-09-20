<?php
/**
 * Database setup script.
 *
 * This script initializes the database structure for the Assignment Tracker application.
 * It creates the necessary tables for courses and assignments.
 *
 * @author Robert Kulig
 */

require_once('app/config/config_db.php');

try {
    // Connect to the database server
    $username = $dbUser;
    $password = $dbPass;
    $dbServer = new PDO("mysql:host=$host", $username, $password);
    $dbServer->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database if it doesn't exist
    $createDbQuery = "CREATE DATABASE IF NOT EXISTS $dbname";
    $dbServer->exec($createDbQuery);

    // Connect to the newly created database
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define tables
    /**
     * SQL statement to create the 'courses' table.
     *
     * @var string $coursesTable
     */
    $coursesTable = "
        CREATE TABLE IF NOT EXISTS courses (
            courseID INT AUTO_INCREMENT PRIMARY KEY,
            courseName VARCHAR(50) NOT NULL
        );
    ";

    /**
     * SQL statement to create the 'assignments' table.
     *
     * @var string $assignmentsTable
     */
    $assignmentsTable = "
        CREATE TABLE IF NOT EXISTS assignments (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            Description VARCHAR(120) NOT NULL,
            courseID INT NOT NULL,
            FOREIGN KEY (courseID) REFERENCES courses(courseID)
        );
    ";

    // Execute SQL queries
    $db->exec($coursesTable);
    $db->exec($assignmentsTable);

    echo "Database structure has been created successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>