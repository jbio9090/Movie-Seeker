<?php

declare(strict_types=1);
namespace App\Models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Mail
{
    public static function sendActivationLink(string $recipient, string $token, string $sender = "from@example.com")
    {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {

            //Set server settings
            self::setServerSettings($mail);

            //Recipients
            $mail->setFrom($sender);
            $mail->addAddress($recipient);     //Add a recipient


            //Content
            $link = "movieseeker.com/activate?token=$token";
            $email = "
            <h1>MovieSeeker</h1>
            <p>Please click the link to activate your account</p>
            <a href='$link'>$link</a>
            ";

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Email Activation Link';
            $mail->Body = $email;
            $mail->AltBody = strip_tags($email);

            $mail->send();

            // alert the user that it has been sent
            
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }


    private static function setServerSettings(PHPMailer $mail)
    {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                         //Send using SMTP
        $mail->Host = 'sandbox.smtp.mailtrap.io';                //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                  //Enable SMTP authentication
        $mail->Username = '835f9dcddec973';                      //SMTP username
        $mail->Password = '26928a4d478f29';                      //SMTP password
        $mail->Port = 465;                                       //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    }


}