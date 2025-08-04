<div class="navMargin"></div>

<div class="movieContainer">

    <div class="backdropContainer"
        style="background-image: url('https://image.tmdb.org/t/p/original/<?php echo $this->params['content']['backdrop_path']; ?>');"
        alt="movie-backdrop">
    </div>

    <div class="movieDetailsContainer">
        <h2 class="moviePageTitle">
            <?php echo $this->params['content']['title'] ?>
        </h2>

        <span class="movieReleaseDate">
            <?php echo (isset($this->params['content']['release_date'])) ? "(" . $this->params['content']['release_date'] . ")"
                : "" ?>
        </span>

        <div class="movieGenreContainer">
            <?php if (isset($this->params['content']['genres'])): ?>
                <?php foreach ($this->params['content']['genres'] as $genre): ?>
                    <span class="movieGenreSpan">
                        <?php echo $genre['name']; ?>
                    </span>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <p>
            <?php echo $this->params['content']['overview'] ?>
        </p>


        <div class="bottomContainer">

                <?php
                $vote_average = (float) $this->params['content']['vote_average'];
                $percent_score = round($vote_average * 10);
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
                <div class="movieScore <?php echo $color ?>" style="<?php echo "mask:         
                linear-gradient(red 0 0) padding-box,
                conic-gradient(red $percent_score%, transparent 0%) border-box;" ?>">
                    <span><?php echo $percent_score; ?>
                        <span class="veryTiny">
                            %
                        </span>
                    </span>
                </div>
            

            <form method="POST" class="nostyleform addToWatchlistForm">
                <input type="hidden" name="movie_id" value="<?php echo $this->params['content']['id'] ?>">
                <input type="hidden" name="in_watchlist" value="<?php echo $this->params['in_watchlist'] ?>" class="in_watchlist">
                <input type="hidden" name="title" value="<?php echo $this->params['content']['title'] ?>">
                <input type="hidden" name="poster_path" value="<?php echo $this->params['content']['poster_path'] ?>">
                <input type="hidden" name="vote_average" value="<?php echo $vote_average ?? null ?>">

                <?php if (isset($this->params['content']['genres'])): ?>
                    <?php foreach ($this->params['content']['genres'] as $genre): ?>
                        <input type="hidden" name="genre_ids[]" value="<?php echo $genre['id'] ?>">
                    <?php endforeach; ?>
                <?php endif; ?>

                <button class="addToWatchlistButton
                    <?php echo (($this->params['in_watchlist'] == 1) ? 'activeButton' : "") ?>">
                    <?php if ($this->params['in_watchlist'] == 1) {
                            echo 'Remove from Watchlist';
                        } else {
                            echo 'Add to Watchlist';
                        } ?>
                </button>
            </form>

        </div>

    </div>
</div>




<?php if (isset($this->params['content']['credits']["cast"])): ?>
    <div class="actorsContainer">
        <h2>Cast</h2>
        <div class="flexContainer">
            <?php $count = 0; ?>
            <?php foreach ($this->params['content']['credits']["cast"] as $actor): ?>
                <?php $count++ ?>
                <div class="actorProfile <?php echo ($count >= 10) ? "lazy-img" : "showActor" ?>" data-src="<?php echo $actor['profile_path'] ?
                                                                                                                "https://image.tmdb.org/t/p/w200/" . $actor['profile_path'] :
                                                                                                                "./assets/placeholders/default_profile.jpg";
                                                                                                            ?>">
                    <img alt="<?php echo $actor['name'] ?>">
                    <p class="actorName"><?php echo $actor['name'] ?></p>
                    <p class="characterName"><?php echo $actor['character'] ?></p>
                </div>
            <?php endforeach; ?>

            <?php if (count($this->params['content']['credits']["cast"]) > 10): ?>
                <button class="showMoreButton">
                    Show All
                </button>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>



