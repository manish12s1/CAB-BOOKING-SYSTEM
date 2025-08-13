<?php
session_start();
$loginError = "";
$signupError = "";
$signupSuccess = "";

$conn = new mysqli("localhost", "root", "", "abdukgc");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Login
if (isset($_POST["login"])) {
    $username = $_POST['username'];
    $password = hash("sha256", $_POST['password']);

    $stmt = $conn->prepare("SELECT id FROM admin_users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $_SESSION["admin"] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $loginError = "Invalid Admin Username or Password!";
    }

    $stmt->close();
}

// Handle Signup
if (isset($_POST["signup"])) {
    $username = $_POST['new_username'];
    $password = hash("sha256", $_POST['new_password']);

    $check = $conn->prepare("SELECT id FROM admin_users WHERE username=?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $signupError = "Username already taken!";
    } else {
        $insert = $conn->prepare("INSERT INTO admin_users (username, password) VALUES (?, ?)");
        $insert->bind_param("ss", $username, $password);
        if ($insert->execute()) {
            $_SESSION["admin"] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $signupError = "Signup failed!";
        }
        $insert->close();
    }

    $check->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login / Signup</title>
    <style>
        body {
            background: #f4f4f4;
            font-family: Arial;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 340px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }

        .toggle {
            margin-top: 15px;
            text-align: center;
            color: #007bff;
            cursor: pointer;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .success {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
    </style>
    <script>
        function toggleForm() {
            const login = document.getElementById("login-form");
            const signup = document.getElementById("signup-form");
            login.style.display = login.style.display === "none" ? "block" : "none";
            signup.style.display = signup.style.display === "none" ? "block" : "none";
        }
    </script>
</head>
<body>
    <div class="box">
        <!-- Login Form -->
        <form id="login-form" method="post" style="display:block;">
            <h2>Admin Login</h2>
            <input type="text" name="username" placeholder="Admin Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" name="login">Login</button>
            <div class="error"><?php echo $loginError; ?></div>
            <div class="toggle" onclick="toggleForm()">Don't have an account? Sign up</div>
        </form>

        <!-- Signup Form -->
        <form id="signup-form" method="post" style="display:none;">
            <h2>Admin Sign Up</h2>
            <input type="text" name="new_username" placeholder="New Username" required />
            <input type="password" name="new_password" placeholder="New Password" required />
            <button type="submit" name="signup">Sign Up</button>
            <div class="error"><?php echo $signupError; ?></div>
            <div class="toggle" onclick="toggleForm()">Already have an account? Login</div>
        </form>
    </div>
</body>
</html>
