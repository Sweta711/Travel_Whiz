<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
$email = $_POST['email'];
$otp = $_POST['otp'];

$savedOtp = file_get_contents("otp_$email.txt");

if ($otp == $savedOtp) {
    echo "OTP Verified";
} else {
    echo "Invalid OTP";
}
?>
