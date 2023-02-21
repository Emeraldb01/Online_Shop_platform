<?php
    /*------Sign-Up--------*/
    function emptyInputSignup($name, $email, $uid, $pwd, $pwdrepeat){
        $result;
        if(empty($name) || empty($email)|| empty($uid)|| empty($pwd)|| empty($pwdrepeat)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
    function invalidUid($uid){
        $result;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $uid)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
    function invalidEmail($email){
        $result;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
           $result = true; 
        }
        else{
            $result = false;
        }
        return $result;
    }
    function pwdMatch($pwd, $pwdrepeat){
        $result;
        if ($pwd !== $pwdrepeat){
           $result = true; 
        }
        else{
            $result = false;
        }
        return $result;
    }
    function uidExist($conn, $uid, $email){
        $result;
        $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
        $statement = mysqli_stmt_init($conn); // using prepare statement, to prevent sql injection
        if (!mysqli_stmt_prepare($statement, $sql)){
            header("location: ../signin.php?error=statementFailed");
            exit();
        }

        mysqli_stmt_bind_param($statement, "ss", $uid, $email); //ss = string string for the two ? ?
        mysqli_stmt_execute($statement);

        $resultData = mysqli_stmt_get_result($statement);
        if ($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        else{
            $result = false;
            return $result;
        }

        mysqli_stmt_close($statement);
    }
    function createUser($conn, $name, $email, $uid, $pwd, $bday){
        $result;
        $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd, usersBDay) VALUES(?, ?, ?, ?, ?);";
        $statement = mysqli_stmt_init($conn); // using prepare statement, to prevent sql injection
        if (!mysqli_stmt_prepare($statement, $sql)){
            header("location: ../signin.php?error=statementFailed");
            exit();
        }

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        $Bday = date('Y-m-d', strtotime($bday));
        echo $Bday;

        mysqli_stmt_bind_param($statement, "sssss", $name, $email, $uid, $hashedPwd, $Bday); //ss = string string for the two ? ?
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);

        header("location: ../signin.php?error=none");
        exit();
    }

    /*------Login--------*/
    function emptyInputLogin($uid, $pwd){
        $result;
        if(empty($uid)|| empty($pwd)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
    function loginUser($conn, $uid, $pwd){
        $uidExist = uidExist($conn, $uid, $uid);
        
        if($uidExist === false){
            header("location: ../signin.php?error=wronguid");
            exit();
        }

        $pwdHashed = $uidExist["usersPwd"];
        $checkPwd = password_verify($pwd, $pwdHashed);

        if($checkPwd === false){
            header("locatiom: ../signin.php?error=wrongpwd");
            exit();
        }
        else if($checkPwd === true){
            // session
            session_start();
            $_SESSION["usersId"] = $uidExist["usersId"]; 
            $_SESSION["Uid"] = $uidExist["usersUid"]; 
            $_SESSION["Privilege"] = $uidExist["Privilege"];
            $_SESSION["bday"] = $uidExist["usersBDay"];

            $sql = "DROP TABLE IF EXISTS cart;";
            $result = mysqli_query($conn, $sql);
            

            $sql = "CREATE TABLE cart (
                itemId int(11),
                itemCount int(11));";
            $result = mysqli_query($conn, $sql);
            
            header("location: ../index.php");
            exit();
        }
    }

    /*------Add item-------*/
    function emptyInputAddItem($name, $number){
        $result;
        if(empty($name) || empty($number)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
    function ItemNameExist($conn, $name){
        $result;
        $sql = "SELECT * FROM product WHERE itemName = ?;";
        $statement = mysqli_stmt_init($conn); // using prepare statement, to prevent sql injection
        if (!mysqli_stmt_prepare($statement, $sql)){
            header("location: ../product.php?error=statementFailed");
            exit();
        }

        mysqli_stmt_bind_param($statement, "s", $name); //ss = string string for the two ? ?
        mysqli_stmt_execute($statement);

        $resultData = mysqli_stmt_get_result($statement);
        if ($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }
        else{
            $result = false;
            return $result;
        }

        mysqli_stmt_close($statement);
    }

    function addItem($conn, $name, $number, $des, $image, $price){
        $result;
        $sql = "INSERT INTO product (itemName, number, description, itemImage, price) VALUES(?, ?, ?, ?, ?);";
        $statement = mysqli_stmt_init($conn); // using prepare statement, to prevent sql injection
        if (!mysqli_stmt_prepare($statement, $sql)){
            header("location: ../product.php?error=statementFailed");
            exit();
        }

        mysqli_stmt_bind_param($statement, "sssss", $name, $number, $des, $image, $price); //ss = string string for the two ? ?
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);

        header("location: ../product.php?error=none");
        exit();
    }
    function displayItem($conn){
        require_once 'includes/dbh.inc.php';

        $sql = "SELECT * FROM product;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck){
            echo '<div class="product-grid">';
            while($row = mysqli_fetch_assoc($result)){
                $imgpath = $row['itemImage'];
                $imgpath = str_replace(' ', '%20', $imgpath); 
                echo '  <div class="product-card">';
                echo '      <div class="product-info">';
                echo '          <p class="pname">'.$row['itemName'].'</p>'; 
                echo '          <img class="img-product" src='.$imgpath.' style="max-width:50%; max-height:50%">';
                echo '          <p class="pname">'.$row['price'].' $</p>';
                echo '          <p class="pname">'.$row['description'].'</p>';
                echo '          <form class="signup-form" action="includes/add2cart.inc.php" method="post" enctype="multipart/form-data">';
                //echo '    <h2>Add to cart</h2>';
                echo '              <input type="number" name="number" placeholder="Amount of items" min="1" max="'.$row['number'].'">';
                echo '              <input type="hidden" name="itemId" value="'.$row['itemId'].'" />';
                echo '              <button type="submit" name="submit">Add to cart</button>';
                echo '          </form>';
                if($row['number'] <= 0){
                    echo '<p>SOLD OUT</p>';
                }
                echo '      </div>';
                echo '  </div>';
              }
              echo '  </div>';
            return true;
        }
        else{
            return false;
        }
    }
    function itemInCart($conn){
        error_reporting(E_ALL); 
        ini_set('display_errors', 1);
        require_once 'includes/dbh.inc.php';

        $sql = "SELECT * FROM cart;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        $totalPrice = 0;

        if($resultCheck){
            echo '<div class="product-grid">';
            while($row = mysqli_fetch_assoc($result)){
                $itemCount = $row['itemCount'];
                $itemId = $row['itemId'];
                $sql = "SELECT * FROM product WHERE product.itemId = ".$itemId.";";
                $productResult = mysqli_query($conn, $sql);
                $productRow = mysqli_fetch_assoc($productResult);
                $totalPrice += $itemCount * $productRow['price'];
                $imgpath = $productRow['itemImage'];
                $imgpath = str_replace(' ', '%20', $imgpath); 

                echo '<div class="product-card">';
                echo '  <div class="product-info">';
                echo '      <p class="pname">'.$productRow['itemName'].'</p>'; 
                echo '      <p class="pname">'.$productRow['price'].' $</p>';
                echo '      <img class="img-product" src='.$imgpath.' style="max-width:50%; max-height:50%">';       
                echo '      <p class="pname">'.$itemCount.' </p>';
                echo '      <form class="signup-form" action="includes/add2cart.inc.php" method="post" enctype="multipart/form-data">';
                //echo '        <h2>Add to cart</h2>';
                echo '          <input type="number" name="number" placeholder="Amount of items" min="1" max="'.$productRow['number'].'">';
                echo '          <input type="hidden" name="itemId" value="'.$itemId.'" />';
                echo '          <button type="submit" name="submit">Add</button>';
                echo '      </form>';
                echo '  </div>';
                echo '</div>';
            }
            echo '</div>';
            echo '<p class="cart">Total price:'.$totalPrice.'</p>';
            echo '<form class="signup-form" action="includes/checkout.inc.php" method="post" enctype="multipart/form-data">';
            echo '    <button type="submit" name="submit">Checkout</button>';
            echo '</form>';
            return true;
        }
        else{
            return false;
        }
    }
    function itemInOrder($conn){
        error_reporting(E_ALL); 
        ini_set('display_errors', 1);
        require_once 'includes/dbh.inc.php';

        $sql = "SELECT * FROM orders;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        $totalPrice = 0;

        if($resultCheck){
            echo '<div class="product-grid">';
            while($row = mysqli_fetch_assoc($result)){
                $itemCount = $row['itemCount'];
                $itemId = $row['itemId'];
                $sql = "SELECT * FROM product WHERE product.itemId = ".$itemId.";";
                $productResult = mysqli_query($conn, $sql);
                $productRow = mysqli_fetch_assoc($productResult);
                $totalPrice += $itemCount * $productRow['price'];

                echo '<div class="product-card">';
                echo '  <div class="product-info">';
                echo '      <p class="pname">Product ID: '.$itemId.'</p>'; 
                echo '      <p class="pname">'.$productRow['itemName'].'</p>'; 
                echo '      <p class="pname">'.$productRow['price'].' $</p>';
                echo '      <p class="pname">Product count: '.$itemCount.' </p>';
                echo '  </div>';
                echo '</div>';
            }
            echo '</div>';
            echo '<p class="cart">Total price: '.$totalPrice.'</p>';
            echo '<form class="signup-form" action="includes/clearorder.inc.php" method="post" enctype="multipart/form-data">';
            echo '    <button type="submit" name="submit">Clear</button>';
            echo '</form>';
            return true;
        }
        else{
            return false;
        }
    }