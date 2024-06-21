<?php
include_once '../models/User.php';
include_once '../includes/db.php';

class UserController {
    private $conn;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->user = new User($this->conn);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->name = $_POST['name'];
            $this->user->email = $_POST['email'];
            $this->user->password = $_POST['password'];
            $this->user->roleId = $_POST['roleId'];
            if ($this->user->register()) {
                echo "Registration successful!";
            } else {
                echo "Failed to register.";
            }
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->email = $_POST['email'];
            $this->user->password = $_POST['password'];
            if ($this->user->login()) {
                echo "Login successful! Welcome " . $this->user->name;
            } else {
                echo "Failed to login.";
            }
        }
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->name = $_POST['name'];
            $this->user->email = $_POST['email'];
            $this->user->password = $_POST['password'];
            $this->user->userId = $_SESSION['userId'];
            if ($this->user->updateProfile()) {
                echo "Profile updated successfully!";
            } else {
                echo "Failed to update profile.";
            }
        }
    }
}
?>
