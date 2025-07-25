<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\TMDB_API;
use App\Models\Watchlist;
use App\View;

class WatchlistController
{


    public function index()
    {

        if (!isset($_SESSION['user'])) {
            $view = new View(
                "login-required.view",
                ["title" => "Watchlist - Login Required"]
            );

            echo $view->render();
            exit;
        }

        $user_id = $_SESSION['user'];

        $content = Watchlist::getWatchlist($user_id);
        TMDB_API::setGenres();
     

        $view = new View(
            "watchlist.view",
            [
                "title" => "Watchlist",
                "content" => $content,
                "genres" => TMDB_API::getGenres()
            ]
        );

        echo $view->render();
    }

}