<?php
    require_once 'dbh.inc.php';

    error_reporting(E_ALL); 
    ini_set('display_errors', 1);

    $sql = "TRUNCATE TABLE orders;";
    $result = mysqli_query($conn, $sql);

    header("location: ../index.php");