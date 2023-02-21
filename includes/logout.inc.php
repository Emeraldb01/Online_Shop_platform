<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', 1);

    require_once 'dbh.inc.php';

    $sql = "SELECT * FROM cart";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck){
        while($row = mysqli_fetch_assoc($result)){
            $sql = "UPDATE product SET number = number + ? WHERE itemId = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $row['itemCount'], $row['itemId']);
            mysqli_stmt_execute($stmt);
        }
    }

    $sql = "DROP TABLE IF EXISTS cart;";
    $result = mysqli_query($conn, $sql);

    session_start();
    session_unset();
    session_destroy();
    
    header("location: ../signin.php");
    exit();