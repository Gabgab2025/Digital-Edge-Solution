
<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
if (isset($_POST["send"])) {

  

  $mail = new PHPMailer(true);

  try {
      //Server settings
    //   $mail->SMTPDebug = SMTP::verbose;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'gabrielcausing.101898@gmail.com';                     //SMTP username
      $mail->Password   = 'rkjxrdzaoqtvamqq';                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      // $mail->setFrom('from@example.com', 'Mailer');
      $mail->setFrom( $_POST["email"], $_POST["name"]);
      $mail->addAddress('gabrielcausing.101898@gmail.com');     //Add a recipient
      $mail->addReplyTo($_POST["email"], $_POST["name"]);         //Name is optional
      $mail->addCC('jbryan.jimenez@gmail.com');
      // $mail->addBCC('bcc@example.com');

      //Attachments
      // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

      //Content
      $mail->isHTML(true);               //Set email format to HTML
      $mail->Subject = $_POST["subject"];   // email subject headings
      $mail->Body    = $_POST["message"]; //email message
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      $mail->send();
      echo   " 
      <script> 
      alert('Message was sent successfully!');
      document.location.href = 'digital-edge-solution.html';
      </script>
      ";
  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}