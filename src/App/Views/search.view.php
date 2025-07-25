<div class="navMargin"></div>

<form action="./search" method="GET" class="searchFormLong">

    <button type="submit" class="searchButton">
        <svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
            <path fill="currentColor"
                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
        </svg>
    </button>
    <input type="text" name="query" placeholder="Movie Name, Keywords, etc.">
</form>

<?php if (isset($this->params['query'])): ?>
    <h3 class="queryDisplay">Search Results for "<?php echo ($this->params['query'] ?? '') ?>"</h3>
<?php endif; ?>

<div class="cardContainer">
    <?php if (isset($this->params['content'])): ?>

        <?php foreach ($this->params['content'] as $movie): ?>

            <div class="movieCard" onclick="location.href='./movie?id=<?php echo $movie['id'] ?>'">
                <img class="moviePoster" src="<?php echo (isset($movie['poster_path'])) ?
                    "https://image.tmdb.org/t/p/w500/" . $movie['poster_path']
                    : "./assets/placeholders/default_poster.jpg"; ?>" alt="<?php echo $movie['title'] . " poster" ?>">

                <h5 class="movieCardTitle"><?php echo $movie['title'] ?></h5>

                <div class="movieCardGenres">
                    <?php if (isset($movie['genre_ids'])): ?>
                        <?php $count = 0; ?>
                        <?php foreach ($movie['genre_ids'] as $genre_id): ?>
                            <?php
                            $count++;
                            $separator = $count == count($movie['genre_ids']) ? '' : ',';
                            echo $this->params['genres'][$genre_id] . $separator;
                            ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        <?php endforeach; ?>

    <?php endif; ?>
</div>