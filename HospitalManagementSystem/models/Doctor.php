<?php
class Doctor {
    private $conn;
    private $table = 'Doctor';

    public $doctorId;
    public $specialization;
    public $departmentId;
    public $userId;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function updateDoctor() {
        $query = "UPDATE " . $this->table . " SET specialization = ?, departmentId = ?, userId = ? WHERE doctorId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->specialization = htmlspecialchars(strip_tags($this->specialization));
        $this->departmentId = htmlspecialchars(strip_tags($this->departmentId));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->doctorId = htmlspecialchars(strip_tags($this->doctorId));
    
        $stmt->bind_param('siii', $this->specialization, $this->departmentId, $this->userId, $this->doctorId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getAllDoctors() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function deleteDoctor() {
        $query = "DELETE FROM " . $this->table . " WHERE doctorId = ?";
        $stmt = $this->conn->prepare($query);
        
        $this->doctorId = htmlspecialchars(strip_tags($this->doctorId));
        $stmt->bind_param('i', $this->doctorId);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    

    public function scheduleAppointment() {
        $query = "INSERT INTO Appointment SET appointmentDate=:appointmentDate, patientId=:patientId, doctorId=:doctorId, nurseId=:nurseId, status=:status";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':appointmentDate', $this->appointmentDate);
        $stmt->bindParam(':patientId', $this->patientId);
        $stmt->bindParam(':doctorId', $this->doctorId);
        $stmt->bindParam(':nurseId', $this->nurseId);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function writePrescription() {
        $query = "INSERT INTO Prescription SET patientId=:patientId, doctorId=:doctorId, medication=:medication, dosage=:dosage, duration=:duration";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':patientId', $this->patientId);
        $stmt->bindParam(':doctorId', $this->doctorId);
        $stmt->bindParam(':medication', $this->medication);
        $stmt->bindParam(':dosage', $this->dosage);
        $stmt->bindParam(':duration', $this->duration);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
}
?>
