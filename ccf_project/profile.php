<?php
session_start();
require '../db_connection.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Not authenticated"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Split birthday into month and year
    $birthday = new DateTime($user['birthday']);
    $birth_month = $birthday->format('F');
    $birth_year = $birthday->format('Y');

    echo json_encode([
        "fullname" => $user["fullname"],
        "nickname" => $user["nickname"],
        "username" => $user["username"],
        "email" => $user["email"],
        "gender" => $user["gender"],
        "birthday" => $user["birthday"],
        "birth_month" => $birth_month,
        "birth_year" => $birth_year,
        "life_stage" => $user["life_stage"],
        "contact" => $user["contact"],
        "country" => $user["country"],
        "region" => $user["region"],
        "city" => $user["city"],
        "image_url" => $user["image_url"] // Ensure image_url is available
    ]);
} else {
    echo json_encode(["error" => "User not found"]);
}
?>
