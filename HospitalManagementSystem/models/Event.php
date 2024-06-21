<?php
class Event {
    private $conn;
    private $table = 'Event';

    public $eventId;
    public $name;
    public $date;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function organizeEvent() {
        $query = "INSERT INTO " . $this->table . " SET name=:name, date=:date, description=:description";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':description', $this->description);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateEvent() {
        $query = "UPDATE " . $this->table . " SET name = ?, date = ?, description = ? WHERE eventId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->eventId = htmlspecialchars(strip_tags($this->eventId));
    
        $stmt->bind_param('sssi', $this->name, $this->date, $this->description, $this->eventId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getAllEvents() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function deleteEvent() {
        $query = "DELETE FROM " . $this->table . " WHERE eventId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->eventId = htmlspecialchars(strip_tags($this->eventId));
        $stmt->bind_param('i', $this->eventId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
}
?>
