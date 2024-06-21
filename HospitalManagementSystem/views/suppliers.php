<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/Supplier.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$supplier = new Supplier($conn);

// Handle add/edit supplier request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supplier->name = $_POST['name'];
    $supplier->contact = $_POST['contact'];
    $supplier->address = $_POST['address'];

    if (isset($_POST['supplierId']) && !empty($_POST['supplierId'])) {
        // Update existing supplier
        $supplier->supplierId = $_POST['supplierId'];
        if ($supplier->updateSupplier()) {
            echo "<p>Supplier updated successfully!</p>";
        } else {
            echo "<p>Failed to update supplier.</p>";
        }
    } else {
        // Add new supplier
        if ($supplier->addSupplier()) {
            echo "<p>Supplier added successfully!</p>";
        } else {
            echo "<p>Failed to add supplier.</p>";
        }
    }
}

// Handle delete supplier request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $supplier->supplierId = $_GET['id'];
    if ($supplier->deleteSupplier()) {
        echo "<p>Supplier deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete supplier.</p>";
    }
}

// Fetch all suppliers
$suppliers = $supplier->getAllSuppliers();
?>

<div class="container">
    <h2>Manage Suppliers</h2>

    <h3>Add/Edit Supplier</h3>
    <form method="POST">
        <input type="hidden" id="supplierId" name="supplierId">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" required>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
        <button type="submit">Save Supplier</button>
    </form>

    <h3>All Suppliers</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $suppliers->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['supplierId']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td>
                        <button onclick="editSupplier('<?php echo $row['supplierId']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['contact']; ?>', '<?php echo $row['address']; ?>')">Edit</button>
                        <a href="suppliers.php?action=delete&id=<?php echo $row['supplierId']; ?>" onclick="return confirm('Are you sure you want to delete this supplier?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editSupplier(supplierId, name, contact, address) {
    document.getElementById('supplierId').value = supplierId;
    document.getElementById('name').value = name;
    document.getElementById('contact').value = contact;
    document.getElementById('address').value = address;
}
</script>

<?php include '../includes/footer.php'; ?>
