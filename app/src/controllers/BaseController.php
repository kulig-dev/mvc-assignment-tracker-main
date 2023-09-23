<?php
namespace Newde\MvcAssignmentTracker\controllers;

/**
 * BaseController.php
 */
abstract class BaseController {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Method for rendering a view.
     *
     * @param string $viewName View file name.
     * @param array $data Data to pass to the view.
     */
    protected function renderView($viewName, $data = []) {
        extract($data);
        $viewPath = __DIR__ . '/../views/' . $viewName;

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "View $viewName not found.";
        }
    }

    /**
     * General logic for adding data.
     *
     * @param array $data Data to add.
     */
    public function addAction($data) {
        // Accept data and perform general logic for adding
        // $data is an array with data received from a form or other source

        // Example:
        // if (isset($data['field1']) && isset($data['field2'])) {
        //     $this->db->insert('table_name', [
        //         'column1' => $data['field1'],
        //         'column2' => $data['field2'],
        //     ]);
        // }
        if (isset($data['field1']) && isset($data['field2'])) {
            $this->db->insert('table_name', [
                'column1' => $data['field1'],
                'column2' => $data['field2'],
            ]);
        }
    }

    /**
     * General logic for listing data.
     */
    public function listAction() {
        // Perform general logic for listing

        // Example:
        // $items = $this->db->selectAll('table_name');
        // $this->renderView('list_view.php', ['items' => $items]);
        $items = $this->db->getAll('table_name');
        $this->renderView('list_view.php', ['items' => $items]);
    }

    /**
     * General logic for deleting data.
     *
     * @param int $id ID of the element to delete.
     */
    public function deleteAction($id) {
        // Accept an ID and perform general logic for deleting

        // Example:
        // $this->db->delete('table_name', ['id' => $id]);
        $this->db->delete('table_name', ['id' => $id]);
    }
}