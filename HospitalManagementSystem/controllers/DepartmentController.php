<?php
include_once '../models/Department.php';
include_once '../includes/db.php';

class DepartmentController {
    private $conn;
    private $department;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->department = new Department($this->conn);
    }

    public function addDepartment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->department->name = $_POST['name'];
            $this->department->description = $_POST['description'];
            $this->department->headId = $_POST['headId'];
            if ($this->department->addDepartment()) {
                echo "Department added successfully!";
            } else {
                echo "Failed to add department.";
            }
        }
    }

    public function updateDepartment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->department->name = $_POST['name'];
            $this->department->description = $_POST['description'];
            $this->department->headId = $_POST['headId'];
            $this->department->departmentId = $_POST['departmentId'];
            if ($this->department->updateDepartment()) {
                echo "Department updated successfully!";
            } else {
                echo "Failed to update department.";
            }
        }
    }

    public function deleteDepartment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->department->departmentId = $_POST['departmentId'];
            if ($this->department->deleteDepartment()) {
                echo "Department deleted successfully!";
            } else {
                echo "Failed to delete department.";
            }
        }
    }
}
?>
