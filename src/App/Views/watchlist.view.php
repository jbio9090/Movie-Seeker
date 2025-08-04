<div class="navMargin">

</div>


<div class="cardContainer">
    <h3 class="cardContainerTitle">Your Watchlist</h3>


    <?php if (isset($this->params['content'])): ?>

        <?php foreach ($this->params['content'] as $movie): ?>

            <div class="movieCard" onclick="location.href='./movie?id=<?php echo $movie['id'] ?>'">
                <img class="moviePoster" src="<?php echo (isset($movie['poster_path'])) ?
                    "https://image.tmdb.org/t/p/w200/" . $movie['poster_path']
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

                <?php
                $percent_score = round((float) $movie['vote_average'] * 10);
                $color;
                if ($percent_score > 80) {
                    $color = "darkGreenScore";
                } else if ($percent_score > 60) {
                    $color = "lightGreenScore";
                } else if ($percent_score > 40) {
                    $color = "yellowScore";
                } else if ($percent_score > 20) {
                    $color = "orangeScore";
                } else {
                    $color = "redScore";
                }
                ?>
                <div class="movieCardScore <?php echo $color ?>" style="<?php echo "mask:         
                linear-gradient(red 0 0) padding-box,
                conic-gradient(red $percent_score%, transparent 0%) border-box;" ?>">
                    <span><?php echo $percent_score; ?>
                        <span class="veryTiny">
                            %
                        </span>
                    </span>
                </div>
            </div>

        <?php endforeach; ?>

    <?php endif; ?>
</div>