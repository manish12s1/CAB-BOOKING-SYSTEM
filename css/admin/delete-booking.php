<?php
  $host = "localhost";
 $user = "root";
 $password = "";
 $database = "abdukgc"; // replace this
 
 $mysqli = new mysqli($host, $user, $password, $database);
 
 if ($mysqli->connect_error) {
     die("Connection failed: " . $mysqli->connect_error);
 }
;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $mysqli->prepare("DELETE FROM booking WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
header("Location: admin-bookings.php");
?>
