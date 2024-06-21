<?php
include_once '../models/Nurse.php';
include_once '../includes/db.php';

class NurseController {
    private $conn;
    private $nurse;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->nurse = new Nurse($this->conn);
    }

    public function assistDoctor() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->nurse->departmentId = $_POST['departmentId'];
            $this->nurse->userId = $_POST['userId'];
            if ($this->nurse->assistDoctor()) {
                echo "Nurse assigned to assist doctor successfully!";
            } else {
                echo "Failed to assign nurse.";
            }
        }
    }

    public function managePatientCare() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->nurse->departmentId = $_POST['departmentId'];
            $this->nurse->userId = $_POST['userId'];
            if ($this->nurse->managePatientCare()) {
                echo "Nurse assigned to manage patient care successfully!";
            } else {
                echo "Failed to assign nurse.";
            }
        }
    }
}
?>
