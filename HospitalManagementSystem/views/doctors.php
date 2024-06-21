<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/Doctor.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$doctor = new Doctor($conn);

// Handle add/edit doctor request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor->specialization = $_POST['specialization'];
    $doctor->departmentId = $_POST['departmentId'];
    $doctor->userId = $_POST['userId'];

    if (isset($_POST['doctorId']) && !empty($_POST['doctorId'])) {
        // Update existing doctor
        $doctor->doctorId = $_POST['doctorId'];
        if ($doctor->updateDoctor()) {
            echo "<p>Doctor updated successfully!</p>";
        } else {
            echo "<p>Failed to update doctor.</p>";
        }
    } else {
        // Add new doctor
        if ($doctor->addDoctor()) {
            echo "<p>Doctor added successfully!</p>";
        } else {
            echo "<p>Failed to add doctor.</p>";
        }
    }
}

// Handle delete doctor request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $doctor->doctorId = $_GET['id'];
    if ($doctor->deleteDoctor()) {
        echo "<p>Doctor deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete doctor.</p>";
    }
}

// Fetch all doctors
$doctors = $doctor->getAllDoctors();
?>

<div class="container">
    <h2>Manage Doctors</h2>

    <h3>Add/Edit Doctor</h3>
    <form method="POST">
        <input type="hidden" id="doctorId" name="doctorId">
        <label for="specialization">Specialization:</label>
        <input type="text" id="specialization" name="specialization" required>
        <label for="departmentId">Department ID:</label>
        <input type="number" id="departmentId" name="departmentId" required>
        <label for="userId">User ID:</label>
        <input type="number" id="userId" name="userId" required>
        <button type="submit">Save Doctor</button>
    </form>

    <h3>All Doctors</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Specialization</th>
                <th>Department ID</th>
                <th>User ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $doctors->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['doctorId']; ?></td>
                    <td><?php echo $row['specialization']; ?></td>
                    <td><?php echo $row['departmentId']; ?></td>
                    <td><?php echo $row['userId']; ?></td>
                    <td>
                        <button onclick="editDoctor('<?php echo $row['doctorId']; ?>', '<?php echo $row['specialization']; ?>', '<?php echo $row['departmentId']; ?>', '<?php echo $row['userId']; ?>')">Edit</button>
                        <a href="doctors.php?action=delete&id=<?php echo $row['doctorId']; ?>" onclick="return confirm('Are you sure you want to delete this doctor?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editDoctor(doctorId, specialization, departmentId, userId) {
    document.getElementById('doctorId').value = doctorId;
    document.getElementById('specialization').value = specialization;
    document.getElementById('departmentId').value = departmentId;
    document.getElementById('userId').value = userId;
}
</script>

<?php include '../includes/footer.php'; ?>
