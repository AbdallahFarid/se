<?php
include '../includes/init.php'; // Ensure session is started
include '../includes/header.php';
include '../includes/db.php';
include '../models/Appointment.php';

$appointment = new Appointment($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment->appointmentDate = $_POST['appointmentDate'];
    $appointment->patientId = $_POST['patientId'];
    $appointment->doctorId = $_POST['doctorId'];
    $appointment->nurseId = $_POST['nurseId'];
    $appointment->status = $_POST['status'];
    if ($appointment->bookAppointment()) {
        echo "<p>Appointment booked successfully!</p>";
    } else {
        echo "<p>Failed to book appointment.</p>";
    }
}
?>

<div class="container">
    <h2>Book Appointment</h2>
    <form method="POST">
        <label for="appointmentDate">Appointment Date:</label>
        <input type="date" id="appointmentDate" name="appointmentDate" required>
        <label for="patientId">Patient ID:</label>
        <input type="text" id="patientId" name="patientId" required>
        <label for="doctorId">Doctor ID:</label>
        <input type="text" id="doctorId" name="doctorId" required>
        <label for="nurseId">Nurse ID:</label>
        <input type="text" id="nurseId" name="nurseId">
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" required>
        <button type="submit">Book</button>
    </form>

    <h2>My Appointments</h2>
    <ul>
        <?php
        if (isset($_SESSION['userId'])) {
            $stmt = $appointment->viewAppointments($_SESSION['userId']);
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<li>{$row['appointmentDate']} - {$row['status']}</li>";

            }
        } else {
            echo "<p>Please log in to view your appointments.</p>";
        }
        ?>
    </ul>
</div>

<?php include '../includes/footer.php'; ?>
