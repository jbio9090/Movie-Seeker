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
    <?php $query = $this->params['query'] ?>
    <h3 class="queryDisplay">Search Results for "<?php echo ($query ?? '') ?>"</h3>
<?php endif; ?>


<div class="cardContainer">
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
                $percent_score = round((float) ($movie['vote_average'] ?? 0) * 10);
                $color;
                if ($percent_score >= 80) {
                    $color = "darkGreenScore";
                } else if ($percent_score >= 60) {
                    $color = "lightGreenScore";
                } else if ($percent_score >= 40) {
                    $color = "yellowScore";
                } else if ($percent_score >= 20) {
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



    <?php
    $page = $this->params['page'];
    $total_pages = $this->params['total_pages'];
    ?>

    <div class="paginationControl">

        <a class="prevPage" href="./search?<?php $prev = $page - 1;
                                            echo "query=$query&page=$prev" ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill='currentColor' viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                <path d="M201.4 297.4C188.9 309.9 188.9 330.2 201.4 342.7L361.4 502.7C373.9 515.2 394.2 515.2 406.7 502.7C419.2 490.2 419.2 469.9 406.7 457.4L269.3 320L406.6 182.6C419.1 170.1 419.1 149.8 406.6 137.3C394.1 124.8 373.8 124.8 361.3 137.3L201.3 297.3z" />
            </svg>
        </a>

        <?php
        $visiblePages = 5;
        $half = floor($visiblePages / 2);

        $start = max(2, $page - $half);
        $end = min($total_pages - 1, $page + $half);

        if ($end - $start + 1 < $visiblePages) {
            if ($start == 1) {
                $end = min($total_pages, $start + $visiblePages - 1);
            } else if ($end == $total_pages) {
                $start = max(1, $total_pages - $visiblePages + 1);
            }
        }
        ?>

        <a href="./search?<?php echo "query=$query&page=1" ?>" class="paginationLink <?php echo ($page == $i) ? "currentPage" : ""; ?>">
            <?php echo 1 ?>
        </a>
        <?php if ($start > 2): ?>
            <span>
                ...
            </span>
        <? endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>

            <a href="./search?<?php echo "query=$query&page=$i" ?>" class="paginationLink <?php echo ($page == $i) ? "currentPage" : ""; ?>">
                <?php echo $i ?>
            </a>

        <?php endfor; ?>

        <?php if ($end < $total_pages - 2): ?>
            <span>
                ...
            </span>
        <? endif; ?>
        <a href="./search?<?php echo "query=$query&page=$total_pages" ?>" class="paginationLink <?php echo ($page == $i) ? "currentPage" : ""; ?>">
            <?php echo $total_pages ?>
        </a>


        <a class="nextPage" href="./search?<?php $next = $page + 1;
                                            echo "query=$query&page=$next" ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                <path d="M439.1 297.4C451.6 309.9 451.6 330.2 439.1 342.7L279.1 502.7C266.6 515.2 246.3 515.2 233.8 502.7C221.3 490.2 221.3 469.9 233.8 457.4L371.2 320L233.9 182.6C221.4 170.1 221.4 149.8 233.9 137.3C246.4 124.8 266.7 124.8 279.2 137.3L439.2 297.3z" />
            </svg>
        </a>

    </div>

</div>