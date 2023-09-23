<?php
namespace Newde\MvcAssignmentTracker\controllers;

// app/src/controllers/AssignmentController.php

use Newde\MvcAssignmentTracker\models\AssignmentDB;
use Newde\MvcAssignmentTracker\models\CourseDB; // Dodaj import dla CourseDB, jeśli to konieczne


require_once __DIR__ . '/../models/AssignmentDB.php';
require_once __DIR__ . '/../models/CourseDB.php';

/**
 * Assignment Controller class handles HTTP requests related to assignments.
 */
class AssignmentController extends BaseController {
    private $assignmentModel;
    private $courseModel;

    /**
     * Constructor to initialize models.
     *
     * @param \PDO $db Database connection instance.
     */
    public function __construct($db) {
        parent::__construct($db);
        $this->assignmentModel = new \Newde\MvcAssignmentTracker\models\AssignmentDB($db); // Dodaj "\" przed namespace
        $this->courseModel = new \Newde\MvcAssignmentTracker\models\CourseDB($db); // Dodaj "\" przed namespace, jeśli to konieczne
    }
    

    /**
     * Retrieve assignments by course ID and display them.
     *
     * @param int|null $courseID The ID of the course (or null to retrieve all assignments).
     */
    public function listAction() {
        $courseID = filter_input(INPUT_GET, 'courseID', FILTER_VALIDATE_INT);
        $assignments = $this->assignmentModel->getAssignmentsByCourse($courseID);
        $this->renderView('assignment_list.php', ['assignments' => $assignments]);
    }

    /**
     * Add a new assignment to the database.
     */
    public function addAction($data) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $courseID = filter_input(INPUT_POST, 'courseID', FILTER_VALIDATE_INT);

            if (!empty($description) && $courseID) {
                $result = $this->assignmentModel->addAssignment($description, $courseID);
                if ($result) {
                    // Success: The assignment has been added
                    header("Location: .?action=list&courseID=$courseID");
                    exit();
                }
            }
        }
        // Error: Invalid data or GET request
        include('../views/pages/error_page.php');
        exit();
    }

    /**
     * Delete an assignment by its ID and handle redirection.
     *
     * @param int $assignmentID The ID of the assignment to delete.
     */
    public function deleteAction($id) {
        $assignmentID = filter_input(INPUT_GET, 'assignmentID', FILTER_VALIDATE_INT);
        if ($assignmentID) {
            $courseID = $this->assignmentModel->getCourseIDForAssignment($assignmentID);
            $result = $this->assignmentModel->deleteAssignment($assignmentID);
            if ($result) {
                // Success: The assignment has been deleted
                header("Location: .?action=list&courseID=$courseID");
                exit();
            }
        }
        // Error: Invalid data or assignment not found
        include('../views/pages/error_page.php');
        exit();
    }
}