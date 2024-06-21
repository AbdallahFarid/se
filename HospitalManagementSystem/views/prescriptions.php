<?php
include '../includes/init.php'; // Ensure session is started
include '../includes/header.php';
include '../includes/db.php';
include '../models/Prescription.php';

$prescription = new Prescription($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prescription->medication = $_POST['medication'];
    $prescription->dosage = $_POST['dosage'];
    $prescription->duration = $_POST['duration'];
    $prescription->patientId = $_POST['patientId'];
    $prescription->doctorId = $_POST['doctorId'];

    if ($prescription->issuePrescription()) {
        echo "<p>Prescription issued successfully!</p>";
    } else {
        echo "<p>Failed to issue prescription.</p>";
    }
}
?>

<div class="container">
    <h2>Issue Prescription</h2>
    <form method="POST">
        <label for="medication">Medication:</label>
        <input type="text" id="medication" name="medication" required>
        <label for="dosage">Dosage:</label>
        <input type="text" id="dosage" name="dosage" required>
        <label for="duration">Duration:</label>
        <input type="text" id="duration" name="duration" required>
        <label for="patientId">Patient ID:</label>
        <input type="text" id="patientId" name="patientId" required>
        <label for="doctorId">Doctor ID:</label>
        <input type="text" id="doctorId" name="doctorId" required>
        <button type="submit">Issue</button>
    </form>

    <h2>My Prescriptions</h2>
    <ul>
        <?php
        $stmt = $prescription->viewPrescriptions($_SESSION['userId']);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['medication']} - {$row['dosage']} - {$row['duration']}</li>";
        }
        ?>
    </ul>
</div>

<?php
include '../includes/footer.php';
?>
