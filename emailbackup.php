<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $mail = new PHPMailer();
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;    
    $mail->isSMTP();
    $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
        ); 
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;
    $mail->Username = 'jinrai5777@gmail.com'; // Your Gmail email address
    $mail->Password = 'qbcb yizr ylpf dwwt'; // Your Gmail password
    // $mail->Password = 'dspu eamr dozm prcz';
    $mail->setFrom($email, $name);
    $mail->addAddress('info@dailyfcc.com'); // Recipient's email address
    $mail->Subject = 'Message from  email < '. $email.' >';
    $mail->Body = $message;
    $response = [];
    if (empty($message)){
        $response = array("status" => "error", "message" => "Message is Empty");
    } else {
        
        if ($mail->send()) {
        
          $response = array("status" => "success", "message" => "Email sent successfully!");
        } else {
            $response = array("status" => "error", "message" => "Email delivery failed ". $message);
         
          
        }
    }
    header('Content-Type: application/json');

    echo json_encode($response);

  
    // exit;
  
    
} else {
 
}
