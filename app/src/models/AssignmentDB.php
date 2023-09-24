<?php
namespace Newde\MvcAssignmentTracker\models;

use \PDO;

/**
 * AssignmentModel class represents the data access layer for assignments.
 * AssignmentModel class represents the data access layer for assignments.
 */
class AssignmentDB extends BaseModel {

    public function __construct($db) {
        parent::__construct($db);
    }

    /**
     * Get all assignments.
     *
     * @return array An array of assignment data.
     * @throws \PDOException If there is an error during database query execution.
     */
    public function getAllAssignments() {
        try {
            $query = "SELECT A.ID, A.Description, C.courseName FROM assignments A LEFT JOIN courses C ON A.courseID = C.courseID ORDER BY C.courseID";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error fetching assignments: " . $e->getMessage());
        }
    }

    /**
     * Get an assignment by its ID.
     *
     * @param int $assignmentID The ID of the assignment.
     * @return array|null An associative array representing the assignment, or null if not found.
     * @throws \PDOException If there is an error during database query execution.
     */
    public function getAssignmentByID($assignmentID) {
        try {
            $query = "SELECT A.ID, A.Description, C.courseName FROM assignments A LEFT JOIN courses C ON A.courseID = C.courseID WHERE A.ID = :assignmentID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':assignmentID', $assignmentID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error fetching assignment by ID: " . $e->getMessage());
        }
    }

    /**
     * Get assignments by course ID.
     *
     * @param int|null $courseID The ID of the course (or null to retrieve all assignments).
     * @return array An array of assignment data.
     * @throws \PDOException If there is an error during database query execution.
     */
    public function getAssignmentsByCourse($courseID) {
        try {
            if ($courseID) {
                $query = "SELECT A.ID, A.Description, C.courseName FROM assignments A LEFT JOIN courses C ON A.courseID = C.courseID WHERE A.courseID = :courseID ORDER BY A.ID";
                $query = "SELECT A.ID, A.Description, C.courseName FROM assignments A LEFT JOIN courses C ON A.courseID = C.courseID WHERE A.courseID = :courseID ORDER BY A.ID";
            } else {
                $query = "SELECT A.ID, A.Description, C.courseName FROM assignments A LEFT JOIN courses C ON A.courseID = C.courseID ORDER BY C.courseID";
                $query = "SELECT A.ID, A.Description, C.courseName FROM assignments A LEFT JOIN courses C ON A.courseID = C.courseID ORDER BY C.courseID";
            }
            $stmt = $this->db->prepare($query);
            if ($courseID) {
                $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
            }
            $stmt->execute();
            $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $assignments;
        } catch (\PDOException $e) {
            throw new \Exception("Error fetching assignments by course ID: " . $e->getMessage());
        }
    }

    /**
     * Get the course ID for a given assignment.
     *
     * @param int $assignmentID The ID of the assignment.
     * @return int|null The course ID associated with the assignment, or null if not found.
     * @throws \PDOException If there is an error during database query execution.
     */
    public function getCourseIDForAssignment($assignmentID) {
        try {
            $query = "SELECT courseID FROM assignments WHERE ID = :assignmentID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':assignmentID', $assignmentID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['courseID'];
            } else {
                return null; // The assignment with the given ID does not exist or is not associated with the course.
            }
        } catch (\PDOException $e) {
            throw new \Exception("Error fetching course ID for assignment: " . $e->getMessage());
        }
    }

    /**
     * Add a new assignment.
     *
     * @param string $description The description of the assignment.
     * @param int $courseID The ID of the course associated with the assignment.
     * @return bool True on success, false on failure.
     * @throws \PDOException If there is an error during database query execution.
     */
    public function addAssignment($description, $courseID) {
        try {
            $query = "INSERT INTO assignments (Description, courseID) VALUES (:description, :courseID)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Error adding assignment: " . $e->getMessage());
        } catch (\PDOException $e) {
            throw new \Exception("Error adding assignment: " . $e->getMessage());
        }
    }

    /**
     * Delete an assignment by its ID.
     *
     * @param int $assignmentID The ID of the assignment to delete.
     * @return bool True on success, false on failure.
     * @throws \PDOException If there is an error during database query execution.
     */
    public function deleteAssignment($assignmentID) {
        try {
            $query = "DELETE FROM assignments WHERE ID = :assignmentID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':assignmentID', $assignmentID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Error deleting assignment: " . $e->getMessage());
    }
}