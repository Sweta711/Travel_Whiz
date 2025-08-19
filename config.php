<?php
$host = "localhost";
$user = "root";
$pass = ""; // default password for XAMPP
$db = "flutter_auth";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
