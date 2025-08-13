<?php
// payment_admin.php

// Database connection settings
define("MYSQL_SERVER", "localhost");
define("MYSQL_USER", "root"); // Empty username
define("MYSQL_PASSWORD", ""); // Empty password
define("MYSQL_DATABASE", "abdukgc");

// Create a connection to the database
$mysqli = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD) 
    or die('I cannot connect to the database because 1: ' . $mysqli->error);

$mysqli->select_db(MYSQL_DATABASE) 
    or die('I cannot connect to the database because 2: ' . $mysqli->error);

// Query to fetch payment records
$query = "SELECT * FROM payments ORDER BY created_at DESC";
$result = $mysqli->query($query); // Use the $mysqli object to run the query
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Payment Records</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 40px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .table th, .table td {
            text-align: center;
        }
        .badge {
            font-size: 14px;
        }
        .bg-success {
            background-color: #28a745 !important;
        }
        .bg-warning {
            background-color: #ffc107 !important;
        }
        .bg-danger {
            background-color: #dc3545 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Payment Records</h2>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Payment Mode</th>
                        <th>Amount (₹)</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are payment records
                    if(mysqli_num_rows($result) > 0){
                        // Loop through each payment record and display it
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['customer_name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['payment_mode']}</td>
                                <td>{$row['amount']}</td>
                                <td><span class='badge ".($row['status'] == 'Received' ? 'bg-success' : ($row['status'] == 'Pending' ? 'bg-warning' : 'bg-danger'))."'>".$row['status']."</span></td>
                                <td>{$row['created_at']}</td>
                            </tr>";
                        }
                    } else {
                        // If no records found, display a message
                        echo "<tr><td colspan='7'>No payments found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add JavaScript files -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
