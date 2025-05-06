<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ccf_users2";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nickname = $_POST['nickname'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
$first_name = $_POST['firstName'];
$last_name = $_POST['lastName'];
$username = $_POST['username'];
$email = $_POST['email'];

if (empty($nickname) || empty($password) || empty($first_name) || empty($last_name) || empty($username) || empty($email)) {
    die("Error: All required fields must be filled.");
}

$mobile_number = !empty($_POST['mobileNumber']) ? $_POST['mobileNumber'] : null;
$birth_month = !empty($_POST['birthMonth']) ? $_POST['birthMonth'] : null;
$birth_year = !empty($_POST['birthYear']) ? $_POST['birthYear'] : null;
$gender = !empty($_POST['gender']) ? $_POST['gender'] : null;
$life_stage = !empty($_POST['lifeStage']) ? $_POST['lifeStage'] : null;
$country = !empty($_POST['country']) ? $_POST['country'] : null;
$region = !empty($_POST['region']) ? $_POST['region'] : null;
$city = !empty($_POST['city']) ? $_POST['city'] : null;
$glc_id = !empty($_POST['glcId']) ? $_POST['glcId'] : null;
$occupation = !empty($_POST['occupation']) ? $_POST['occupation'] : null;
$industry = !empty($_POST['industry']) ? $_POST['industry'] : null;
$purpose = !empty($_POST['purpose']) ? $_POST['purpose'] : null;
$ccf_satellite = !empty($_POST['ccfSatellite']) ? $_POST['ccfSatellite'] : null;
$place_of_worship = !empty($_POST['placeOfWorship']) ? $_POST['placeOfWorship'] : null;
$worship_day = !empty($_POST['worshipDay']) ? $_POST['worshipDay'] : null;
$worship_time = !empty($_POST['worshipTime']) ? $_POST['worshipTime'] : null;
$registered_since = !empty($_POST['registeredSince']) ? $_POST['registeredSince'] : null;
$area_pastor = !empty($_POST['areaPastor']) ? $_POST['areaPastor'] : null;


$stmt = $conn->prepare(

    "INSERT INTO users (
        nickname, password, first_name, last_name, username, email,
        mobile_number, birth_month, birth_year, gender, life_stage,
        country, region, city, glc_id, occupation, industry, purpose,
        ccf_satellite, place_of_worship, worship_day, worship_time,
        registered_since, area_pastor
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sssssssssissssssssssssss",
    $nickname, $password, $first_name, $last_name, $username, $email,
    $mobile_number, $birth_month, $birth_year, $gender, $life_stage,
    $country, $region, $city, $glc_id, $occupation, $industry, $purpose,
    $ccf_satellite, $place_of_worship, $worship_day, $worship_time,
    $registered_since, $area_pastor
);

if ($stmt->execute()) {
    header("Location: dashboard.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
    error_log("Database error: " . $stmt->error); // Log the error for debugging
}

$stmt->close();
$conn->close();