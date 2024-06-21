<?php
include_once '../models/MedicalRecord.php';
include_once '../includes/db.php';

class MedicalRecordController {
    private $conn;
    private $medicalRecord;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->medicalRecord = new MedicalRecord($this->conn);
    }

    public function updateRecord() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->medicalRecord->details = $_POST['details'];
            $this->medicalRecord->date = $_POST['date'];
            $this->medicalRecord->patientId = $_POST['patientId'];
            $this->medicalRecord->doctorId = $_POST['doctorId'];
            if ($this->medicalRecord->updateRecord()) {
                echo "Medical record updated successfully!";
            } else {
                echo "Failed to update medical record.";
            }
        }
    }

    public function viewRecords() {
        $this->medicalRecord->patientId = $_SESSION['userId'];
        $result = $this->medicalRecord->viewRecords();
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['date']} - {$row['details']}</li>";
        }
    }
}
?>
