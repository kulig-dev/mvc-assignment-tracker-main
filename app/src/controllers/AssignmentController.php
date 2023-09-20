<?php
// app/src/controllers/AssignmentController.php

require_once '../models/AssignmentDB.php';
require_once '../models/CourseDB.php';

/**
 * Assignment Controller class handles HTTP requests related to assignments.
 */
class AssignmentController {
    private $assignmentModel;
    private $courseModel;

    /**
     * Constructor to initialize models.
     *
     * @param PDO $db Database connection instance.
     */
    public function __construct($db) {
        $this->assignmentModel = new AssignmentDB($db);
        $this->courseModel = new CourseDB($db);
    }

    /**
     * Retrieve assignments by course ID and display them.
     *
     * @param int $courseID The ID of the course (or null to retrieve all assignments).
     */
    public function getAssignmentsByCourse($courseID) {
        $result = $this->assignmentModel->getAssignmentsByCourse($courseID);
        $courseName = $this->courseModel->getCourseName($courseID);
        $courses = $this->courseModel->getAllCourses();
        if ($result && $courseName && $courses) {
            // Success: The course has been listed by name
            include '../views/assignments_list.php';
        } else {
            // Error: Failed to list the course by name
            $error = "Invalid assignment data. Check all fields and try again.";
            include('../views/pages/error_page.php');
            exit();
        }
    }

    /**
     * Add a new assignment to the database.
     *
     * @param string $description The description of the assignment.
     * @param int $courseID The ID of the course associated with the assignment.
     */
    public function addAssignment($description, $courseID) {
        $result = $this->assignmentModel->addAssignment($description, $courseID);
        if ($result) {
            // Success: The assignment has been added
            header("Location: .?courseID=$courseID");
        } else {
            // Error: Failed to add the assignment
            $error = "Invalid assignment data. Check all fields and try again.";
            include('../views/pages/error_page.php');
            exit();
        }
    }

    /**
     * Delete an assignment by its ID and handle redirection.
     *
     * @param int $assignmentID The ID of the assignment to delete.
     */
    public function deleteAssignment($assignmentID) {
        $result = $this->assignmentModel->deleteAssignment($assignmentID);

        // Check if there are other assignments for the same course
        $courseID = $this->assignmentModel->getCourseIDForAssignment($assignmentID);
        $otherAssignments = $this->assignmentModel->getAssignmentsByCourse($courseID);

        if ($result) {
            // Success: The assignment has been deleted
            if (!empty($otherAssignments)) {
                // There are other assignments for the same course
                header("Location: .?action=list_assignments&courseID=$courseID");
            } else {
                // The course no longer has assignments
                header("Location: .?action=list_assignments"); // Redirect to the general assignments list
            }
        } else {
            // Error: Failed to delete the assignment
            $error = "Missing or incorrect assignment ID.";
            include('../views/pages/error_page.php');
        }
    }
}