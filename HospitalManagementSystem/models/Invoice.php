<?php
class Invoice {
    private $conn;
    private $table = 'Invoice';

    public $invoiceId;
    public $orderId;
    public $amount;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function issueInvoice() {
        $query = "INSERT INTO " . $this->table . " SET orderId=:orderId, amount=:amount, status=:status";
        $stmt = $this->conn->prepare($query);

        $this->orderId = htmlspecialchars(strip_tags($this->orderId));
        $this->amount = htmlspecialchars(strip_tags($this->amount));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(':orderId', $this->orderId);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateInvoice() {
        $query = "UPDATE " . $this->table . " SET orderId = ?, amount = ?, status = ? WHERE invoiceId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->orderId = htmlspecialchars(strip_tags($this->orderId));
        $this->amount = htmlspecialchars(strip_tags($this->amount));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->invoiceId = htmlspecialchars(strip_tags($this->invoiceId));
    
        $stmt->bind_param('idsi', $this->orderId, $this->amount, $this->status, $this->invoiceId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function getAllInvoices() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function deleteInvoice() {
        $query = "DELETE FROM " . $this->table . " WHERE invoiceId = ?";
        $stmt = $this->conn->prepare($query);
    
        $this->invoiceId = htmlspecialchars(strip_tags($this->invoiceId));
        $stmt->bind_param('i', $this->invoiceId);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
}
?>
