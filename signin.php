<?php
    include_once 'header.php';
?>
<?php
if($_GET["error"] == "notlogin"){
    echo "<p class=\"cart\">Please sign in first</p>";
} 
?>
<section class="signup-form">
    <h2>Login</h2>
    <form class="enterbar" action="includes/login.inc.php" method="post">
        <input type="text" name="uid" placeholder="User name/Email">
        <input type="password" name="pwd" placeholder="Password">
        <button type="submit" name="submit">Login</button>
    </form>
    <?php
        if(isset($_GET["error"])){
            if($_GET["error"] == "emptyinput"){
                echo "<p>Field cannot be left empty</p>";
            } 
            else if($_GET["error"] == "wronguid"){
                echo "<p>Username or email not found</p>";
            }
            else if($_GET["error"] == "wrongpwd"){
                echo "<p>Wrong password</p>";
            }
        }
        
        // nothing in url -> pass as _POST, ...=... in the end of url -> pass as _GET
    ?>
</section>
<section class="signup-form">
    <h2>Sign up</h2>
    <form class="enterbar" action="includes/signup.inc.php" method="post">
        <input type="text" name="name" placeholder="Full name">
        <input type="text" name="email" placeholder="Email">
        <input type="text" name="uid" placeholder="User name">
        <input type="date" name="bday" placeholder="Birthday">
        <input type="password" name="pwd" placeholder="Password">
        <input type="password" name="pwdrepeat" placeholder="Repeat password">
        <button type="submit" name="submit">Sign up</button>
    </form>
    <?php
        if(isset($_GET["error"])){
            if($_GET["error"] == "emptyinput"){
                echo "<p>Field cannot be left empty</p>";
            } 
            else if($_GET["error"] == "invalidUid"){
                echo "<p>Username can only contain letters and numbers</p>";
            }
            else if($_GET["error"] == "invalidEmail"){
                echo "<p>The email address is invalid</p>";
            }
            else if($_GET["error"] == "pwdMismatch"){
                echo "<p>Password and repeat do not match</p>";
            }
            else if($_GET["error"] == "usernameTaken"){
                echo "<p>Username or email taken</p>";
            }
            else if($_GET["error"] == "none"){
                echo "<p>Signed up successful</p>";
            }
        }
        
        // nothing in url -> pass as _POST, ...=... in the end of url -> pass as _GET
    ?>
</section>
</body>
</html>