<?php
include '../includes/init.php'; // Ensure session is started
include '../includes/header.php';
include '../includes/db.php';
include '../models/Donation.php';

$donation = new Donation($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donation->amount = $_POST['amount'];
    $donation->date = date('Y-m-d');
    $donation->userId = $_SESSION['userId'];
    if ($donation->makeDonation()) {
        echo "<p>Donation made successfully!</p>";
    } else {
        echo "<p>Failed to make donation.</p>";
    }
}
?>

<div class="container">
    <h2>Make a Donation</h2>
    <form method="POST">
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" required>
        <button type="submit">Donate</button>
    </form>

    <h2>My Donations</h2>
    <ul>
        <?php
        if (isset($_SESSION['userId'])) {
            $stmt = $donation->viewDonations($_SESSION['userId']);
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<li>{$row['date']} - \${$row['amount']}</li>";
}
        } else {
            echo "<p>Please log in to view your donations.</p>";
        }
        ?>
    </ul>
</div>

<?php include '../includes/footer.php'; ?>
