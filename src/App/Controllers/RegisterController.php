<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\Account;
use App\View;
use App\Models\Mail;
use DateTime;

class RegisterController
{


    public function index()
    {
        $view = new View(
            "register.view",
            ["title" => "Register Account"]
        );

        echo $view->render();
    }

    public function registerAccount()
    {

        $username = $_POST['username'];
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];

        if (empty($username) || empty($password_hash) || empty($email)) {
            $_SESSION['messages'] = "Please fill all the input fields";
            header("Location: ./register");
            exit;
        }

        $token = bin2hex(random_bytes(16));
        Account::registerAccount($username, $password_hash, $email, $token);
        Mail::sendActivationLink($email, $token);

        $view = new View(
            '/account-created.view',
            [
                'title' => 'Account Registered',
                'message' => 'Account has been reigstered. Please return to the login page to access the account'
            ]
        );

        echo $view->render();
        unset($_SESSION['messages']);
        exit;
    }

    public function activateAccount()
    {
        $token = $_GET['token'];
        $dateFormat = 'Y-m-d H:i:s'; 

        $account = Account::getUserDetails($token, Account::USER_TOKEN);
        

        if (strtotime($account['token_expiry']) < time()) {
            Account::deleteAccount($account['user_id']);

            $view = new View("expired_token.view", ['title' => 'Expired Token']);
            echo $view->render();
            exit;
        }

        Account::activateAccount($account['user_id']);

        $view = new View("account-activated.view", ['title' => 'Account Activated']);
        echo $view->render();
    }

}