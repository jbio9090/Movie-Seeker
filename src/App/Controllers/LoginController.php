<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Account;
use App\Models\Mail;
use App\View;
use Google;
use App\Models\GoogleLogin;


class LoginController
{
    private $client;

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            $this->client = GoogleLogin::setupGoogleLogin();
            $authUrl = $this->client->createAuthUrl();

            $view = new View(
                "login.view",
                [
                    "title" => "Login",
                    "googleAuthUrl" => $authUrl
                ]
            );
        } else {
            $view = new View(
                "already-logged-in.view",
                ["title" => "Already Logged In"]
            );
        }

        echo $view->render();
    }

    public function verifyLogin()
    {

        $username = $_POST['username'];
        $userPassword = $_POST['password'];


        $verification = Account::loginAccount($username, $userPassword);

        if (!$verification) {
            $_SESSION['messages'] = "Username or Password does not match";
            header("Location: ./login");
            exit;
        } else {
            $_SESSION['user'] = $verification;
            header("Location: ./");
            exit;
        }
    }


    public function redirectFromGoogle()
    {
        if (!isset($_GET["code"])) {
            exit;
        }

        $client = GoogleLogin::setupGoogleLogin();
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token["access_token"]);
        $oauth = new Google\Service\Oauth2($client);
        $userinfo = $oauth->userinfo->get();

        $username = $userinfo["name"];
        $email = $userinfo["email"];
        $google_id = $userinfo["id"];

        $verification = Account::googleLogin(
            username: $username, 
            googleId: $google_id, 
            gmail: $email, );

        if (!$verification) {
            $_SESSION['messages'] = "Username or Password does not match";
            header("Location: ./login");
            exit;
        } else {
            $_SESSION['user'] = $verification;
            header("Location: ./../");
            exit;
        }
    }
}
