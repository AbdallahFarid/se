<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/User.php';
include '../models/Role.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$user = new User($conn);
$role = new Role($conn);

// Handle add/edit user request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->name = $_POST['name'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->roleId = $_POST['roleId'];

    if (isset($_POST['userId']) && !empty($_POST['userId'])) {
        // Update existing user
        $user->userId = $_POST['userId'];
        if ($user->updateUser()) {
            echo "<p>User updated successfully!</p>";
        } else {
            echo "<p>Failed to update user.</p>";
        }
    } else {
        // Add new user
        if ($user->register()) {
            echo "<p>User added successfully!</p>";
        } else {
            echo "<p>Failed to add user.</p>";
        }
    }
}

// Handle delete user request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $user->userId = $_GET['id'];
    if ($user->deleteUser()) {
        echo "<p>User deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete user.</p>";
    }
}

// Fetch all users
$users = $user->getAllUsers();
?>

<div class="container">
    <h2>Manage Users</h2>

    <h3>Add/Edit User</h3>
    <form method="POST">
        <input type="hidden" id="userId" name="userId">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="roleId">Role:</label>
        <select id="roleId" name="roleId" required>
            <option value="" disabled selected>Select Role</option>
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo "Role $i"; ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit">Save User</button>
    </form>

    <h3>All Users</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $users->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['userId']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['roleId']; ?></td>
                    <td>
                        <button onclick="editUser('<?php echo $row['userId']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['email']; ?>', '<?php echo $row['roleId']; ?>')">Edit</button>
                        <a href="users.php?action=delete&id=<?php echo $row['userId']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editUser(userId, name, email, roleId) {
    document.getElementById('userId').value = userId;
    document.getElementById('name').value = name;
    document.getElementById('email').value = email;
    document.getElementById('roleId').value = roleId;
}
</script>

<?php include '../includes/footer.php'; ?>
