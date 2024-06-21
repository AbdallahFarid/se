<?php
include_once '../models/Order.php';
include_once '../includes/db.php';

class OrderController {
    private $conn;
    private $order;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->order = new Order($this->conn);
    }

    public function placeOrder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->order->orderDate = $_POST['orderDate'];
            $this->order->supplierId = $_POST['supplierId'];
            $this->order->status = $_POST['status'];
            $this->order->departmentId = $_POST['departmentId'];
            if ($this->order->placeOrder()) {
                echo "Order placed successfully!";
            } else {
                echo "Failed to place order.";
            }
        }
    }

    public function updateOrder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->order->orderDate = $_POST['orderDate'];
            $this->order->supplierId = $_POST['supplierId'];
            $this->order->status = $_POST['status'];
            $this->order->departmentId = $_POST['departmentId'];
            $this->order->orderId = $_POST['orderId'];
            if ($this->order->updateOrder()) {
                echo "Order updated successfully!";
            } else {
                echo "Failed to update order.";
            }
        }
    }

    public function cancelOrder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->order->orderId = $_POST['orderId'];
            if ($this->order->cancelOrder()) {
                echo "Order canceled successfully!";
            } else {
                echo "Failed to cancel order.";
            }
        }
    }

    public function viewOrders() {
        $result = $this->order->viewOrders();
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['orderDate']} - {$row['status']}</li>";
        }
    }
}
?>
