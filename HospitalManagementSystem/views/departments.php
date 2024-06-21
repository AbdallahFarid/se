<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/Department.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$department = new Department($conn);

// Handle add/edit department request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department->name = $_POST['name'];
    $department->description = $_POST['description'];
    $department->headId = $_POST['headId'];

    if (isset($_POST['departmentId']) && !empty($_POST['departmentId'])) {
        // Update existing department
        $department->departmentId = $_POST['departmentId'];
        if ($department->updateDepartment()) {
            echo "<p>Department updated successfully!</p>";
        } else {
            echo "<p>Failed to update department.</p>";
        }
    } else {
        // Add new department
        if ($department->addDepartment()) {
            echo "<p>Department added successfully!</p>";
        } else {
            echo "<p>Failed to add department.</p>";
        }
    }
}

// Handle delete department request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $department->departmentId = $_GET['id'];
    if ($department->deleteDepartment()) {
        echo "<p>Department deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete department.</p>";
    }
}

// Fetch all departments
$departments = $department->getAllDepartments();
?>

<div class="container">
    <h2>Manage Departments</h2>

    <h3>Add/Edit Department</h3>
    <form method="POST">
        <input type="hidden" id="departmentId" name="departmentId">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required>
        <label for="headId">Head ID:</label>
        <input type="number" id="headId" name="headId" required>
        <button type="submit">Save Department</button>
    </form>

    <h3>All Departments</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Head ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $departments->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['departmentId']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['headId']; ?></td>
                    <td>
                        <button onclick="editDepartment('<?php echo $row['departmentId']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['description']; ?>', '<?php echo $row['headId']; ?>')">Edit</button>
                        <a href="departments.php?action=delete&id=<?php echo $row['departmentId']; ?>" onclick="return confirm('Are you sure you want to delete this department?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editDepartment(departmentId, name, description, headId) {
    document.getElementById('departmentId').value = departmentId;
    document.getElementById('name').value = name;
    document.getElementById('description').value = description;
    document.getElementById('headId').value = headId;
}
</script>

<?php include '../includes/footer.php'; ?>
