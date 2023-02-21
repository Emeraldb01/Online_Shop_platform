<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
    /*
    require_once 'includes/dbh.inc.php';
    require_once 'includes/function.inc.php';

    $sql = "SELECT * FROM product;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck){
        while ($row = mysqli_fetch_assoc($result)){
            echo $row['itemName'];
        }
    }*/
    require_once 'includes/dbh.inc.php';
    require_once 'includes/function.inc.php';
    
    displayItem($conn);
