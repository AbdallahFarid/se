<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/User.php';

$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    if ($user->login()) {
        $_SESSION['userId'] = $user->userId;
        $_SESSION['userName'] = $user->name;
        $_SESSION['userRole'] = $user->roleId;

        if ($user->roleId == 1) { // Assuming roleId 1 is Admin
            header("Location: ../views/dashboard.php");
        } else {
            header("Location: ../views/profile.php");
        }
        exit();
    } else {
        echo "<p>Failed to login.</p>";
    }
}
?>

<div class="container">
    <h2>Login</h2>
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
