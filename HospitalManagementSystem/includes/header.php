<!DOCTYPE html>
<html>
<head>
    <title>Hospital Management System</title>
    <link rel="stylesheet" type="text/css" href="/HospitalManagementSystem/css/style.css">
</head>
<body>
    <header>
        <h1>Hospital Management System</h1>
        <nav>
            <ul>
                <?php if (isset($_SESSION['userId'])): ?>
                    <?php if ($_SESSION['userRole'] == 1):?>
                        <li><a href="/HospitalManagementSystem/views/dashboard.php">Admin Dashboard</a></li>
                        <li><a href="/HospitalManagementSystem/views/users.php">Users</a></li>
                        <li><a href="/HospitalManagementSystem/views/roles.php">Roles</a></li>
                        <li><a href="/HospitalManagementSystem/views/patients.php">Patients</a></li>
                        <li><a href="/HospitalManagementSystem/views/doctors.php">Doctors</a></li>
                        <li><a href="/HospitalManagementSystem/views/nurses.php">Nurses</a></li>
                        <li><a href="/HospitalManagementSystem/views/departments.php">Departments</a></li>
                        <li><a href="/HospitalManagementSystem/views/rooms.php">Rooms</a></li>
                        <li><a href="/HospitalManagementSystem/views/equipment.php">Equipment</a></li>
                        <li><a href="/HospitalManagementSystem/views/orders.php">Orders</a></li>
                        <li><a href="/HospitalManagementSystem/views/suppliers.php">Suppliers</a></li>
                        <li><a href="/HospitalManagementSystem/views/invoices.php">Invoices</a></li>
                        <li><a href="/HospitalManagementSystem/views/volunteers.php">Volunteers</a></li>
                        <li><a href="/HospitalManagementSystem/views/events.php">Events</a></li>
                    <?php elseif ($_SESSION['userRole'] == 2):  ?>
                        <li><a href="/HospitalManagementSystem/views/profile.php">Profile</a></li>
                        <li><a href="/HospitalManagementSystem/views/appointments.php">Appointments</a></li>
                        <li><a href="/HospitalManagementSystem/views/donations.php">Donations</a></li>
                        <li><a href="/HospitalManagementSystem/views/medical_records.php">Medical Records</a></li>
                        <li><a href="/HospitalManagementSystem/views/prescriptions.php">Prescriptions</a></li>
                    <?php elseif ($_SESSION['userRole'] == 3 || $_SESSION['userRole'] == 4): ?>
                        <li><a href="/HospitalManagementSystem/views/appointments.php">Appointments</a></li>
                        <li><a href="/HospitalManagementSystem/views/donations.php">Donations</a></li>
                        <li><a href="/HospitalManagementSystem/views/medical_records.php">Medical Records</a></li>
                        <li><a href="/HospitalManagementSystem/views/prescriptions.php">Prescriptions</a></li>
                        <li><a href="/HospitalManagementSystem/views/patients.php">Patients</a></
                    <?php elseif ($_SESSION['userRole'] == 5):  ?>
                        <li><a href="/HospitalManagementSystem/views/appointments.php">Appointments</a></li>
                        <li><a href="/HospitalManagementSystem/views/donations.php">Donations</a></li>
                        <li><a href="/HospitalManagementSystem/views/medical_records.php">Medical Records</a></li>
                    <?php endif; ?>
                    <li><a href="/HospitalManagementSystem/views/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="/HospitalManagementSystem/views/login.php">Login</a></li>
                    <li><a href="/HospitalManagementSystem/views/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
