<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$email = $_POST['email'];
$otp = rand(100000, 999999);
file_put_contents("otp_$email.txt", $otp); // Simple file store for demo

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'project020g@gmail.com'; // your Gmail
$mail->Password = 'nmfy ctuy unrw urzi';   // app password from Google
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('youremail@gmail.com');
$mail->addAddress($email);
$mail->Subject = 'Your OTP Code';
$mail->Body    = "Your OTP is: $otp";

try {
    $mail->send();
    echo "OTP Sent";
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
