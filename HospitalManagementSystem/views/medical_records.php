<?php
include '../includes/init.php'; // Ensure session is started
include '../includes/header.php';
include '../includes/db.php';
include '../models/MedicalRecord.php';

$medicalRecord = new MedicalRecord($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicalRecord->details = $_POST['details'];
    $medicalRecord->date = date('Y-m-d');
    $medicalRecord->patientId = $_POST['patientId'];
    $medicalRecord->doctorId = $_POST['doctorId'];
    if ($medicalRecord->updateRecord()) {
        echo "<p>Medical record updated successfully!</p>";
    } else {
        echo "<p>Failed to update medical record.</p>";
    }
}
?>

<div class="container">
    <h2>Update Medical Record</h2>
    <form method="POST">
        <label for="details">Details:</label>
        <textarea id="details" name="details" required></textarea>
        <label for="patientId">Patient ID:</label>
        <input type="text" id="patientId" name="patientId" required>
        <label for="doctorId">Doctor ID:</label>
        <input type="text" id="doctorId" name="doctorId" required>
        <button type="submit">Update</button>
    </form>

    <h2>View Medical Records</h2>
    <ul>
        <?php
        if (isset($_SESSION['userId'])) {
            $result = $medicalRecord->viewRecords($_SESSION['userId']);
            while ($row = $result->fetch_assoc()) {
                echo "<li>{$row['date']} - {$row['details']}</li>";
            }
        } else {
            echo "<p>Please log in to view your medical records.</p>";
        }
        ?>
    </ul>
</div>

<?php include '../includes/footer.php'; ?>
