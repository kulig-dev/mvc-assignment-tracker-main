<?php
// app/src/controllers/CourseController.php

require_once '../models/CourseDB.php';

/**
 * Course Controller class handles HTTP requests related to courses.
 */
class CourseController {
    private $courseModel;

    /**
     * Constructor to initialize the model.
     *
     * @param PDO $db Database connection instance.
     */
    public function __construct($db) {
        $this->courseModel = new CourseDB($db);
    }

    /**
     * Retrieve and display a list of all courses.
     */
    public function getAllCourses() {
        $courses = $this->courseModel->getAllCourses();
        // Pass $courses to the view to display the list of courses
        include '../views/courses_list.php';
    }

    /**
     * Add a new course to the database and handle redirection.
     *
     * @param string $courseName The name of the new course.
     */
    public function addCourse($courseName) {
        $result = $this->courseModel->addCourse($courseName);
        if ($result) {
            // Success: The course has been added
            header("Location: .?action=list_courses");
        } else {
            // Error: Failed to add the course
            $error = "Something went wrong, please try again later.";
            include('../views/pages/error_page.php');
            exit();
        }
    }

    /**
     * Delete a course from the database and handle redirection.
     *
     * @param int $courseID The ID of the course to delete.
     */
    public function deleteCourse($courseID) {
        if ($courseID) {
            try {
                $result = $this->courseModel->deleteCourse($courseID);

                if  ($result) {
                    // Success: The course has been deleted
                    $success = "Success: The course has been deleted.";
                    include('../views/pages/success_page.php');
                    exit();
                } else {
                    // Error: Failed to delete the course
                    $error = "You cannot delete a course if assignments exist for it.";
                    include('../views/pages/error_page.php');
                    exit();
                }
            } catch (PDOException $e) {
                // Handle exceptions if there are assignments associated with the course
                $error = "You cannot delete a course if assignments exist for it.";
                include('../views/pages/error_page.php');
                exit();
            }
            // Redirect to the list of courses
            header("Location: .?action=list_courses");
        }
    }
}