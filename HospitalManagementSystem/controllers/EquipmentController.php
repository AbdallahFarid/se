<?php
include_once '../models/Equipment.php';
include_once '../includes/db.php';

class EquipmentController {
    private $conn;
    private $equipment;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->equipment = new Equipment($this->conn);
    }

    public function addEquipment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->equipment->name = $_POST['name'];
            $this->equipment->departmentId = $_POST['departmentId'];
            $this->equipment->roomId = $_POST['roomId'];
            $this->equipment->status = $_POST['status'];
            if ($this->equipment->addEquipment()) {
                echo "Equipment added successfully!";
            } else {
                echo "Failed to add equipment.";
            }
        }
    }

    public function updateEquipment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->equipment->name = $_POST['name'];
            $this->equipment->departmentId = $_POST['departmentId'];
            $this->equipment->roomId = $_POST['roomId'];
            $this->equipment->status = $_POST['status'];
            $this->equipment->equipmentId = $_POST['equipmentId'];
            if ($this->equipment->updateEquipment()) {
                echo "Equipment updated successfully!";
            } else {
                echo "Failed to update equipment.";
            }
        }
    }

    public function deleteEquipment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->equipment->equipmentId = $_POST['equipmentId'];
            if ($this->equipment->deleteEquipment()) {
                echo "Equipment deleted successfully!";
            } else {
                echo "Failed to delete equipment.";
            }
        }
    }
}
?>
