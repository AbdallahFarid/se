<?php
class Order {
    private $conn;
    private $table = '`Order`';

    public $orderId;
    public $orderDate;
    public $supplierId;
    public $status;
    public $departmentId;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function placeOrder() {
        $query = "INSERT INTO " . $this->table . " (orderDate, supplierId, status, departmentId) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $this->orderDate = htmlspecialchars(strip_tags($this->orderDate));
        $this->supplierId = htmlspecialchars(strip_tags($this->supplierId));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->departmentId = htmlspecialchars(strip_tags($this->departmentId));

        $stmt->bind_param('sisi', $this->orderDate, $this->supplierId, $this->status, $this->departmentId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateOrder() {
        $query = "UPDATE " . $this->table . " SET orderDate = ?, supplierId = ?, status = ?, departmentId = ? WHERE orderId = ?";
        $stmt = $this->conn->prepare($query);

        $this->orderDate = htmlspecialchars(strip_tags($this->orderDate));
        $this->supplierId = htmlspecialchars(strip_tags($this->supplierId));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->departmentId = htmlspecialchars(strip_tags($this->departmentId));
        $this->orderId = htmlspecialchars(strip_tags($this->orderId));

        $stmt->bind_param('sisii', $this->orderDate, $this->supplierId, $this->status, $this->departmentId, $this->orderId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAllOrders() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function deleteOrder() {
        $query = "DELETE FROM " . $this->table . " WHERE orderId = ?";
        $stmt = $this->conn->prepare($query);

        $this->orderId = htmlspecialchars(strip_tags($this->orderId));
        $stmt->bind_param('i', $this->orderId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

?>
