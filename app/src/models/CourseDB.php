<?php
namespace Newde\MvcAssignmentTracker\models;

use \PDO;

/**
 * CourseDB class represents the data access layer for courses.
 */
class CourseDB extends BaseModel {
    /**
     * Get all courses.
     *
     * @return array An array of course data.
     * @throws \PDOException If there is an error during database query execution.
     */
    public function getAllCourses() {
        try {
            $query = "SELECT * FROM courses";
            $result = $this->db->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error fetching courses: " . $e->getMessage());
        }
    }

    /**
     * Get a course by its ID.
     *
     * @param int $courseID The ID of the course.
     * @return array|null An associative array representing the course, or null if not found.
     * @throws \PDOException If there is an error during database query execution.
     */
    public function getCourseByID($courseID) {
        try {
            $query = "SELECT * FROM courses WHERE courseID = :courseID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Error fetching course: " . $e->getMessage());
        }
    }

    /**
     * Add a new course.
     *
     * @param string $courseName The name of the course.
     * @return bool True on success, false on failure.
     * @throws \PDOException If there is an error during database query execution.
     */
    public function addCourse($courseName) {
        try {
            $query = "INSERT INTO courses (courseName) VALUES (:courseName)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':courseName', $courseName);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Error adding course: " . $e->getMessage());
        }
    }

    /**
     * Delete a course by its ID.
     *
     * @param int $courseID The ID of the course to delete.
     * @return bool True on success, false on failure.
     * @throws \PDOException If there is an error during database query execution.
     */
    public function deleteCourse($courseID) {
        try {
            $query = "DELETE FROM courses WHERE courseID = :courseID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception("Error deleting course: " . $e->getMessage());
        }
    }
}