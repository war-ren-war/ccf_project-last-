<?php
$host = "localhost";
$dbname = "ccf_users2";   // Replace with your actual DB name
$username = "root";     // Your MySQL username
$password = "";          // Your password (if any)

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Example query: fetch user info
$sql = "SELECT full_name, email FROM users WHERE username = 'warren'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
  $user = $result->fetch_assoc();
  echo json_encode($user); // Returns JSON
} else {
  echo json_encode(["error" => "User not found"]);
}

$conn->close();
?>
