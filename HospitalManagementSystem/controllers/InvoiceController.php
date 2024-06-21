<?php
include_once '../models/Invoice.php';
include_once '../includes/db.php';

class InvoiceController {
    private $conn;
    private $invoice;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->invoice = new Invoice($this->conn);
    }

    public function issueInvoice() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->invoice->orderId = $_POST['orderId'];
            $this->invoice->amount = $_POST['amount'];
            $this->invoice->status = $_POST['status'];
            if ($this->invoice->issueInvoice()) {
                echo "Invoice issued successfully!";
            } else {
                echo "Failed to issue invoice.";
            }
        }
    }

    public function viewInvoices() {
        $result = $this->invoice->viewInvoices();
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['amount']} - {$row['status']}</li>";
        }
    }
}
?>
