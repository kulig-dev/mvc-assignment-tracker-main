<?php
namespace Newde\MvcAssignmentTracker\controllers;

use Newde\MvcAssignmentTracker\models\CourseDB;
use \PDOException; // Dodaj import dla PDOException, jeśli to konieczne

require_once __DIR__ . '/../models/CourseDB.php';

/**
 * Course Controller class handles HTTP requests related to courses.
 */
class CourseController extends BaseController {
    private $courseModel;

    /**
     * Constructor to initialize models.
     *
     * @param \PDO $db Database connection instance.
     */
    public function __construct($db) {
        parent::__construct($db);
        $this->courseModel = new \Newde\MvcAssignmentTracker\models\CourseDB($db);
    }

    /**
     * Retrieve courses and display them.
     */
    public function listAction() {
        $courses = $this->courseModel->getAllCourses();
        $this->renderView('course_list.php', ['courses' => $courses]);
    }

    /**
     * Add a new course to the database.
     */
    public function addAction($data) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseName = filter_input(INPUT_POST, 'courseName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (!empty($courseName)) {
                $result = $this->courseModel->addCourse($courseName);
                if ($result) {
                    // Success: The course has been added
                    $this->renderView('course_list.php', ['courses' => $result]);
                    exit();
                }
            }
        }
        // Error: Invalid data or GET request
        include('../views/pages/error_page.php');
        exit();
    }

    /**
     * Delete a course by its courseID and handle redirection.
     *
     * @param int $courseID The ID of the course to delete.
     */
    public function deleteAction($id) {
        $courseID = filter_input(INPUT_GET, 'courseID', FILTER_VALIDATE_INT);

        $result = $this->courseModel->deleteCourse($courseID);
        if ($result) {
            // Success: The course has been deleted
            $this->renderView('course_list.php', ['courses' => $result]);
            exit();
        }
        // Error: Invalid data or course not found
        include('../views/pages/error_page.php');
        exit();
    }
}