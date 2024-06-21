<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/Invoice.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$invoice = new Invoice($conn);

// Handle add/edit invoice request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $invoice->orderId = $_POST['orderId'];
    $invoice->amount = $_POST['amount'];
    $invoice->status = $_POST['status'];

    if (isset($_POST['invoiceId']) && !empty($_POST['invoiceId'])) {
        // Update existing invoice
        $invoice->invoiceId = $_POST['invoiceId'];
        if ($invoice->updateInvoice()) {
            echo "<p>Invoice updated successfully!</p>";
        } else {
            echo "<p>Failed to update invoice.</p>";
        }
    } else {
        // Add new invoice
        if ($invoice->issueInvoice()) {
            echo "<p>Invoice added successfully!</p>";
        } else {
            echo "<p>Failed to add invoice.</p>";
        }
    }
}

// Handle delete invoice request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $invoice->invoiceId = $_GET['id'];
    if ($invoice->deleteInvoice()) {
        echo "<p>Invoice deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete invoice.</p>";
    }
}

// Fetch all invoices
$invoices = $invoice->getAllInvoices();
?>

<div class="container">
    <h2>Manage Invoices</h2>

    <h3>Add/Edit Invoice</h3>
    <form method="POST">
        <input type="hidden" id="invoiceId" name="invoiceId">
        <label for="orderId">Order ID:</label>
        <input type="number" id="orderId" name="orderId" required>
        <label for="amount">Amount:</label>
        <input type="number" step="0.01" id="amount" name="amount" required>
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" required>
        <button type="submit">Save Invoice</button>
    </form>

    <h3>All Invoices</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Order ID</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $invoices->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['invoiceId']; ?></td>
                    <td><?php echo $row['orderId']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <button onclick="editInvoice('<?php echo $row['invoiceId']; ?>', '<?php echo $row['orderId']; ?>', '<?php echo $row['amount']; ?>', '<?php echo $row['status']; ?>')">Edit</button>
                        <a href="invoices.php?action=delete&id=<?php echo $row['invoiceId']; ?>" onclick="return confirm('Are you sure you want to delete this invoice?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editInvoice(invoiceId, orderId, amount, status) {
    document.getElementById('invoiceId').value = invoiceId;
    document.getElementById('orderId').value = orderId;
    document.getElementById('amount').value = amount;
    document.getElementById('status').value = status;
}
</script>

<?php include '../includes/footer.php'; ?>
