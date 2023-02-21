<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<section>
    <nav>
        <div class="nav-links" id="navLinks">
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="product.php">PRODUCT</a></li>
                <?php
                    if(isset($_SESSION["usersId"])){
                        echo '<li><a href="checkout.php">CHECK OUT</a></li>';
                        if($_SESSION['Privilege'] == 1){
                            echo '<li><a href="checkorder.php">CHECK ORDER</a></li>';
                        }
                        echo '<li><a href="includes/logout.inc.php">LOG OUT</a></li>';
                    }
                    else{
                        echo '<li><a href="signin.php">LOGIN</a></li>';
                    }
                ?>
            </ul>
        </div>
    </nav>
</section>