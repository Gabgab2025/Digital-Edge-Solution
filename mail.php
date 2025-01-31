<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// reCAPTCHA Secret Key
$secretKey = '6LelasgqAAAAABQDIMp8OvJ5b-mBxHD15Pzvuiwa'; // Replace with your reCAPTCHA v3 Secret Key

if (isset($_POST["send"])) {
    // Verify reCAPTCHA token
    $recaptchaResponse = $_POST['recaptcha_response'];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secretKey,
        'response' => $recaptchaResponse,
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $responseKeys = json_decode($result, true);

    // Check if reCAPTCHA verification passed
    if ($responseKeys['success'] && $responseKeys['score'] >= 0.5) {
        // reCAPTCHA verification passed
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP(); // Send using SMTP
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'gabrielcausing.101898@gmail.com'; // SMTP username
            $mail->Password = 'rkjxrdzaoqtvamqq'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
            $mail->Port = 465; // TCP port to connect to

            // Recipients
            $mail->setFrom($_POST["email"], $_POST["name"]);
            $mail->addAddress('gabrielcausing.101898@gmail.com'); // Add a recipient
            $mail->addReplyTo($_POST["email"], $_POST["name"]); // Name is optional
            $mail->addCC('jbryan.jimenez@gmail.com');

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $_POST["subject"]; // Email subject
            $mail->Body = $_POST["message"]; // Email message
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // Send the email
            $mail->send();
            echo "
            <script>
            alert('Message was sent successfully!');
            document.location.href = 'digital-edge-solution.html';
            </script>
            ";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // reCAPTCHA verification failed
        echo "
        <script>
        alert('reCAPTCHA verification failed. Please try again.');
        document.location.href = 'digital-edge-solution.html';
        </script>
        ";
    }
}
?>