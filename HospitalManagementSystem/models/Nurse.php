<?php
class Nurse {
    private $conn;
    private $table = 'Nurse';

    public $nurseId;
    public $departmentId;
    public $userId;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function updateNurse() {
        $query = "UPDATE " . $this->table . " SET departmentId = ?, userId = ? WHERE nurseId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->departmentId = htmlspecialchars(strip_tags($this->departmentId));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->nurseId = htmlspecialchars(strip_tags($this->nurseId));
    
        $stmt->bind_param('iii', $this->departmentId, $this->userId, $this->nurseId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getAllNurses() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function deleteNurse() {
        $query = "DELETE FROM " . $this->table . " WHERE nurseId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->nurseId = htmlspecialchars(strip_tags($this->nurseId));
        $stmt->bind_param('i', $this->nurseId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    

    public function assistDoctor() {
        $query = "INSERT INTO AssistDoctor SET nurseId=:nurseId, doctorId=:doctorId";
        $stmt = $this->conn->prepare($query);

        $this->nurseId = htmlspecialchars(strip_tags($this->nurseId));
        $this->doctorId = htmlspecialchars(strip_tags($this->doctorId));

        $stmt->bindParam(':nurseId', $this->nurseId);
        $stmt->bindParam(':doctorId', $this->doctorId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function managePatientCare() {
        $query = "INSERT INTO ManagePatientCare SET nurseId=:nurseId, patientId=:patientId";
        $stmt = $this->conn->prepare($query);

        $this->nurseId = htmlspecialchars(strip_tags($this->nurseId));
        $this->patientId = htmlspecialchars(strip_tags($this->patientId));

        $stmt->bindParam(':nurseId', $this->nurseId);
        $stmt->bindParam(':patientId', $this->patientId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getNurseDetails($nurseId) {
        $query = "SELECT * FROM " . $this->table . " WHERE nurseId = :nurseId";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nurseId', $nurseId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->departmentId = $row['departmentId'];
            $this->userId = $row['userId'];
            return $row;
        }
        return null;
    }
}
?>
