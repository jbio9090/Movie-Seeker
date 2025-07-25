<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Models\TMDB_API;
use App\View;
use App\Models;

class SearchController
{


    public function index()
    {

        if (isset($_GET['query'])) {
            $content = TMDB_API::searchMovie($_GET['query'])['results'];
        }
        
        // get genres from TMDB and set it to a variable
        TMDB_API::setGenres();


        $view = new View(
            "search.view",
            [
                "title" => "Seek Movies",
                "query" => $_GET['query'] ?? null,
                "content" => $content ?? null,
                "genres" => TMDB_API::getGenres()
            ]
        );

        

        echo $view->render();
    }


}