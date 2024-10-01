<?php

function connect_database()
{
    $host = 'localhost';
    $db = 'products';
    $user = 'root'; // or your MySQL username
    $pass = 'root'; // your MySQL password

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error)
        die("Connection failed: " . $conn->connect_error);
    return $conn;
}

function load_products($conn) {
    $sql = "SELECT id, name, description, price, image FROM products";
    $result = $conn->query($sql);

    $items = [];

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    }
    $conn->close();
    return $items;
}

$conn =  connect_database();
$items = load_products($conn);
header('Content-Type: application/json');
echo json_encode($items);