<div class="navMargin">

</div>


<div class="cardContainer">
    <h3 class="fuiyo">Your Watchlist</h3>


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