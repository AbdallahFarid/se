<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/Equipment.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$equipment = new Equipment($conn);

// Handle add/edit equipment request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $equipment->name = $_POST['name'];
    $equipment->departmentId = $_POST['departmentId'];
    $equipment->roomId = $_POST['roomId'];
    $equipment->status = $_POST['status'];

    if (isset($_POST['equipmentId']) && !empty($_POST['equipmentId'])) {
        // Update existing equipment
        $equipment->equipmentId = $_POST['equipmentId'];
        if ($equipment->updateEquipment()) {
            echo "<p>Equipment updated successfully!</p>";
        } else {
            echo "<p>Failed to update equipment.</p>";
        }
    } else {
        // Add new equipment
        if ($equipment->addEquipment()) {
            echo "<p>Equipment added successfully!</p>";
        } else {
            echo "<p>Failed to add equipment.</p>";
        }
    }
}

// Handle delete equipment request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $equipment->equipmentId = $_GET['id'];
    if ($equipment->deleteEquipment()) {
        echo "<p>Equipment deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete equipment.</p>";
    }
}

// Fetch all equipment
$equipments = $equipment->getAllEquipment();
?>

<div class="container">
    <h2>Manage Equipment</h2>

    <h3>Add/Edit Equipment</h3>
    <form method="POST">
        <input type="hidden" id="equipmentId" name="equipmentId">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="departmentId">Department ID:</label>
        <input type="number" id="departmentId" name="departmentId" required>
        <label for="roomId">Room ID:</label>
        <input type="number" id="roomId" name="roomId" required>
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" required>
        <button type="submit">Save Equipment</button>
    </form>

    <h3>All Equipment</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department ID</th>
                <th>Room ID</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $equipments->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['equipmentId']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['departmentId']; ?></td>
                    <td><?php echo $row['roomId']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <button onclick="editEquipment('<?php echo $row['equipmentId']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['departmentId']; ?>', '<?php echo $row['roomId']; ?>', '<?php echo $row['status']; ?>')">Edit</button>
                        <a href="equipment.php?action=delete&id=<?php echo $row['equipmentId']; ?>" onclick="return confirm('Are you sure you want to delete this equipment?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editEquipment(equipmentId, name, departmentId, roomId, status) {
    document.getElementById('equipmentId').value = equipmentId;
    document.getElementById('name').value = name;
    document.getElementById('departmentId').value = departmentId;
    document.getElementById('roomId').value = roomId;
    document.getElementById('status').value = status;
}
</script>

<?php include '../includes/footer.php'; ?>
