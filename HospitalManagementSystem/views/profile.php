<?php
include '../includes/header.php';
include '../includes/db.php';
include '../models/User.php';
include '../includes/init.php';
$user = new User($conn);

if (isset($_SESSION['userId'])) {
    $user->userId = $_SESSION['userId'];
    $user->getUserDetails();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];

        if ($user->updateProfile()) {
            echo "<p>Profile updated successfully!</p>";
        } else {
            echo "<p>Failed to update profile.</p>";
        }
    }
} else {
    echo "<p>User not logged in. Please log in to view and update your profile.</p>";
}
?>

<div class="container">
    <h2>My Profile</h2>
    <?php if (isset($_SESSION['userId'])): ?>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($user->name) ? $user->name : ''; ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($user->email) ? $user->email : ''; ?>" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo isset($user->password) ? $user->password : ''; ?>" required>
            <button type="submit">Update Profile</button>
        </form>
    <?php else: ?>
        <p>Please log in to view and update your profile.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
