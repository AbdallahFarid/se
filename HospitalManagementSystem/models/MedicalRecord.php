<?php
class MedicalRecord {
    private $conn;
    private $table = 'MedicalRecord';

    public $recordId;
    public $patientId;
    public $details;
    public $date;
    public $doctorId;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function updateRecord() {
        $query = "INSERT INTO " . $this->table . " (patientId, details, date, doctorId) VALUES (:patientId, :details, :date, :doctorId)";
        $stmt = $this->conn->prepare($query);

        $this->patientId = htmlspecialchars(strip_tags($this->patientId));
        $this->details = htmlspecialchars(strip_tags($this->details));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->doctorId = htmlspecialchars(strip_tags($this->doctorId));

        $stmt->bindParam(':patientId', $this->patientId);
        $stmt->bindParam(':details', $this->details);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':doctorId', $this->doctorId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function viewRecords($patientId) {
        $stmt = $this->conn->prepare("SELECT * FROM MedicalRecord WHERE patientId = ?");
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
?>
