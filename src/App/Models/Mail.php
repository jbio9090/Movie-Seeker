<?php

declare(strict_types=1);

namespace App\Models;

use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;
use Exception;

class Mail
{
    public static function sendActivationLink(string $recipient, string $token, string $sender = "movieseekerwebsite123@gmail.com")
    {
        try {
            $apiKey = $_ENV['MAILTRAP_API_KEY']; 

            $mailtrap = MailtrapClient::initSendingEmails(
                apiKey: $apiKey,
            );

            $link = $_ENV['app_url'] . "activate?token=$token";
            $emailHtml = "
            <h1>MovieSeeker</h1>
            <p>Please click the link to activate your account</p>
            <a href='$link'>$link</a>
            ";

            $email = (new MailtrapEmail())
                ->from(new Address($sender, 'MovieSeeker'))
                ->to(new Address($recipient))
                ->subject('Email Activation Link')
                ->html($emailHtml)
                ->text(strip_tags($emailHtml));

            $response = $mailtrap->send($email);

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
        }
    }
}