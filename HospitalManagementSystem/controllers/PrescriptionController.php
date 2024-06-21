<?php
include_once '../models/Prescription.php';
include_once '../includes/db.php';

class PrescriptionController {
    private $conn;
    private $prescription;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->prescription = new Prescription($this->conn);
    }

    public function issuePrescription() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->prescription->medication = $_POST['medication'];
            $this->prescription->dosage = $_POST['dosage'];
            $this->prescription->duration = $_POST['duration'];
            $this->prescription->patientId = $_POST['patientId'];
            $this->prescription->doctorId = $_POST['doctorId'];
            if ($this->prescription->issuePrescription()) {
                echo "Prescription issued successfully!";
            } else {
                echo "Failed to issue prescription.";
            }
        }
    }

    public function viewPrescriptions() {
        $result = $this->prescription->viewPrescriptions($_SESSION['userId']);
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['date']} - {$row['medication']} - {$row['dosage']} - {$row['duration']}</li>";
        }
    }
}
?>
