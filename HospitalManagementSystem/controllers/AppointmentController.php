<?php
include_once '../models/Appointment.php';
include_once '../includes/db.php';

class AppointmentController {
    private $conn;
    private $appointment;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->appointment = new Appointment($this->conn);
    }

    public function bookAppointment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->appointment->appointmentDate = $_POST['appointmentDate'];
            $this->appointment->patientId = $_POST['patientId'];
            $this->appointment->doctorId = $_POST['doctorId'];
            $this->appointment->nurseId = $_POST['nurseId'];
            $this->appointment->status = $_POST['status'];
            if ($this->appointment->bookAppointment()) {
                echo "Appointment booked successfully!";
            } else {
                echo "Failed to book appointment.";
            }
        }
    }

    public function viewAppointments() {
        $result = $this->appointment->viewAppointments($_SESSION['userId']);
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['appointmentDate']} - {$row['status']}</li>";
        }
    }

    public function updateAppointment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->appointment->appointmentDate = $_POST['appointmentDate'];
            $this->appointment->patientId = $_POST['patientId'];
            $this->appointment->doctorId = $_POST['doctorId'];
            $this->appointment->nurseId = $_POST['nurseId'];
            $this->appointment->status = $_POST['status'];
            $this->appointment->appointmentId = $_POST['appointmentId'];
            if ($this->appointment->updateAppointment()) {
                echo "Appointment updated successfully!";
            } else {
                echo "Failed to update appointment.";
            }
        }
    }

    public function cancelAppointment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->appointment->appointmentId = $_POST['appointmentId'];
            if ($this->appointment->cancelAppointment()) {
                echo "Appointment canceled successfully!";
            } else {
                echo "Failed to cancel appointment.";
            }
        }
    }
}
?>
