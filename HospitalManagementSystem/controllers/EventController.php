<?php
include_once '../models/Event.php';
include_once '../includes/db.php';

class EventController {
    private $conn;
    private $event;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->event = new Event($this->conn);
    }

    public function organizeEvent() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->event->name = $_POST['name'];
            $this->event->date = $_POST['date'];
            $this->event->description = $_POST['description'];
            if ($this->event->organizeEvent()) {
                echo "Event organized successfully!";
            } else {
                echo "Failed to organize event.";
            }
        }
    }

    public function viewEvents() {
        $result = $this->event->viewEvents();
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['name']} - {$row['description']}</li>";
        }
    }
}
?>
