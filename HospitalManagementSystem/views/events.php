<?php
include '../includes/init.php'; 
include '../includes/header.php';
include '../includes/db.php';
include '../models/Event.php';

if (!isset($_SESSION['userId']) || $_SESSION['userRole'] != 1) {
    header("Location: ../views/login.php");
    exit();
}

$event = new Event($conn);

// Handle add/edit event request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event->name = $_POST['name'];
    $event->date = $_POST['date'];
    $event->description = $_POST['description'];

    if (isset($_POST['eventId']) && !empty($_POST['eventId'])) {
        // Update existing event
        $event->eventId = $_POST['eventId'];
        if ($event->updateEvent()) {
            echo "<p>Event updated successfully!</p>";
        } else {
            echo "<p>Failed to update event.</p>";
        }
    } else {
        // Add new event
        if ($event->organizeEvent()) {
            echo "<p>Event added successfully!</p>";
        } else {
            echo "<p>Failed to add event.</p>";
        }
    }
}

// Handle delete event request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $event->eventId = $_GET['id'];
    if ($event->deleteEvent()) {
        echo "<p>Event deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete event.</p>";
    }
}

// Fetch all events
$events = $event->getAllEvents();
?>

<div class="container">
    <h2>Manage Events</h2>

    <h3>Add/Edit Event</h3>
    <form method="POST">
        <input type="hidden" id="eventId" name="eventId">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <button type="submit">Save Event</button>
    </form>

    <h3>All Events</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $events->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['eventId']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                        <button onclick="editEvent('<?php echo $row['eventId']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['date']; ?>', '<?php echo $row['description']; ?>')">Edit</button>
                        <a href="events.php?action=delete&id=<?php echo $row['eventId']; ?>" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function editEvent(eventId, name, date, description) {
    document.getElementById('eventId').value = eventId;
    document.getElementById('name').value = name;
    document.getElementById('date').value = date;
    document.getElementById('description').value = description;
}
</script>

<?php include '../includes/footer.php'; ?>
