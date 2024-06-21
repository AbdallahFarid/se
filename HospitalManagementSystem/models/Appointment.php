<?php
class Appointment {
    private $conn;
    private $table = 'Appointment';

    public $appointmentId;
    public $appointmentDate;
    public $patientId;
    public $doctorId;
    public $nurseId;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function bookAppointment() {
        $query = "INSERT INTO " . $this->table . " SET appointmentDate=?, patientId=?, doctorId=?, nurseId=?, status=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('siiis', $this->appointmentDate, $this->patientId, $this->doctorId, $this->nurseId, $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function viewAppointments($userId) {
        $query = "SELECT * FROM " . $this->table . " WHERE patientId = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt;
    }
}
?>
