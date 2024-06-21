<?php
include_once '../models/Patient.php';
include_once '../includes/db.php';

class PatientController {
    private $conn;
    private $patient;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->patient = new Patient($this->conn);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->patient->name = $_POST['name'];
            $this->patient->dob = $_POST['dob'];
            $this->patient->gender = $_POST['gender'];
            $this->patient->address = $_POST['address'];
            $this->patient->phone = $_POST['phone'];
            $this->patient->medicalHistory = $_POST['medicalHistory'];
            $this->patient->userId = $_POST['userId'];
            if ($this->patient->register()) {
                echo "Patient registered successfully!";
            } else {
                echo "Failed to register patient.";
            }
        }
    }

    public function scheduleAppointment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->patient->appointmentDate = $_POST['appointmentDate'];
            $this->patient->patientId = $_POST['patientId'];
            $this->patient->doctorId = $_POST['doctorId'];
            $this->patient->nurseId = $_POST['nurseId'];
            $this->patient->status = $_POST['status'];
            if ($this->patient->scheduleAppointment()) {
                echo "Appointment scheduled successfully!";
            } else {
                echo "Failed to schedule appointment.";
            }
        }
    }

    public function viewMedicalRecord() {
        $this->patient->patientId = $_SESSION['userId'];
        $result = $this->patient->viewMedicalRecord();
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['date']} - {$row['details']}</li>";
        }
    }
}
?>
