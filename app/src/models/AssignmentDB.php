<?php
// app/src/AssignmentDB.php

/**
 * AssignmentDB class represents the data access layer for assignments.
 */
class AssignmentDB {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get assignments by course ID.
     *
     * @param int|null $courseID The ID of the course (or null to retrieve all assignments).
     * @return array An array of assignment data.
     * @throws Exception If there is an error during database query execution.
     */
    public function getAssignmentsByCourse($courseID) {
        try {
            if ($courseID) {
                $query = "SELECT A.ID, A.Description, C.courseID FROM assignments A LEFT JOIN courses C ON A.courseID = C.courseID WHERE A.courseID = :courseID ORDER BY A.ID";
            } else {
                $query = "SELECT A.ID, A.Description, C.courseID FROM assignments A LEFT JOIN courses C ON A.courseID = C.courseID ORDER BY C.courseID";
            }
            $stmt = $this->db->prepare($query);
            if ($courseID) {
                $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
            }
            $stmt->execute();
            $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $assignments;
        } catch (PDOException $e) {
            throw new Exception("Error fetching assignments: " . $e->getMessage());
        }
    }

    /**
     * Get the course ID associated with an assignment.
     *
     * @param int $assignmentID The ID of the assignment.
     * @return int|null The course ID or null if not found.
     * @throws Exception If there is an error during database query execution.
     */
    public function getCourseIDForAssignment($assignmentID) {
        try {
            $query = "SELECT courseID FROM assignments WHERE ID = :assignmentID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':assignmentID', $assignmentID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['courseID'])) {
                return $result['courseID'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            throw new Exception("Error fetching course ID for assignment: " . $e->getMessage());
        }
    }

    /**
     * Add a new assignment.
     *
     * @param string $description The description of the assignment.
     * @param int $courseID The ID of the course associated with the assignment.
     * @return bool True on success, false on failure.
     * @throws Exception If there is an error during database query execution.
     */
    public function addAssignment($description, $courseID) {
        try {
            $query = "INSERT INTO assignments (Description, courseID) VALUES (:description, :courseID)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error adding assignment: " . $e->getMessage());
        }
    }

    /**
     * Edit an existing assignment.
     *
     * @param int $assignmentID The ID of the assignment to edit.
     * @param string $newDescription The new description for the assignment.
     * @return bool True on success, false on failure.
     * @throws Exception If there is an error during database query execution.
     */
    public function editAssignment($assignmentID, $newDescription) {
        try {
            $query = "UPDATE assignments SET Description = :newDescription WHERE ID = :assignmentID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':newDescription', $newDescription);
            $stmt->bindParam(':assignmentID', $assignmentID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error editing assignment: " . $e->getMessage());
        }
    }

    /**
     * Delete an assignment by its ID.
     *
     * @param int $assignmentID The ID of the assignment to delete.
     * @return bool True on success, false on failure.
     * @throws Exception If there is an error during database query execution.
     */
    public function deleteAssignment($assignmentID) {
        try {
            $query = "DELETE FROM assignments WHERE ID = :assignmentID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':assignmentID', $assignmentID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting assignment: " . $e->getMessage());
        }
    }
}