<?php
class User {
    private $conn;
    private $table = 'User';

    public $userId;
    public $name;
    public $email;
    public $password;
    public $roleId;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $query = "INSERT INTO " . $this->table . " SET name=?, email=?, password=?, roleId=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('sssi', $this->name, $this->email, $this->password, $this->roleId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function updateUser() {
        $query = "UPDATE " . $this->table . " SET name = ?, email = ?, password = ?, roleId = ? WHERE userId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->roleId = htmlspecialchars(strip_tags($this->roleId));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
    
        $stmt->bind_param('sssii', $this->name, $this->email, $this->password, $this->roleId, $this->userId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function deleteUser() {
        $query = "DELETE FROM " . $this->table . " WHERE userId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $stmt->bind_param('i', $this->userId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    
    

    public function login() {
        $query = "SELECT * FROM " . $this->table . " WHERE email = ? AND password = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
    
        $stmt->bind_param('ss', $this->email, $this->password);
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->userId = $row['userId'];
            $this->name = $row['name'];
            $this->roleId = $row['roleId'];
            return true;
        }
        return false;
    }
    
    

    public function updateProfile() {
        $query = "UPDATE " . $this->table . " SET name = ?, email = ?, password = ?, roleId = ? WHERE userId = ?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('sssii', $this->name, $this->email, $this->password, $this->roleId, $this->userId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getUserDetails() {
        $query = "SELECT * FROM " . $this->table . " WHERE userId = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $this->userId);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->name = $row['name'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->roleId = $row['roleId'];
        }
    }
}



?>
