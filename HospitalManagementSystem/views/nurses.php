<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/Nurse.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$nurse = new Nurse($conn);

// Handle add/edit nurse request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nurse->departmentId = $_POST['departmentId'];
    $nurse->userId = $_POST['userId'];

    if (isset($_POST['nurseId']) && !empty($_POST['nurseId'])) {
        // Update existing nurse
        $nurse->nurseId = $_POST['nurseId'];
        if ($nurse->updateNurse()) {
            echo "<p>Nurse updated successfully!</p>";
        } else {
            echo "<p>Failed to update nurse.</p>";
        }
    } else {
        // Add new nurse
        if ($nurse->addNurse()) {
            echo "<p>Nurse added successfully!</p>";
        } else {
            echo "<p>Failed to add nurse.</p>";
        }
    }
}

// Handle delete nurse request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $nurse->nurseId = $_GET['id'];
    if ($nurse->deleteNurse()) {
        echo "<p>Nurse deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete nurse.</p>";
    }
}

// Fetch all nurses
$nurses = $nurse->getAllNurses();
?>

<div class="container">
    <h2>Manage Nurses</h2>

    <h3>Add/Edit Nurse</h3>
    <form method="POST">
        <input type="hidden" id="nurseId" name="nurseId">
        <label for="departmentId">Department ID:</label>
        <input type="number" id="departmentId" name="departmentId" required>
        <label for="userId">User ID:</label>
        <input type="number" id="userId" name="userId" required>
        <button type="submit">Save Nurse</button>
    </form>

    <h3>All Nurses</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Department ID</th>
                <th>User ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $nurses->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['nurseId']; ?></td>
                    <td><?php echo $row['departmentId']; ?></td>
                    <td><?php echo $row['userId']; ?></td>
                    <td>
                        <button onclick="editNurse('<?php echo $row['nurseId']; ?>', '<?php echo $row['departmentId']; ?>', '<?php echo $row['userId']; ?>')">Edit</button>
                        <a href="nurses.php?action=delete&id=<?php echo $row['nurseId']; ?>" onclick="return confirm('Are you sure you want to delete this nurse?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editNurse(nurseId, departmentId, userId) {
    document.getElementById('nurseId').value = nurseId;
    document.getElementById('departmentId').value = departmentId;
    document.getElementById('userId').value = userId;
}
</script>

<?php include '../includes/footer.php'; ?>
