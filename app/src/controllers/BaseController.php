<?php
namespace Newde\MvcAssignmentTracker\controllers;

// BaseController.php


abstract class BaseController {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Metoda do renderowania widoku.
     *
     * @param string $viewName Nazwa pliku widoku.
     * @param array $data Dane do przekazania do widoku.
     */
    protected function renderView($viewName, $data = []) {
        extract($data);
        $viewPath = __DIR__ . '/../views/' . $viewName;

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "Widok $viewName nie został znaleziony.";
        }
    }

    /**
     * Ogólna logika dodawania.
     *
     * @param array $data Dane do dodania.
     */
    public function addAction($data) {
        // Przyjmij dane i wykonaj ogólną logikę dodawania
        // $data to tablica z danymi przekazanymi z formularza lub innego źródła

        // Przykład:
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
     * Ogólna logika listowania.
     */
    public function listAction() {
        // Wykonaj ogólną logikę listowania

        // Przykład:
        // $items = $this->db->selectAll('table_name');
        // $this->renderView('list_view.php', ['items' => $items]);
        $items = $this->db->getAll('table_name');
        $this->renderView('list_view.php', ['items' => $items]);
    }

    /**
     * Ogólna logika usuwania.
     *
     * @param int $id ID elementu do usunięcia.
     */
    public function deleteAction($id) {
        // Przyjmij ID elementu i wykonaj ogólną logikę usuwania

        // Przykład:
        // $this->db->delete('table_name', ['id' => $id]);
        $this->db->delete('table_name', ['id' => $id]);
    }
}