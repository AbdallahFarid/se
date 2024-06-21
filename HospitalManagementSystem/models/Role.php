<?php
class Role {
    private $conn;
    private $table = 'Role';

    public $roleId;
    public $roleName;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addRole() {
        $query = "INSERT INTO " . $this->table . " SET roleName=:roleName, description=:description";
        $stmt = $this->conn->prepare($query);

        $this->roleName = htmlspecialchars(strip_tags($this->roleName));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(':roleName', $this->roleName);
        $stmt->bindParam(':description', $this->description);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateRole() {
        $query = "UPDATE " . $this->table . " SET roleName = :roleName, description = :description WHERE roleId = :roleId";
        $stmt = $this->conn->prepare($query);

        $this->roleName = htmlspecialchars(strip_tags($this->roleName));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->roleId = htmlspecialchars(strip_tags($this->roleId));

        $stmt->bindParam(':roleName', $this->roleName);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':roleId', $this->roleId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function getAllRoles() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    

    public function deleteRole() {
        $query = "DELETE FROM " . $this->table . " WHERE roleId = :roleId";
        $stmt = $this->conn->prepare($query);

        $this->roleId = htmlspecialchars(strip_tags($this->roleId));
        $stmt->bindParam(':roleId', $this->roleId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
