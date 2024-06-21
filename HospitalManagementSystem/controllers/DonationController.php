<?php
include_once '../models/Donation.php';
include_once '../includes/db.php';

class DonationController {
    private $conn;
    private $donation;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->donation = new Donation($this->conn);
    }

    public function makeDonation() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->donation->amount = $_POST['amount'];
            $this->donation->date = date('Y-m-d');
            $this->donation->userId = $_SESSION['userId'];
            if ($this->donation->makeDonation()) {
                echo "Donation made successfully!";
            } else {
                echo "Failed to make donation.";
            }
        }
    }

    public function viewDonations() {
        $result = $this->donation->viewDonations($_SESSION['userId']);
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['date']} - \${$row['amount']}</li>";
        }
    }
}
?>
