<?php


namespace App\Exceptions;


class WatchlistDeleteMovieErrorException extends \Exception {
    protected $message = "Can't delete movie in the database";
    
}