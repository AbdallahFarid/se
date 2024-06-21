<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/Patient.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$patient = new Patient($conn);

// Handle add/edit patient request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient->name = $_POST['name'];
    $patient->dob = $_POST['dob'];
    $patient->gender = $_POST['gender'];
    $patient->address = $_POST['address'];
    $patient->phone = $_POST['phone'];
    $patient->medicalHistory = $_POST['medicalHistory'];
    $patient->userId = $_POST['userId'];

    if (isset($_POST['patientId']) && !empty($_POST['patientId'])) {
        // Update existing patient
        $patient->patientId = $_POST['patientId'];
        if ($patient->updatePatient()) {
            echo "<p>Patient updated successfully!</p>";
        } else {
            echo "<p>Failed to update patient.</p>";
        }
    } else {
        // Add new patient
        if ($patient->register()) {
            echo "<p>Patient added successfully!</p>";
        } else {
            echo "<p>Failed to add patient.</p>";
        }
    }
}

// Handle delete patient request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $patient->patientId = $_GET['id'];
    if ($patient->deletePatient()) {
        echo "<p>Patient deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete patient.</p>";
    }
}

// Fetch all patients
$patients = $patient->getAllPatients();
?>

<div class="container">
    <h2>Manage Patients</h2>

    <h3>Add/Edit Patient</h3>
    <form method="POST">
        <input type="hidden" id="patientId" name="patientId">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        <label for="medicalHistory">Medical History:</label>
        <textarea id="medicalHistory" name="medicalHistory" required></textarea>
        <label for="userId">User ID:</label>
        <input type="number" id="userId" name="userId" required>
        <button type="submit">Save Patient</button>
    </form>

    <h3>All Patients</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Medical History</th>
                <th>User ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $patients->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['patientId']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['dob']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['medicalHistory']; ?></td>
                    <td><?php echo $row['userId']; ?></td>
                    <td>
                        <button onclick="editPatient('<?php echo $row['patientId']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['dob']; ?>', '<?php echo $row['gender']; ?>', '<?php echo $row['address']; ?>', '<?php echo $row['phone']; ?>', '<?php echo $row['medicalHistory']; ?>', '<?php echo $row['userId']; ?>')">Edit</button>
                        <a href="patients.php?action=delete&id=<?php echo $row['patientId']; ?>" onclick="return confirm('Are you sure you want to delete this patient?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editPatient(patientId, name, dob, gender, address, phone, medicalHistory, userId) {
    document.getElementById('patientId').value = patientId;
    document.getElementById('name').value = name;
    document.getElementById('dob').value = dob;
    document.getElementById('gender').value = gender;
    document.getElementById('address').value = address;
    document.getElementById('phone').value = phone;
    document.getElementById('medicalHistory').value = medicalHistory;
    document.getElementById('userId').value = userId;
}
</script>

<?php include '../includes/footer.php'; ?>
