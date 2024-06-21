<?php
include '../includes/header.php';
include '../includes/db.php';
include '../models/User.php';

$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->name = $_POST['name'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->roleId = $_POST['roleId'];

    if ($user->register()) {
        echo "<p>Registration successful!</p>";
    } else {
        echo "<p>Failed to register.</p>";
    }
}
?>

<div class="container">
    <h2>Register</h2>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="roleId">Role:</label>
        <select id="roleId" name="roleId">
            <option value="1">Admin</option>
            <option value="2">Doctor</option>
            <option value="3">Nurse</option>
            <option value="4">Patient</option>
        </select>
        <button type="submit">Register</button>
    </form>
</div>

<?php
include '../includes/footer.php';
?>
