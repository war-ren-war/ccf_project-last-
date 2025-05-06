<?php 
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ccf_users2";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usernameOrEmail']) && isset($_POST['password'])) {
    $input = trim($_POST['usernameOrEmail']);
    $passwordInput = $_POST['password'];

    // Prepare and execute query using username or email
    $stmt = $conn->prepare("SELECT id, password, first_name, nickname FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($passwordInput, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['nickname'] = $user['nickname'];

            echo "<p style='color:green;'>✅ Login successful! Redirecting to dashboard...</p>";
            header("Refresh: 2; URL=dashboard.html");
            exit();
        } else {
            echo "<p style='color:red;'>❌ Invalid password.</p>";
        }
    } else {
        echo "<p style='color:red;'>❌ Username or Email not found.</p>";
    }

    $stmt->close();
}

$conn->close();
?>
