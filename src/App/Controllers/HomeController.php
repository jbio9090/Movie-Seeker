<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\TMDB_API;
use App\View;

class HomeController
{

    public function index()
    {
        TMDB_API::setGenres();
        $content = TMDB_API::getPopular()['results'];
        
        $random = rand(0 ,count($content) - 1);

        $view = new View(
            "index.view",
            [
                "title" => "Movie Seeker",
                "content" => $content,
                "genres" => TMDB_API::getGenres(),
                "banner_path" => 'https://image.tmdb.org/t/p/original/' . $content[$random]['backdrop_path']
            ]
        );

        echo $view->render();
    }

}