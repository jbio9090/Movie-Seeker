<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\Account;
use App\View;

class AccountController
{

    public function index()
    {

        $result = Account::getUserDetails($_SESSION["user"]);

        $view = new View(
            "account.view",
            [
                "title" => "Account Settings",
                "username" => $result['username'],
                "user_id" => $result['user_id'],
            ]
        );

        echo $view->render();
    }



    public function logout()
    {
        // Initialize the session.
        // If you are using session_name("something"), don't forget it now!
        session_start();

        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();

        header("Location: /");
        exit;
    }

}