<?php
    require_once 'dbh.inc.php';

    error_reporting(E_ALL); 
    ini_set('display_errors', 1);

    $sql = "SELECT * FROM cart;";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $itemCount = $row['itemCount'];
            $itemId = $row['itemId'];
            $sql = "SELECT * FROM orders WHERE itemId = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $itemId);
            mysqli_stmt_execute($stmt);
            $matchResult = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($matchResult) > 0){
                $sql = "UPDATE orders SET itemCount = itemCount + ? WHERE itemId = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ii", $itemCount, $itemId);
                mysqli_stmt_execute($stmt);
            }
            else{
                $sql = "INSERT INTO orders (itemId, itemCount) VALUE (?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ii", $itemId, $itemCount);
                mysqli_stmt_execute($stmt);
            }
        }

    }

    $sql = "TRUNCATE TABLE cart;";
    $result = mysqli_query($conn, $sql);

    header("location: ../index.php");