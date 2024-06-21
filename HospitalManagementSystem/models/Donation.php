<?php
class Donation {
    private $conn;
    private $table = 'Donation';

    public $donationId;
    public $amount;
    public $date;
    public $userId;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function makeDonation() {
        $query = "INSERT INTO " . $this->table . " SET amount=?, date=?, userId=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('dsi', $this->amount, $this->date, $this->userId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function viewDonations($userId) {
        $query = "SELECT * FROM " . $this->table . " WHERE userId = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt;
    }
}
?>
