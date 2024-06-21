<?php
class Volunteer {
    private $conn;
    private $table = 'Volunteer';

    public $volunteerId;
    public $name;
    public $contact;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function assignVolunteer() {
        $query = "INSERT INTO " . $this->table . " SET name=:name, contact=:contact, email=:email";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->contact = htmlspecialchars(strip_tags($this->contact));
        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':contact', $this->contact);
        $stmt->bindParam(':email', $this->email);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateVolunteer() {
        $query = "UPDATE " . $this->table . " SET name = ?, contact = ?, email = ? WHERE volunteerId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->contact = htmlspecialchars(strip_tags($this->contact));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->volunteerId = htmlspecialchars(strip_tags($this->volunteerId));
    
        $stmt->bind_param('sssi', $this->name, $this->contact, $this->email, $this->volunteerId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getAllVolunteers() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function deleteVolunteer() {
        $query = "DELETE FROM " . $this->table . " WHERE volunteerId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->volunteerId = htmlspecialchars(strip_tags($this->volunteerId));
        $stmt->bind_param('i', $this->volunteerId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
}
?>
