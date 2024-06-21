<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/Room.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$room = new Room($conn);

// Handle add/edit room request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room->roomNumber = $_POST['roomNumber'];
    $room->departmentId = $_POST['departmentId'];
    $room->status = $_POST['status'];

    if (isset($_POST['roomId']) && !empty($_POST['roomId'])) {
        // Update existing room
        $room->roomId = $_POST['roomId'];
        if ($room->updateRoom()) {
            echo "<p>Room updated successfully!</p>";
        } else {
            echo "<p>Failed to update room.</p>";
        }
    } else {
        // Add new room
        if ($room->addRoom()) {
            echo "<p>Room added successfully!</p>";
        } else {
            echo "<p>Failed to add room.</p>";
        }
    }
}

// Handle delete room request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $room->roomId = $_GET['id'];
    if ($room->deleteRoom()) {
        echo "<p>Room deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete room.</p>";
    }
}

// Fetch all rooms
$rooms = $room->getAllRooms();
?>

<div class="container">
    <h2>Manage Rooms</h2>

    <h3>Add/Edit Room</h3>
    <form method="POST">
        <input type="hidden" id="roomId" name="roomId">
        <label for="roomNumber">Room Number:</label>
        <input type="text" id="roomNumber" name="roomNumber" required>
        <label for="departmentId">Department ID:</label>
        <input type="number" id="departmentId" name="departmentId" required>
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" required>
        <button type="submit">Save Room</button>
    </form>

    <h3>All Rooms</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Room Number</th>
                <th>Department ID</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $rooms->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['roomId']; ?></td>
                    <td><?php echo $row['roomNumber']; ?></td>
                    <td><?php echo $row['departmentId']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <button onclick="editRoom('<?php echo $row['roomId']; ?>', '<?php echo $row['roomNumber']; ?>', '<?php echo $row['departmentId']; ?>', '<?php echo $row['status']; ?>')">Edit</button>
                        <a href="rooms.php?action=delete&id=<?php echo $row['roomId']; ?>" onclick="return confirm('Are you sure you want to delete this room?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editRoom(roomId, roomNumber, departmentId, status) {
    document.getElementById('roomId').value = roomId;
    document.getElementById('roomNumber').value = roomNumber;
    document.getElementById('departmentId').value = departmentId;
    document.getElementById('status').value = status;
}
</script>

<?php include '../includes/footer.php'; ?>
