<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/Order.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$order = new Order($conn);

// Handle add/edit order request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order->orderDate = $_POST['orderDate'];
    $order->supplierId = $_POST['supplierId'];
    $order->status = $_POST['status'];
    $order->departmentId = $_POST['departmentId'];

    if (isset($_POST['orderId']) && !empty($_POST['orderId'])) {
        // Update existing order
        $order->orderId = $_POST['orderId'];
        if ($order->updateOrder()) {
            echo "<p>Order updated successfully!</p>";
        } else {
            echo "<p>Failed to update order.</p>";
        }
    } else {
        // Add new order
        if ($order->placeOrder()) {
            echo "<p>Order added successfully!</p>";
        } else {
            echo "<p>Failed to add order.</p>";
        }
    }
}

// Handle delete order request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $order->orderId = $_GET['id'];
    if ($order->deleteOrder()) {
        echo "<p>Order deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete order.</p>";
    }
}

// Fetch all orders
$orders = $order->getAllOrders();
?>

<div class="container">
    <h2>Manage Orders</h2>

    <h3>Add/Edit Order</h3>
    <form method="POST">
        <input type="hidden" id="orderId" name="orderId">
        <label for="orderDate">Order Date:</label>
        <input type="date" id="orderDate" name="orderDate" required>
        <label for="supplierId">Supplier ID:</label>
        <input type="number" id="supplierId" name="supplierId" required>
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" required>
        <label for="departmentId">Department ID:</label>
        <input type="number" id="departmentId" name="departmentId" required>
        <button type="submit">Save Order</button>
    </form>

    <h3>All Orders</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Order Date</th>
                <th>Supplier ID</th>
                <th>Status</th>
                <th>Department ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['orderId']; ?></td>
                    <td><?php echo $row['orderDate']; ?></td>
                    <td><?php echo $row['supplierId']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['departmentId']; ?></td>
                    <td>
                        <button onclick="editOrder('<?php echo $row['orderId']; ?>', '<?php echo $row['orderDate']; ?>', '<?php echo $row['supplierId']; ?>', '<?php echo $row['status']; ?>', '<?php echo $row['departmentId']; ?>')">Edit</button>
                        <a href="orders.php?action=delete&id=<?php echo $row['orderId']; ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editOrder(orderId, orderDate, supplierId, status, departmentId) {
    document.getElementById('orderId').value = orderId;
    document.getElementById('orderDate').value = orderDate;
    document.getElementById('supplierId').value = supplierId;
    document.getElementById('status').value = status;
    document.getElementById('departmentId').value = departmentId;
}
</script>

<?php include '../includes/footer.php'; ?>
