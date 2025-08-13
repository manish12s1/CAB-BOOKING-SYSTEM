<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "abdukgc";

$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $mysqli->query("DELETE FROM booking WHERE id = $id");
    header("Location: admin-bookings.php");
    exit();
}

// Handle date filter
$filter_date = $_GET['filter_date'] ?? '';
$bookings_query = "SELECT * FROM booking";
if (!empty($filter_date)) {
    $safe_date = $mysqli->real_escape_string($filter_date);
    $bookings_query .= " WHERE pick_date = '$safe_date'";
}
$bookings_query .= " ORDER BY id DESC";
$result = $mysqli->query($bookings_query);

// Fetch distinct cars (optional - if you track cars in your DB)
$cars_result = $mysqli->query("SELECT DISTINCT cab_type FROM booking");
$booked_cars_today = [];
if (!empty($filter_date)) {
    $car_check = $mysqli->query("SELECT cab_type FROM booking WHERE pick_date = '$safe_date'");
    while ($row = $car_check->fetch_assoc()) {
        $booked_cars_today[] = $row['cab_type'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Bookings</title>
    <style>
        body { font-family: Arial; padding: 20px; background-color: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        th { background-color: #eee; }
        .delete { color: red; text-decoration: none; }
        .delete:hover { text-decoration: underline; }
        .filter-form { margin-bottom: 20px; }
    </style>
</head>
<body>

<h2>Bookings List</h2>

<!-- Filter Form -->
<form method="get" class="filter-form">
    <label for="filter_date">Filter by Date:</label>
    <input type="date" name="filter_date" id="filter_date" value="<?= htmlspecialchars($filter_date) ?>">
    <button type="submit">Filter</button>
    <a href="admin-bookings.php">Reset</a>
</form>

<?php if (!empty($filter_date)): ?>
    <h3>Available Cars on <?= htmlspecialchars($filter_date) ?>:</h3>
    <ul>
        <?php
        $all_cars = ['Sedan', 'SUV', 'Hatchback']; // Example types, update to match your data
        $available = array_diff($all_cars, $booked_cars_today);
        foreach ($available as $car) {
            echo "<li>$car</li>";
        }
        if (empty($available)) echo "<li>No cars available.</li>";
        ?>
    </ul>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Pickup City</th>
            <th>Drop City</th>
            <th>Cab Type</th>
            <th>Pick Date</th>
            <th>Fare</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['mobile_number']) ?></td>
                    <td><?= htmlspecialchars($row['pick_city']) ?></td>
                    <td><?= htmlspecialchars($row['drop_city']) ?></td>
                    <td><?= htmlspecialchars($row['cab_type']) ?></td>
                    <td><?= htmlspecialchars($row['pick_date']) ?></td>
                    <td><?= htmlspecialchars($row['cab_rate']) ?></td>
                    <td><?= htmlspecialchars($row['time_now']) ?></td>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" class="delete" onclick="return confirm('Delete this booking?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="11">No bookings found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
