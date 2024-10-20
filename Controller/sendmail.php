<?php

    $email = $_POST['email'];
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    require "../vendor/autoload.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "mail.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->port = 587;

    $mail->Username = "habeebajani9@gmail.com";
    $mail->Password = "toivoyatoivo7777";

    $mail->setFrom($email, $name);
    $mail->addAddress("habeebajani9@gmail.com");

    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
    echo "sent";
?>