<?php if (isset($this->params['content']['images']["backdrops"])): ?>
    <div class="galleryContainer">
        <h2>Gallery</h2>
        <div class="mainDisplay">
            <img src="https://image.tmdb.org/t/p/original<?php echo $this->params['content']['images']['backdrops'][0]['file_path'] ?>"
                class="mainDisplayImg" alt="">
        </div>

        <div class="previewContainer">
            <?php
            $max = min(count($this->params['content']['images']["backdrops"]), 10);
            for ($i = 0; $i < $max; $i++): ?>

                <?php $file_path = $this->params['content']['images']['backdrops'][$i]['file_path'] ?>
                <div class="previewImage" data-file_path="<?php echo $file_path; ?>">
                    <img src="<?php echo "https://image.tmdb.org/t/p/w200" . $file_path ?>">
                </div>

            <?php endfor; ?>
        </div>
    </div>
<?php endif; ?>


<div class="indexContainer">

    <h2 class="fancy">
        Recommendations
    </h2>

    <div class="sliderContainer">
        <?php foreach ($this->params['content']['recommendations']['results'] as $movie): ?>

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

    </div>
</div>




<?php if (count($this->params['content']['credits']["cast"]) > 10): ?>
    <script>
        "use-strict";

        const showMore = document.querySelector(".showMoreButton");
        const lazyImg = document.querySelectorAll(".lazy-img");
        const showActor = document.querySelectorAll(".showActor");

        lazyImg.forEach(item => {
            item.classList.add("none");
        });

        showActor.forEach(item => {
            item.querySelector("img").src = item.dataset.src;
        });

        showMore.addEventListener("click", show);

        function show() {
            let state = showMore.textContent;

            lazyImg.forEach(item => {
                if (state === "Show Less") {
                    item.querySelector("img").src = "";
                    showMore.textContent = "Show All";
                } else {
                    item.querySelector("img").src = item.dataset.src;
                    showMore.textContent = "Show Less";
                }

                item.classList.toggle("none")
            });
        }
    </script>
<?php endif; ?>


<?php if (isset($this->params['content']['images']["backdrops"])): ?>
    <script>
        "use-strict";

        const mainDisplayImg = document.querySelector(".mainDisplayImg");
        const previewImages = document.querySelectorAll(".previewImage");

        previewImages.forEach((image) => {
            image.addEventListener("click", changeImage);
        });

        function changeImage(e) {
            mainDisplayImg.src =
                "https://image.tmdb.org/t/p/original" + e.currentTarget.dataset.file_path;
        }
    </script>
<?php endif; ?>



<script>
    "use-strict";

    const addToWatchlistForm = document.querySelector(".addToWatchlistForm");

    addToWatchlistForm.addEventListener("submit", addToWatchlist);


    async function addToWatchlist(e) {
        e.preventDefault();

        let formData = new FormData(addToWatchlistForm);
        let data = new URLSearchParams(formData);

        try {
            const in_watchlist = document.querySelector("input.in_watchlist");
            const addToWatchlistButton = document.querySelector(".addToWatchlistButton");

            addToWatchlistButton.disabled = true;
            addToWatchlistButton.classList.toggle("activeButton");
            addToWatchlistButton.classList.add("pendingButton");


            let response = await fetch(`<?php echo $_SERVER['REQUEST_URI'] ?>`, {
                'method': 'post',
                'body': data
            });


            let result = await response.json();
            // console.log(result.message);

            if (result.message === "added") {
                in_watchlist.value = 1
                addToWatchlistButton.innerHTML = "Remove from Watchlist";
            } else if (result.message === "deleted") {
                in_watchlist.value = 0;
                addToWatchlistButton.innerHTML = "Add to Watchlist";
            } else if (result.message === "not_logged_in") {
                window.location.href = "./watchlist";
            }

            addToWatchlistButton.classList.remove("pendingButton");
            addToWatchlistButton.disabled = false;

        } catch (err) {
            console.error(err);
        }



    }
</script>