<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

include 'init.php';
print_r($_SESSION);
$user = $users->getUserInfo();
function sendEmail($email, $departmentName, $description, $userName, $subject) {
    
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    echo 'Email: ' . $email . '<br>';
echo 'Username: ' . $userName . '<br>';
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
        $mail->isSMTP();      
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
            );                                      
        $mail->Host       = '192.168.99.5';                    
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'ticket.system@incessantrainacademy.com';                    
        $mail->Password   = 'AerGFcqMdUTVB)78';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
        $mail->Port       = 465;
     
        $mail->setFrom($email, $email);
         //Add a recipient
        $mail->addAddress('ticket@incessantrainacademy.com');     //Add a recipient
       
        $mail->addReplyTo($email, $userName);
                          
        $mail->Subject = $subject;
        $mail->Body    = $description;

        if(!$mail->Send()) {
            echo "Error while sending Email.";
            var_dump($mail);
          } else {
            echo "Email sent successfully";
          }
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}





sendEmail($email, $departmentName, $description, $userName, $subject);
