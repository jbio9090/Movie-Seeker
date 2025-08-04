<?php
declare(strict_types=1);
namespace App;

use App\Exceptions\RouteNotFoundException;

$autoload = dirname(__DIR__, 2) . '/vendor/autoload.php';

if (!is_readable($autoload)) {
    die("Could not read autoload at: $autoload");
}

require_once $autoload;


use App\Router;
use App\Controllers;
use Dotenv\Dotenv;

define("VIEW_PATH", __DIR__ . "/../App/Views/");
define("CSS_PATH", __DIR__ . "/assets/styles.css");


try {
    $router = new Router();

    $router
        ->get("/", [Controllers\HomeController::class, "index"])
        ->get("/search", [Controllers\SearchController::class, "index"])
        ->get("/movie", [Controllers\MoviePageController::class, "index"])
        ->get("/watchlist", [Controllers\WatchlistController::class, "index"])
        ->get("/login", [Controllers\LoginController::class, 'index'])
        ->get('/register', [Controllers\RegisterController::class, 'index'])
        ->post('/register', [Controllers\RegisterController::class, 'registerAccount'])
        ->get('/activate', [Controllers\RegisterController::class, 'activateAccount'])
        ->post('/login', [Controllers\LoginController::class, 'verifyLogin'])
        ->get('/account', [Controllers\AccountController::class, 'index'])
        ->get('/account/logout', [Controllers\AccountController::class, 'logout'])
        ->post('/movie' , [Controllers\MoviePageController::class, 'addToWatchlist']);


    $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
    $dotenv->load();

    session_start();

    $cleanURI = $_SERVER["REQUEST_URI"];

    $router->resolve($cleanURI, $_SERVER["REQUEST_METHOD"]);

} catch (RouteNotFoundException $e) {

    $errorPage = new View('/404.view', ['title' => '404 - Page not found']);

    http_response_code(404);
    echo $errorPage->render();
    exit;
    
}
