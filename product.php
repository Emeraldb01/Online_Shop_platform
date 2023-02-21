<?php
    include_once 'header.php';
    session_start();
?>
<section>
    <?php
        error_reporting(E_ALL); 
        ini_set('display_errors', 1);
        require_once 'includes/dbh.inc.php';
        require_once 'includes/function.inc.php';
        displayItem($conn);
        if(isset($_SESSION["usersId"]) && $_SESSION["Privilege"] == "1"){
    ?>
        <form class="signup-form" action="includes/addproduct.inc.php" method="post" enctype="multipart/form-data">
            <h2>Add item</h2>
            <input type="text" name="name" placeholder="Item name">
            <input type="number" name="number" placeholder="Amount of items">
            <input type="text" name="description" placeholder="Item description">
            <input type="number" name="price" placeholder="Price">
            <input type="file" name="file">
            <button type="submit" name="submit">Add</button>
        </form>
    <?php } 
    ?>
</section>
</body>
</html>