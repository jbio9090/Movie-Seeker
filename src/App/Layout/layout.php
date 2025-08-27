<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo "./assets/styles.css" ?>">
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">
    <title><?php echo $this->params["title"] ?></title>
</head>

<body>

    <div class="navBar">
        <nav>

            <img id="logo" src="./assets/MovieSeekerLogo.svg">

            <a class="showMenu navIcons">
                <img src="" alt="menu-icon" height="28px" width="28px">
            </a>

            <ul class="navList">

                <a class="close navIcons">
                    <img src="" alt="close-icon" height="28px" width="28px">
                </a>

                <li><a class="navLinks" href="./">Home</a></li>
                <li><a class="navLinks" href="./search">Movies</a></li>
                <li><a class="navLinks" href="./watchlist">Watchlist</a></li>

                <?php if (isset($_SESSION['user'])): ?>
                    <li><a class="navLinks" href="./account">Account</a></li>
                <?php else: ?>
                    <li><a class="navLinks" href="./login">Login</a></li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>

    <?php echo $content ?>


    <footer>
        <span class="footerText">
            MovieSeeker uses TMDB and the TMDB APIs but is not endorsed, certified, or otherwise approved by TMDB.
        </span>
    </footer>

</body>

</html>