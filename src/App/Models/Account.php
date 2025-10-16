<?php

declare(strict_types=1);

namespace App\Models;

use Exception;


class Account
{
    public const USER_ID = "user_id";
    public const USER_TOKEN = "token";
    public const USER_GOOGLE_LOGIN = "google_id";

    public static function registerAccount(
        string $username,
        string $password_hash,
        string $email,
        string $token,
        int $expiry = 1 * 24 * 60 * 60
    ) {

        try {
            $db = Database::connect();
        } catch (Exception $e) {
            echo $e;
            exit;
        }


        // check duplicates
        $stmt = $db->prepare("SELECT * from users WHERE email = :email OR username = :username");
        $stmt->bindValue('email', $email);
        $stmt->bindValue('username', $username);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if (!empty($result)) {
            $_SESSION['messages'] = "Email or Username already exists.";
            header("Location: ./register");
            exit;
        }

        $query = "INSERT INTO users (user_id, username, email, password_hash, token, token_expiry)
        VALUES (UUID(), :username, :email, :password_hash, :token, :token_expiry)";

        $stmt = $db->prepare($query);

        $stmt->bindValue('username', $username);
        $stmt->bindValue('email', $email);
        $stmt->bindValue('password_hash', $password_hash);
        $stmt->bindValue('token', $token);
        $stmt->bindValue('token_expiry', date('Y-m-d H:i:s', time() + $expiry));

        $stmt->execute();
    }



    public static function loginAccount(string $username, ?string $userPassword = null, ?string $googleId = null, ?string $email = null): bool|string
    {
        try {
            if (empty($userPassword) && empty($googleId)) {
                return false;
            }

            $db = Database::connect();
            if (!empty($googleId)) {
                $query = "SELECT * from users WHERE email = :email OR google_id = :google_id";
                $stmt = $db->prepare($query);
                $stmt->bindValue("email", $email);
                $stmt->bindValue("google_id", $googleId);
            } else {
                $query = "SELECT * FROM users WHERE username = :username";
                $stmt = $db->prepare($query);
                $stmt->bindValue('username', $username);
            }

            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            // var_dump($result);

            if (empty($result)) {
                return false;
            }

            if (empty($googleId)) {
                if (!password_verify($userPassword, $result['password_hash'])) {
                    return false;
                }

                if ($result['is_activated'] == 0) {
                    return false;
                }
            }
        } catch (Exception $e) {
            exit;
        }

        return $result['user_id'];
    }


    public static function getUserDetails(
        string $identifier,
        $filterBy = self::USER_ID,
        ?string $email = null,
    ): array|bool {
        $db = Database::connect();

        if ($filterBy == self::USER_GOOGLE_LOGIN) {
            $query = "SELECT * FROM users WHERE $filterBy = :identifier OR email like :email";
            $stmt = $db->prepare($query);
            $stmt->bindValue("identifier", $identifier);
            $stmt->bindValue("email", $email);
        } else {
            $query = "SELECT * FROM users WHERE $filterBy = :identifier ";
            $stmt = $db->prepare($query);
            $stmt->bindValue("identifier", $identifier);
        }

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    public static function deleteAccount(string $user_id)
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("DELETE FROM users WHERE user_id = :user_id");
            $stmt->bindValue("user_id", $user_id);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e;
        }
    }


    public static function activateAccount(string $user_id)
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("UPDATE users SET is_activated = 1 WHERE user_id = :user_id");
            $stmt->bindValue("user_id", $user_id);
            $stmt->execute();
        } catch (Exception $e) {
            echo ($e);
        }
    }


    public static function googleLogin(string $googleId, string $gmail, string $username)
    {
        $user = self::getUserDetails($googleId, self::USER_GOOGLE_LOGIN, $gmail);

        if ($user) {
            return self::loginAccount(username: $username, googleId: $googleId, email: $gmail);
        } else {
            $db = Database::connect();

            $query = "INSERT INTO users (user_id, username, email, google_id, is_activated, login_type)
                    VALUES (UUID(), :username, :email, :googleId, :is_activated, :login_type)";

            $stmt = $db->prepare($query);
            $stmt->bindValue("username", $username);
            $stmt->bindValue("email", $gmail);
            $stmt->bindValue("googleId", $googleId);
            $stmt->bindValue("is_activated", 1);
            $stmt->bindValue("login_type", "google");

            $stmt->execute();

            return self::loginAccount($username, $googleId, $gmail);
        }
    }
}
