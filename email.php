<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
// require_once 'vendor/autoload.php';
// use PHPMailer\src\PHPMailer;
// use PHPMailer\src\SMTP;
// use PHPMailer\src\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

include 'init.php';

$user = $users->getUserInfo();
function sendEmail($email, $departmentName, $description, $userName, $subject) {
    
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    echo 'Email: ' . $email . '<br>';
echo 'Username: ' . $userName . '<br>';
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();      
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
            );                                      //Send using SMTP
        // $mail->Host       = '192.168.99.5';                     //Set the SMTP server to send through
        // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        // $mail->Username   = 'ticket.system@incessantrainacademy.com';                     //SMTP username
        // $mail->Password   = 'AerGFcqMdUTVB)78';                               //SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        // // // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        // $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        // $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'iracademy.3d@gmail.com';                     //SMTP username
        $mail->Password   = "nsisqamchvcatgvp";  
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                             //SMTP password
        // $mail->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;  
        $mail->SMTPSecure = "ssl"; 


        // $mail->setFrom = "jinrai5777@gmail.com"; 
        // $mail->FromName = "Full Name";
        //Recipients
        $mail->setFrom($email, $email);
        // $mail->addAddress('jinrai5777@gmail.com');     //Add a recipient
        $mail->addAddress('rajesh.rai@incessantrainacademy.com');     //Add a recipient
        // $mail->addAddress('ticket@incessantrainacademy.com');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo($email, $userName);
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        // $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $description;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
        // $mail->send();
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

// Retrieve the form data from the AJAX request
// $email = $_POST['email'];
$email = $user['email'];
$userName = $user['name'];

$departmentId = isset($_POST['department']) ? $_POST['department'] : '';
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
$description = isset($_POST['message']) ? $_POST['message'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';



if (!empty($departmentId)) {
    $departmentName = $tickets->getDepartmentName($departmentId);
} else {
    $departmentName = "No Department Selected";
}

echo $departmentName;


echo '<br /> User';
echo implode($user);
echo '<br />finish';

echo 'Post';
$body = file_get_contents('php://input');
print_r($body);
echo 'finish post';

echo $email;
echo $description;
echo $subject;
echo $status;

// echo '<br /> '. $user;
// echo '<br />';
// Send the email
// if (sendEmail($email, $departmentName, $description, $userName, $subject)) {
//     echo 'Email sent successfully';
// } else {
//     http_response_code(500);
//     echo 'Failed to send email';
// }

// if (sendEmail('jinrai5777@gmail.com', 'department', 'problem', 'student', 'subject')){
//     echo sendEmail('jinrai5777@gmail.com', 'department', 'problem', 'student', 'subject');
//     echo 'Email send successfully';
// } else {
//     echo 'Failed to send email';
//     echo sendEmail('jinrai5777@gmail.com', 'department', 'problem', 'student', 'subject');
// }
echo 'Email: ' . $email . '<br>';
echo 'Username: ' . $userName . '<br>';
sendEmail($email, $departmentName, $description, $userName, $subject);

// modified php mailer function smtp server 
// dosen't send mail from smtp server to gmail server 
// sends gmail server and recieves gmail 
// email only works when removed event listener from DOM