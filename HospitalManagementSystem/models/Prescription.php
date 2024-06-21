<?php
class Prescription {
    private $conn;
    private $table = 'Prescription';

    public $prescriptionId;
    public $patientId;
    public $doctorId;
    public $medication;
    public $dosage;
    public $duration;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function issuePrescription() {
        $query = "INSERT INTO " . $this->table . " SET medication=?, dosage=?, duration=?, patientId=?, doctorId=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('ssiii', $this->medication, $this->dosage, $this->duration, $this->patientId, $this->doctorId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function viewPrescriptions($patientId) {
        $query = "SELECT * FROM " . $this->table . " WHERE patientId = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $patientId);
        $stmt->execute();
        return $stmt;
    }
}
?>
