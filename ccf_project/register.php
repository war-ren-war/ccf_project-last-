<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ccf_users2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize POST data
$nickname = $_POST['nickname'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Password Hashing
$first_name = $_POST['firstName'];
$last_name = $_POST['lastName'];
$username = $_POST['username'];
$email = $_POST['email'];

$mobile_number = $_POST['mobileNumber'];
$birth_month = $_POST['birthMonth'];
$birth_year = $_POST['birthYear'];
$gender = $_POST['gender'];
$life_stage = $_POST['lifeStage'];
$country = $_POST['country'];
$region = $_POST['region'];
$city = $_POST['city'];
$glc_id = $_POST['glcId'];
$occupation = $_POST['occupation'];
$industry = $_POST['industry'];
$purpose = $_POST['purpose'];
$ccf_satellite = $_POST['ccfSatellite'];
$place_of_worship = $_POST['placeOfWorship'];
$worship_day = $_POST['worshipDay'];
$worship_time = $_POST['worshipTime'];
$registered_since = $_POST['registeredSince'];
$area_pastor = $_POST['areaPastor'];

// Prepare SQL statement
$stmt = $conn->prepare("
    INSERT INTO users (
        nickname, password, first_name, last_name, username, email,
        mobile_number, birth_month, birth_year, gender, life_stage,
        country, region, city, glc_id, occupation, industry, purpose,
        ccf_satellite, place_of_worship, worship_day, worship_time,
        registered_since, area_pastor
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

// Bind parameters
$stmt->bind_param(
    "sssssssssissssssssssssss",
    $nickname, $password, $first_name, $last_name, $username, $email,
    $mobile_number, $birth_month, $birth_year, $gender, $life_stage,
    $country, $region, $city, $glc_id, $occupation, $industry, $purpose,
    $ccf_satellite, $place_of_worship, $worship_day, $worship_time,
    $registered_since, $area_pastor
);

// Execute the statement and handle result
if ($stmt->execute()) {
    header("Location: dashboard.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
