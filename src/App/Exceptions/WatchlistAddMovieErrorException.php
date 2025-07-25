<?php


namespace App\Exceptions;


class WatchlistAddMovieErrorException extends \Exception {
    protected $message = "Can't add movie to the database";
    
}