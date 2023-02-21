<?php
session_start();

error_reporting(E_ALL); 
ini_set('display_errors', 1);

if(isset($_POST["submit"])){
    if(isset($_SESSION["usersId"])){
        $number = $_POST["number"];
        $itemId = $_POST["itemId"];

        require_once 'dbh.inc.php';
        require_once 'function.inc.php';

        $sql = "UPDATE product SET number = number - ? WHERE itemId = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $number, $itemId);
        mysqli_stmt_execute($stmt);

        $sql = "SELECT * FROM cart WHERE itemId = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $itemId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) > 0){
            $sql = "UPDATE cart SET itemCount = itemCount + ? WHERE itemId = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $number, $itemId);
            mysqli_stmt_execute($stmt);
            header("location: ../product.php?addsucceed");
        }
        else{
            $sql = "INSERT INTO cart (itemId, itemCount) VALUE (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $itemId, $number);
            mysqli_stmt_execute($stmt);
            header("location: ../product.php?addsucceed");
        }
    }
    else{
        header("location: ../signin.php?error=notlogin");
        exit();
    }

    
}
