<?php
include_once '../models/Room.php';
include_once '../includes/db.php';

class RoomController {
    private $conn;
    private $room;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->room = new Room($this->conn);
    }

    public function assignRoom() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->room->roomNumber = $_POST['roomNumber'];
            $this->room->departmentId = $_POST['departmentId'];
            $this->room->status = $_POST['status'];
            if ($this->room->assignRoom()) {
                echo "Room assigned successfully!";
            } else {
                echo "Failed to assign room.";
            }
        }
    }

    public function updateRoomStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->room->roomNumber = $_POST['roomNumber'];
            $this->room->departmentId = $_POST['departmentId'];
            $this->room->status = $_POST['status'];
            if ($this->room->updateRoomStatus()) {
                echo "Room status updated successfully!";
            } else {
                echo "Failed to update room status.";
            }
        }
    }
}
?>
