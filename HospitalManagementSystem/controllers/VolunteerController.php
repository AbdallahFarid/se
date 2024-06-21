<?php
include_once '../models/Volunteer.php';
include_once '../includes/db.php';

class VolunteerController {
    private $conn;
    private $volunteer;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->volunteer = new Volunteer($this->conn);
    }

    public function assignVolunteer() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->volunteer->name = $_POST['name'];
            $this->volunteer->contact = $_POST['contact'];
            $this->volunteer->email = $_POST['email'];
            if ($this->volunteer->assignVolunteer()) {
                echo "Volunteer assigned successfully!";
            } else {
                echo "Failed to assign volunteer.";
            }
        }
    }

    public function viewVolunteerTasks() {
        $result = $this->volunteer->viewVolunteerTasks();
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['name']} - {$row['contact']}</li>";
        }
    }
}
?>
