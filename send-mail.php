<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *"); // or your specific domain
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST['name'] ?? '';
    $email   = $_POST['email'] ?? '';
    $phone   = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? 'Website Enquiry';
    $message = $_POST['message'] ?? '';

    $mail = new PHPMailer(true);

    try {
        // SMTP config (Google Workspace)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'muhibbayurdu@gmail.com'; // Google Workspace email
        $mail->Password   = 'xrlg kxjp bmkt oplr';       // App password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // From / To
        $mail->setFrom('muhibbayurdu@gmail.com', 'Website Contact');
        $mail->addAddress('sadiquekhan449@gmail.com', 'Admin');

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission: " . $subject;
        $mail->Body    = "
            <h3>Contact Form Details</h3>
            <p><b>Name:</b> {$name}</p>
            <p><b>Email:</b> {$email}</p>
            <p><b>Phone:</b> {$phone}</p>
            <p><b>Message:</b><br>{$message}</p>
        ";

        $mail->send();

        echo json_encode([
            "success" => true,
            "message" => "Thank you! Your message has been sent."
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => "Message could not be sent. Error: {$mail->ErrorInfo}"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request."
    ]);
}