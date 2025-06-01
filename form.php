<?php
session_start();
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';


// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['service'];
    $message = $_POST['message'];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0;                      // Enable verbose debug output (0 = off)
        $mail->isSMTP();                           // Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';  // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                  // Enable SMTP authentication
        $mail->Username   = 'info@aswinstevin.com'; // SMTP username
        $mail->Password   = 'Stephin@2505';       // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL encryption
        $mail->Port       = 465;                   // TCP port to connect to

        // Recipients
        $mail->setFrom('info@admirecleaning.ae', 'Message From Website');
        $mail->addReplyTo($email, $name, $phone); // $email and $name are from the form data
        $mail->addAddress('info@admirecleaning.ae', 'Admire Cleaning'); // Add your business email

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = '<h3>You have received a new message from your website contact form.</h3>'
                        . '<p><strong>Name:</strong> ' . $name . '</p>'
                        . '<p><strong>Email:</strong> ' . $email . '</p>'
                        . '<p><strong>Phone:</strong> ' . $phone . '</p>'
                        . '<p><strong>Service:</strong> ' . $subject . '</p>'
                        . '<p><strong>Message:</strong><br>' . nl2br($message) . '</p>';
        $mail->AltBody = "Name: $name\nEmail: $email\nSubject: $subject\nMessage:\n$message";

       $mail->send();
        $_SESSION['flash_message'] = 'Message sent successfully!';
    } catch (Exception $e) {
        $_SESSION['flash_message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }

    // Redirect back to the form page
    header('Location: thankyou.html');
   
}
?>