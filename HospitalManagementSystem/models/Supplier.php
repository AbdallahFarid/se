<?php
class Supplier {
    private $conn;
    private $table = 'Supplier';

    public $supplierId;
    public $name;
    public $contact;
    public $address;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addSupplier() {
        $query = "INSERT INTO " . $this->table . " SET name=:name, contact=:contact, address=:address";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->contact = htmlspecialchars(strip_tags($this->contact));
        $this->address = htmlspecialchars(strip_tags($this->address));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':contact', $this->contact);
        $stmt->bindParam(':address', $this->address);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateSupplier() {
        $query = "UPDATE " . $this->table . " SET name = ?, contact = ?, address = ? WHERE supplierId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->contact = htmlspecialchars(strip_tags($this->contact));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->supplierId = htmlspecialchars(strip_tags($this->supplierId));
    
        $stmt->bind_param('sssi', $this->name, $this->contact, $this->address, $this->supplierId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getAllSuppliers() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function deleteSupplier() {
        $query = "DELETE FROM " . $this->table . " WHERE supplierId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->supplierId = htmlspecialchars(strip_tags($this->supplierId));
        $stmt->bind_param('i', $this->supplierId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
}
?>
