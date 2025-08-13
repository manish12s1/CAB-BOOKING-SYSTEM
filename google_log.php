<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $data = json_decode(file_get_contents("php://input"));

  $email = $data->email ?? null;
  $name = $data->name ?? null;

  if ($email) {
    $conn = new mysqli("localhost", "root", "", "abdukgc");

    if ($conn->connect_error) {
      http_response_code(500);
      echo "Database connection failed.";
      exit();
    }

    $stmt = $conn->prepare("SELECT id FROM users_log WHERE username=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
      // New Google user
      $stmt = $conn->prepare("INSERT INTO users_log (username, password) VALUES (?, '')");
      $stmt->bind_param("s", $email);
      $stmt->execute();
    }

    $_SESSION["username"] = $email;
    header("Location: index.php");
    exit();
  } else {
    http_response_code(400);
    echo "Invalid Google data.";
  }
}
?>
