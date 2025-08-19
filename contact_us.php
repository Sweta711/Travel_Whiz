<?php
// CORS headers – must be at the top
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only proceed if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["status" => "error", "message" => "Only POST requests are allowed."]);
    exit();
}

require 'config.php';

// ✅ Sanitize and receive form inputs
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';
$filename = "";
$filedata = null;

// ✅ Handle file if uploaded
if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
    $filename = basename($_FILES['attachment']['name']);
    $filedata = file_get_contents($_FILES['attachment']['tmp_name']);
}

// ✅ Prepare SQL safely
$stmt = $conn->prepare("INSERT INTO contact_us (name, email, phone, subject, message, filename, filedata) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $email, $phone, $subject, $message, $filename, $filedata);

// ✅ Execute and respond
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Message sent successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
}

// ✅ Clean up
$stmt->close();
$conn->close();
?>
