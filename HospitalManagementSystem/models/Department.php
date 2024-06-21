<?php
class Department {
    private $conn;
    private $table = 'Department';

    public $departmentId;
    public $name;
    public $description;
    public $headId;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addDepartment() {
        $query = "INSERT INTO " . $this->table . " SET name=:name, description=:description, headId=:headId";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->headId = htmlspecialchars(strip_tags($this->headId));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':headId', $this->headId);

        return $stmt->execute();
    }

    

    public function updateDepartment() {
        $query = "UPDATE " . $this->table . " SET name = ?, description = ?, headId = ? WHERE departmentId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->headId = htmlspecialchars(strip_tags($this->headId));
        $this->departmentId = htmlspecialchars(strip_tags($this->departmentId));
    
        $stmt->bind_param('ssii', $this->name, $this->description, $this->headId, $this->departmentId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getAllDepartments() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function deleteDepartment() {
        $query = "DELETE FROM " . $this->table . " WHERE departmentId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->departmentId = htmlspecialchars(strip_tags($this->departmentId));
        $stmt->bind_param('i', $this->departmentId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
}
?>
