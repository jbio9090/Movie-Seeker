<?php

declare(strict_types=1);
namespace App\Models;

use App\Exceptions\WatchlistAddMovieErrorException;
use App\Exceptions\WatchlistDeleteMovieErrorException;


class Watchlist
{

    public static function isInWatchlist(int $movie_id, string $user_id): bool
    {
        $db = Database::connect();

        $sql = "SELECT * from watchlist WHERE 
        movie_id = :movie_id AND user_id = :user_id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue('movie_id', $movie_id);
        $stmt->bindValue('user_id', $user_id);
        $stmt->execute();

        if ($stmt->fetchAll()) {
            return true;
        } else {
            return false;
        }
    }


    public static function getWatchlist(string $user_id): array
    {

        $db = Database::connect();

        $sql = "SELECT * from watchlist WHERE 
        user_id = :user_id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue('user_id', $user_id);
        $stmt->execute();

        $result = $stmt->fetchAll();
        $watchlist = [];

        foreach ($result as $movie) {
            $id = $movie['movie_id'];

            $watchlist[$id]['id'] = $movie['movie_id'];
            $watchlist[$id]['title'] = $movie['title'];
            $watchlist[$id]['poster_path'] = $movie['poster_path'];
            $watchlist[$id]['genre_ids'] = explode(",", $movie['genre_ids']);
            $watchlist[$id]['time_added'] = $movie['time_added'];
        }

        return $watchlist;
    }

    public static function add(
        string $user_id, 
        string $movie_id,
        string $title,
        string $poster_path,
        array $genre_ids,
        )
    {
        $db = Database::connect();

        $str_genre_ids = implode(",", $genre_ids);

        $sql = "INSERT INTO watchlist (watchlist_id, user_id, movie_id, poster_path, title, genre_ids) 
        VALUES (UUID(), :user_id, :movie_id, :poster_path, :title, :genre_ids)";

        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue('movie_id', $movie_id);
            $stmt->bindValue('user_id', $user_id);
            $stmt->bindValue('poster_path', $poster_path);
            $stmt->bindValue('title', $title);
            $stmt->bindValue('genre_ids', $str_genre_ids);
            $stmt->execute();
        } catch (WatchlistAddMovieErrorException $e) {
            //
        }
    }


    public static function delete(string $user_id, string $movie_id)
    {
        $db = Database::connect();

        $sql = "DELETE FROM watchlist WHERE user_id = :user_id
        AND movie_id = :movie_id";

        try {
            $stmt = $db->prepare($sql);
            $stmt->bindValue('movie_id', $movie_id);
            $stmt->bindValue('user_id', $user_id);
            $stmt->execute();
        } catch (WatchlistDeleteMovieErrorException $e) {

        }
    }

}