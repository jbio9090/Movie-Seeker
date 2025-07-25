<div class="navMargin"></div>

<form class="loginForm" method="POST" action="./login">

    <h2 class="h2Form">Login</h2>

    <?php if (isset($_SESSION['messages'])): ?>

        <p class="resultMessage"> <?php echo $_SESSION['messages'] ?> </p>
        <?php unset($_SESSION['messages']) ?>

    <?php endif; ?>

    <input type="text" name="username" placeholder="Username or Email">
    <input type="password" name="password" placeholder="Password">

    <button class="formButton" type="submit">Login</button>

    <a href="./register" class="createNewAccountLink">Create new account</a>

</form>