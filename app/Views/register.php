<h1>
    Register
</h1>

<form method="POST" action="register" autocomplete="off" novalidate>
    <input type="email" name="email" placeholder="Enter your email" required value="mirko@mirko.com">
    <?php if (isset($email)) echo "<p>".$email."</p>"?>


    <input type="password" name="password" placeholder="Enter your password" required min=6 max=50 value="mirko123">
    <?php if (isset($password)) echo "<p>".$password."</p>"?>

    <br><br>
    <button type="submit">Register</button>
</form>