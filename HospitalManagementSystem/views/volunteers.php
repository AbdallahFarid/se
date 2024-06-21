<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/Volunteer.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$volunteer = new Volunteer($conn);

// Handle add/edit volunteer request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $volunteer->name = $_POST['name'];
    $volunteer->contact = $_POST['contact'];
    $volunteer->email = $_POST['email'];

    if (isset($_POST['volunteerId']) && !empty($_POST['volunteerId'])) {
        // Update existing volunteer
        $volunteer->volunteerId = $_POST['volunteerId'];
        if ($volunteer->updateVolunteer()) {
            echo "<p>Volunteer updated successfully!</p>";
        } else {
            echo "<p>Failed to update volunteer.</p>";
        }
    } else {
        // Add new volunteer
        if ($volunteer->addVolunteer()) {
            echo "<p>Volunteer added successfully!</p>";
        } else {
            echo "<p>Failed to add volunteer.</p>";
        }
    }
}

// Handle delete volunteer request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $volunteer->volunteerId = $_GET['id'];
    if ($volunteer->deleteVolunteer()) {
        echo "<p>Volunteer deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete volunteer.</p>";
    }
}

// Fetch all volunteers
$volunteers = $volunteer->getAllVolunteers();
?>

<div class="container">
    <h2>Manage Volunteers</h2>

    <h3>Add/Edit Volunteer</h3>
    <form method="POST">
        <input type="hidden" id="volunteerId" name="volunteerId">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Save Volunteer</button>
    </form>

    <h3>All Volunteers</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $volunteers->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['volunteerId']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <button onclick="editVolunteer('<?php echo $row['volunteerId']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['contact']; ?>', '<?php echo $row['email']; ?>')">Edit</button>
                        <a href="volunteers.php?action=delete&id=<?php echo $row['volunteerId']; ?>" onclick="return confirm('Are you sure you want to delete this volunteer?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editVolunteer(volunteerId, name, contact, email) {
    document.getElementById('volunteerId').value = volunteerId;
    document.getElementById('name').value = name;
    document.getElementById('contact').value = contact;
    document.getElementById('email').value = email;
}
</script>

<?php include '../includes/footer.php'; ?>
