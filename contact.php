<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.mail.me.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    // Form data
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    // Recipients
    $mail->setFrom($_ENV['SMTP_USERNAME'], 'Demo Website 1');
    $mail->addReplyTo($email, $name);
    $mail->addAddress($_ENV['SMTP_USERNAME']);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission';
    $mail->Body = "<p><strong>Name:</strong> $name</p>
                   <p><strong>Email:</strong> $email</p>
                   <p><strong>Message:</strong><br>$message</p>";

    $mail->send();

    // Redirect to Thank You Page
    header("Location: emailsent.html");
    exit();
} catch (Exception $e) {
    echo "<div style='font-family: Arial, sans-serif; text-align: center; margin-top: 50px;'>
            <h2 style='color: red;'>Oops! Something went wrong.</h2>
            <p style='color: #555;'>We couldn't send your message. Please try again later.</p>
            <a href='index.html' style='text-decoration: none; background: #007BFF; color: white; padding: 10px 20px; border-radius: 5px;'>Go Back</a>
          </div>";
}
?>
