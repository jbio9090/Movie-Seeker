<div class="navMargin"></div>

<form class="loginForm" method="POST" action="./register">

    <h2 class="h2Form">Register</h2>

    <?php if (isset($_SESSION['messages'])): ?>

        <p class="resultMessage" > <?php echo $_SESSION['messages'] ?> </p>
        <?php unset($_SESSION['messages']) ?>
        
    <?php endif; ?>

    <input type="text" name="username" placeholder="Username">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">

    <button class="formButton" type="submit">Register</button>

    <p class="loginFormLink">
        Already have an account? <a href="./login">Login</a>
    </p>

</form>