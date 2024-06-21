<?php
include '../includes/init.php'; 
include '../includes/header.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}
?>

<div class="container">
    <h2>Admin Dashboard</h2>
    <p>Welcome, <?php echo $_SESSION['userName']; ?>. Here you can manage the hospital system.</p>
    <ul>
        <li><a href="users.php">Manage Users</a></li>
        <li><a href="roles.php">Manage Roles</a></li>
        <li><a href="patients.php">Manage Patients</a></li>
        <li><a href="doctors.php">Manage Doctors</a></li>
        <li><a href="nurses.php">Manage Nurses</a></li>
        <li><a href="departments.php">Manage Departments</a></li>
        <li><a href="rooms.php">Manage Rooms</a></li>
        <li><a href="equipment.php">Manage Equipment</a></li>
        <li><a href="orders.php">Manage Orders</a></li>
        <li><a href="suppliers.php">Manage Suppliers</a></li>
        <li><a href="invoices.php">Manage Invoices</a></li>
        <li><a href="volunteers.php">Manage Volunteers</a></li>
        <li><a href="events.php">Manage Events</a></li>
    </ul>
</div>

<?php include '../includes/footer.php'; ?>
