<?php
class Patient {
    private $conn;
    private $table = 'Patient';

    public $patientId;
    public $name;
    public $dob;
    public $gender;
    public $address;
    public $phone;
    public $medicalHistory;
    public $userId;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $query = "INSERT INTO " . $this->table . " SET name=:name, dob=:dob, gender=:gender, address=:address, phone=:phone, medicalHistory=:medicalHistory, userId=:userId";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->dob = htmlspecialchars(strip_tags($this->dob));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->medicalHistory = htmlspecialchars(strip_tags($this->medicalHistory));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':dob', $this->dob);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':medicalHistory', $this->medicalHistory);
        $stmt->bindParam(':userId', $this->userId);

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

    public function viewMedicalRecord() {
        $query = "SELECT * FROM MedicalRecord WHERE patientId = :patientId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':patientId', $this->patientId);
        $stmt->execute();
        return $stmt;
    }

    public function updatePatient() {
        $query = "UPDATE " . $this->table . " SET name = ?, dob = ?, gender = ?, address = ?, phone = ?, medicalHistory = ?, userId = ? WHERE patientId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->dob = htmlspecialchars(strip_tags($this->dob));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->medicalHistory = htmlspecialchars(strip_tags($this->medicalHistory));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->patientId = htmlspecialchars(strip_tags($this->patientId));
    
        $stmt->bind_param('ssssssii', $this->name, $this->dob, $this->gender, $this->address, $this->phone, $this->medicalHistory, $this->userId, $this->patientId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getAllPatients() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function deletePatient() {
        $query = "DELETE FROM " . $this->table . " WHERE patientId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->patientId = htmlspecialchars(strip_tags($this->patientId));
        $stmt->bind_param('i', $this->patientId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
}
?>
