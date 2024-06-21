<?php
class Room {
    private $conn;
    private $table = 'Room';

    public $roomId;
    public $roomNumber;
    public $departmentId;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function updateRoom() {
        $query = "UPDATE " . $this->table . " SET roomNumber = ?, departmentId = ?, status = ? WHERE roomId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->roomNumber = htmlspecialchars(strip_tags($this->roomNumber));
        $this->departmentId = htmlspecialchars(strip_tags($this->departmentId));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->roomId = htmlspecialchars(strip_tags($this->roomId));
    
        $stmt->bind_param('sisi', $this->roomNumber, $this->departmentId, $this->status, $this->roomId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getAllRooms() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function deleteRoom() {
        $query = "DELETE FROM " . $this->table . " WHERE roomId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->roomId = htmlspecialchars(strip_tags($this->roomId));
        $stmt->bind_param('i', $this->roomId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    

    public function assignRoom() {
        $query = "INSERT INTO " . $this->table . " SET roomNumber=:roomNumber, departmentId=:departmentId, status=:status";
        $stmt = $this->conn->prepare($query);

        $this->roomNumber = htmlspecialchars(strip_tags($this->roomNumber));
        $this->departmentId = htmlspecialchars(strip_tags($this->departmentId));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(':roomNumber', $this->roomNumber);
        $stmt->bindParam(':departmentId', $this->departmentId);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateRoomStatus() {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE roomId = :roomId";
        $stmt = $this->conn->prepare($query);

        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->roomId = htmlspecialchars(strip_tags($this->roomId));

        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':roomId', $this->roomId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
