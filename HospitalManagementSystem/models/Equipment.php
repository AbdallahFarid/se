<?php
class Equipment {
    private $conn;
    private $table = 'Equipment';

    public $equipmentId;
    public $name;
    public $departmentId;
    public $roomId;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addEquipment() {
        $query = "INSERT INTO " . $this->table . " SET name=:name, departmentId=:departmentId, roomId=:roomId, status=:status";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->departmentId = htmlspecialchars(strip_tags($this->departmentId));
        $this->roomId = htmlspecialchars(strip_tags($this->roomId));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':departmentId', $this->departmentId);
        $stmt->bindParam(':roomId', $this->roomId);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateEquipment() {
        $query = "UPDATE " . $this->table . " SET name = ?, departmentId = ?, roomId = ?, status = ? WHERE equipmentId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->departmentId = htmlspecialchars(strip_tags($this->departmentId));
        $this->roomId = htmlspecialchars(strip_tags($this->roomId));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->equipmentId = htmlspecialchars(strip_tags($this->equipmentId));
    
        $stmt->bind_param('sisii', $this->name, $this->departmentId, $this->roomId, $this->status, $this->equipmentId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getAllEquipment() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function deleteEquipment() {
        $query = "DELETE FROM " . $this->table . " WHERE equipmentId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->equipmentId = htmlspecialchars(strip_tags($this->equipmentId));
        $stmt->bind_param('i', $this->equipmentId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
}
?>
