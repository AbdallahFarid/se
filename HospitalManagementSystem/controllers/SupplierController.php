<?php
include_once '../models/Supplier.php';
include_once '../includes/db.php';

class SupplierController {
    private $conn;
    private $supplier;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->supplier = new Supplier($this->conn);
    }

    public function addSupplier() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->supplier->name = $_POST['name'];
            $this->supplier->contact = $_POST['contact'];
            $this->supplier->address = $_POST['address'];
            if ($this->supplier->addSupplier()) {
                echo "Supplier added successfully!";
            } else {
                echo "Failed to add supplier.";
            }
        }
    }

    public function updateSupplier() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->supplier->name = $_POST['name'];
            $this->supplier->contact = $_POST['contact'];
            $this->supplier->address = $_POST['address'];
            $this->supplier->supplierId = $_POST['supplierId'];
            if ($this->supplier->updateSupplier()) {
                echo "Supplier updated successfully!";
            } else {
                echo "Failed to update supplier.";
            }
        }
    }

    public function deleteSupplier() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->supplier->supplierId = $_POST['supplierId'];
            if ($this->supplier->deleteSupplier()) {
                echo "Supplier deleted successfully!";
            } else {
                echo "Failed to delete supplier.";
            }
        }
    }

    public function viewSuppliers() {
        $result = $this->supplier->viewSuppliers();
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['name']} - {$row['contact']}</li>";
        }
    }
}
?>
