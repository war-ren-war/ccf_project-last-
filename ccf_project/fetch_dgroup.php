<?php
$servername = "localhost";
$username = "root"; // change if necessary
$password = ""; // change if necessary
$dbname = "ccf_users2"; // change if necessary

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM dgroup_details";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['dgroup_name'] . "</td>
                <td>" . $row['dgroup_leader'] . "</td>
                <td>" . $row['time_availability'] . "</td>
                <td>" . $row['location'] . "</td>
                <td>" . $row['group_type'] . "</td>
                <td>" . $row['life_stage'] . "</td>
                <td>--</td>
                <td>
                    <button>Edit</button>
                    <button>Delete</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No records found</td></tr>";
}

$conn->close();
?>
