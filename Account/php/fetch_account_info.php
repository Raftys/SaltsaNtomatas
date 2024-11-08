<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();
include "../../Functions/sql_functions.php";
$conn = connect();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}