<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\Account;
use App\Models\Mail;
use App\View;


class LoginController
{


    public function index()
    {

        if (!isset($_SESSION['user'])) {
            $view = new View(
                "login.view",
                ["title" => "Login"]
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

}