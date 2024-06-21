<?php
include_once '../models/Role.php';
include_once '../includes/db.php';

class RoleController {
    private $conn;
    private $role;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->role = new Role($this->conn);
    }

    public function addRole() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->role->roleName = $_POST['roleName'];
            $this->role->description = $_POST['description'];
            if ($this->role->addRole()) {
                echo "Role added successfully!";
            } else {
                echo "Failed to add role.";
            }
        }
    }

    public function updateRole() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->role->roleName = $_POST['roleName'];
            $this->role->description = $_POST['description'];
            $this->role->roleId = $_POST['roleId'];
            if ($this->role->updateRole()) {
                echo "Role updated successfully!";
            } else {
                echo "Failed to update role.";
            }
        }
    }

    public function deleteRole() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->role->roleId = $_POST['roleId'];
            if ($this->role->deleteRole()) {
                echo "Role deleted successfully!";
            } else {
                echo "Failed to delete role.";
            }
        }
    }
}
?>
