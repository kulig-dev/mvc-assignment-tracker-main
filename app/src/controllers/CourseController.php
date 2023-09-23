<?php
namespace Newde\MvcAssignmentTracker\controllers;

// CourseController.php

use Newde\MvcAssignmentTracker\models\AssignmentDB;
use Newde\MvcAssignmentTracker\models\CourseDB; // Dodaj import dla CourseDB, jeśli to konieczne

class CourseController extends BaseController {
    public function __construct($db) {
        parent::__construct($db);
    }

    public function add($data) {
        // Dostosuj ogólną logikę dodawania kursu do konkretnych potrzeb
        if (isset($data['course_name'])) {
            $course_name = $data['course_name'];
            // Przykład: dodaj kurs do bazy danych
            $this->addCourse($course_name);
        }
        // Przekieruj na listę kursów po dodaniu
        $this->list();
    }

    public function list() {
        // Wykonaj ogólną logikę listowania kursów
        $courses = $this->getCourses();
        $this->renderView('course_list.php', ['courses' => $courses]);
    }

    public function delete($id) {
        // Dostosuj ogólną logikę usuwania kursu do konkretnych potrzeb
        if ($id) {
            try {
                // Przykład: usuń kurs o danym ID z bazy danych
                $this->deleteCourse($id);
            } catch (PDOException $e) {
                // Obsłuż błąd usuwania, np. kurs ma przypisane zadania
                $this->renderError('Cannot delete a course with assignments.');
            }
        }
        // Przekieruj na listę kursów po usunięciu
        $this->list();
    }

    private function addCourse($courseName) {
        // Przykład: dodaj kurs do bazy danych
        // $this->db->insert('courses', ['course_name' => $courseName]);
    }

    private function getCourses() {
        // Przykład: pobierz listę kursów z bazy danych
        // return $this->db->selectAll('courses');
        return []; // Zwróć pustą listę na potrzeby testów
    }

    private function deleteCourse($id) {
        // Przykład: usuń kurs o danym ID z bazy danych
        // $this->db->delete('courses', ['id' => $id]);
    }

    private function renderError($message) {
        // Metoda pomocnicza do renderowania widoku błędu
        $this->renderView('error.php', ['error' => $message]);
    }
}