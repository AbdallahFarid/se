<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/Role.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$role = new Role($conn);

// Handle add/edit role request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role->roleName = $_POST['roleName'];
    $role->description = $_POST['description'];

    if (isset($_POST['roleId']) && !empty($_POST['roleId'])) {
        // Update existing role
        $role->roleId = $_POST['roleId'];
        if ($role->updateRole()) {
            echo "<p>Role updated successfully!</p>";
        } else {
            echo "<p>Failed to update role.</p>";
        }
    } else {
        // Add new role
        if ($role->addRole()) {
            echo "<p>Role added successfully!</p>";
        } else {
            echo "<p>Failed to add role.</p>";
        }
    }
}

// Handle delete role request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $role->roleId = $_GET['id'];
    if ($role->deleteRole()) {
        echo "<p>Role deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete role.</p>";
    }
}

// Fetch all roles
$roles = $role->getAllRoles();
?>

<div class="container">
    <h2>Manage Roles</h2>

    <h3>Add/Edit Role</h3>
    <form method="POST">
        <input type="hidden" id="roleId" name="roleId">
        <label for="roleName">Role Name:</label>
        <input type="text" id="roleName" name="roleName" required>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required>
        <button type="submit">Save Role</button>
    </form>

    <h3>All Roles</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Role Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $roles->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['roleId']; ?></td>
                    <td><?php echo $row['roleName']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                        <button onclick="editRole('<?php echo $row['roleId']; ?>', '<?php echo $row['roleName']; ?>', '<?php echo $row['description']; ?>')">Edit</button>
                        <a href="roles.php?action=delete&id=<?php echo $row['roleId']; ?>" onclick="return confirm('Are you sure you want to delete this role?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editRole(roleId, roleName, description) {
    document.getElementById('roleId').value = roleId;
    document.getElementById('roleName').value = roleName;
    document.getElementById('description').value = description;
}
</script>

<?php include '../includes/footer.php'; ?>
