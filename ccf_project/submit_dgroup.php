<?php
$servername = "localhost";
$username = "root"; // Change this as needed
$password = ""; // Change this as needed
$dbname = "ccf_users"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dgroup_name = $_POST['dgroup_name'];
    $dgroup_leader = $_POST['dgroup_leader'];
    $time_availability = $_POST['time_availability'];
    $location = $_POST['location'];
    $group_type = $_POST['group_type'];
    $life_stage = $_POST['life_stage'];
    $actions_notes = $_POST['actions_notes'];

    // Insert the form data into the database
    $sql = "INSERT INTO dgroup_details (dgroup_name, dgroup_leader, time_availability, location, group_type, life_stage, actions_notes)
            VALUES ('$dgroup_name', '$dgroup_leader', '$time_availability', '$location', '$group_type', '$life_stage', '$actions_notes')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
