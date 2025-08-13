<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .dashboard {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            text-align: center;
            width: 400px;
        }

        h2 {
            margin-bottom: 30px;
        }

        .btn {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            text-decoration: none;
        }

        .btn:hover {
            background: #0056b3;
        }

        .logout {
            background: #dc3545;
        }

        .logout:hover {
            background: #b02a37;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, Admin</h2>
        <a href="admin-bookings.php" class="btn">Manage Bookings</a>
        <a href="delete-booking.php" class="btn">Delete Booking</a>
        <a href="payment_admin.php" class="btn">Payments</a>
        <a href="logout.php" class="btn logout">Logout</a>
    </div>
</body>
</html>
