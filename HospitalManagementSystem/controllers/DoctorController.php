<?php
include_once '../models/Doctor.php';
include_once '../includes/db.php';

class DoctorController {
    private $conn;
    private $doctor;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->doctor = new Doctor($this->conn);
    }

    public function scheduleAppointment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->doctor->appointmentDate = $_POST['appointmentDate'];
            $this->doctor->patientId = $_POST['patientId'];
            $this->doctor->doctorId = $_POST['doctorId'];
            $this->doctor->nurseId = $_POST['nurseId'];
            $this->doctor->status = $_POST['status'];
            if ($this->doctor->scheduleAppointment()) {
                echo "Appointment scheduled successfully!";
            } else {
                echo "Failed to schedule appointment.";
            }
        }
    }

    public function writePrescription() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->doctor->medication = $_POST['medication'];
            $this->doctor->dosage = $_POST['dosage'];
            $this->doctor->duration = $_POST['duration'];
            $this->doctor->patientId = $_POST['patientId'];
            $this->doctor->doctorId = $_POST['doctorId'];
            if ($this->doctor->writePrescription()) {
                echo "Prescription issued successfully!";
            } else {
                echo "Failed to issue prescription.";
            }
        }
    }
}
?>
