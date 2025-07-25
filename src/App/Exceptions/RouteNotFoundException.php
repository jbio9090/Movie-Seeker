<?php


namespace App\Exceptions;


class RouteNotFoundException extends \Exception {
    protected $message = "404 Page not found.";
    
}