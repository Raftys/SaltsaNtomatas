<?php
session_start();
$user_id = $_SESSION['user_id'];
$new_full_name = $_POST['full_name'];
$new_email = $_POST['email'];
$new_phone = $_POST['phone'];
$new_address = $_POST['address'];
$new_city = $_POST['city'];
$new_zip_code = $_POST['zip_code'];
$new_country = $_POST['country'];
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "root"; // Your MySQL password
$dbname = "saltses";    // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "UPDATE users SET full_name = '$new_full_name', email = '$new_email', phone = '$new_phone', address = '$new_address', city = '$new_city', zip_code = '$new_zip_code',  country = '$new_country', root = '1' WHERE id = 4";
$stmt = $conn->prepare($sql);
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Record updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating record: " . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();