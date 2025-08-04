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
            
            $page = (isset($_GET['page']) ? (int) $_GET['page'] : 1);

            $content = TMDB_API::searchMovie($_GET['query'], $page);
            
            $total_pages = ($_GET['total_pages']) ?? $content['total_pages'];
        }

        // get genres from TMDB and set it to a variable
        TMDB_API::setGenres();


        $view = new View(
            "search.view",
            [
                "title" => "Seek Movies",
                "query" => $_GET['query'] ?? null,
                "page" => $page ?? 1,
                "total_pages" => $total_pages ?? 1,
                "content" => $content['results'] ?? null,
                "genres" => TMDB_API::getGenres()
            ]
        );



        echo $view->render();
    }
}
