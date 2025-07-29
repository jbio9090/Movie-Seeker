<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\TMDB_API;
use App\Models\Watchlist;
use App\View;

class MoviePageController
{


    public function index()
    {
        $id = $_GET['id'];

        if (!isset($id)) {
            header("Location: ./");
            exit;
        }

        $content = TMDB_API::getMovieDetails((int) $id);
        $movie_id = (int) $_GET['id'];
        $user_id = $_SESSION['user'] ?? null;
        TMDB_API::setGenres();

        if (isset($user_id)) {
            $is_in_watchlist = Watchlist::isInWatchlist($movie_id, $user_id);
        } else {
            $is_in_watchlist = false;
        }


        $view = new View(
            "movie.view",
            [
                "title" => $content['title'],
                "movie_id" => $movie_id ?? null,
                'content' => $content ?? null,
                'in_watchlist' => $is_in_watchlist ? 1 : 0,
                'genres' => TMDB_API::getGenres(),
            ]
        );

        echo $view->render();
    }

    public function addToWatchlist()
    {

        if (!isset($_SESSION['user'])) {
            $view = new View(
                "login-required.view",
                ["title" => "Watchlist - Login Required"]
            );

            echo $view->render();
            exit;
        }

        $in_watchlist = $_POST['in_watchlist'];
        $movie_id = $_POST['movie_id'];
        $user_id = $_SESSION['user'];
        $movie_title = $_POST['title'];
        $genre_ids = $_POST['genre_ids'] ?? null;
        $poster_path = $_POST['poster_path'] ?? null;
        $vote_average = (float) ($_POST['vote_average'] ?? 0);

        if ($in_watchlist == 1) {
            Watchlist::delete($user_id, $movie_id);
        } else {
            Watchlist::add(
                $user_id, 
                $movie_id,
                $movie_title,
                $poster_path,
                $genre_ids,
                $vote_average
            );
        }

        header("Location: ./movie?id=" . $movie_id);
        exit;

    }
}

