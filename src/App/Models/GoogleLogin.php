<?php

declare(strict_types=1);

namespace App\Models;

use Google;

class GoogleLogin
{
    public static function setupGoogleLogin()
    {
        $client = new Google\Client;

        $client->setClientId($_ENV["google_client_ID"]);
        $client->setClientSecret($_ENV["google_client_secret"]);
        $client->setRedirectUri($_ENV["google_redirect_uri"]);

        $client->addScope("profile");
        $client->addScope("email");

        return $client;
    }

    
}
