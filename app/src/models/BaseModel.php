<?php
namespace Newde\MvcAssignmentTracker\models;

use \PDO;
use \Exception;

/**
 * BaseModel class represents the base data access layer for models.
 */
class BaseModel {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }
    
     /** Prepares an SQL query and returns a statement object.
     *
     * @param string $sql SQL query.
     * @return \PDOStatement statement object.
     * @throws \Exception If an error occurred.
     */
    public function prepare($sql) {
        try {
            return $this->db->prepare($sql);
        } catch (\PDOException $e) {
            throw new Exception("Error preparing SQL statement: " . $e->getMessage());
        }
    }
    
    /**
     * Get all records from a table.
     *
     * @param string $table The name of the table.
     * @return array An array of records.
     * @throws \Exception If there is an error during database query execution.
     */
    public function getAll($table) {
        try {
            $query = "SELECT * FROM $table";
            $result = $this->db->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new Exception("Error fetching records: " . $e->getMessage());
        }
    }

    /**
     * Get a record by its ID from a table.
     *
     * @param string $table The name of the table.
     * @param int $id The ID of the record.
     * @return array The record as an associative array.
     * @throws \Exception If there is an error during database query execution.
     */
    public function getById($table, $id) {
        try {
            $query = "SELECT * FROM $table WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new Exception("Error fetching record: " . $e->getMessage());
        }
    }

    /**
     * Insert a new record into a table.
     *
     * @param string $table The name of the table.
     * @param array $data An associative array of data to be inserted.
     * @return bool True on success, false on failure.
     * @throws \Exception If there is an error during database query execution.
     */
    public function insert($table, $data) {
        try {
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));
            $query = "INSERT INTO $table ($columns) VALUES ($values)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute($data);
        } catch (\PDOException $e) {
            throw new Exception("Error inserting record: " . $e->getMessage());
        }
    }

    /**
     * Update a record in the database.
     *
     * @param string $table The name of the table.
     * @param int $id The ID of the record to update.
     * @param array $data An associative array of data to update.
     * @return bool True on success, false on failure.
     * @throws \Exception If there is an error during database query execution.
     */
    public function update($table, $id, $data) {
        try {
            // Build the SET clause for the update query
            $setClause = '';
            foreach ($data as $column => $value) {
                $setClause .= "$column = :$column, ";
            }
            // Remove the trailing comma and space
            $setClause = rtrim($setClause, ', ');

            // Prepare and execute the update query
            $query = "UPDATE $table SET $setClause WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $data['id'] = $id; // Add the ID to the data array
            $stmt->execute($data);

            return true;
        } catch (\PDOException $e) {
            throw new Exception("Error updating record: " . $e->getMessage());
        }
    }

    /**
     * Delete a record from the database.
     *
     * @param string $table The name of the table.
     * @param int $id The ID of the record to delete.
     * @return bool True on success, false on failure.
     * @throws \Exception If there is an error during database query execution.
     */
    public function delete($table, $id) {
        try {
            // Prepare and execute the delete query
            $query = "DELETE FROM $table WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            throw new Exception("Error deleting record: " . $e->getMessage());
        }
    }
}