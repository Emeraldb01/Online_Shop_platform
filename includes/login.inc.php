<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
    if(isset($_POST["submit"])){
        $uid = $_POST["uid"];
        $pwd = $_POST["pwd"];

        require_once 'dbh.inc.php';
        require_once 'function.inc.php';

        if(emptyInputLogin($uid, $pwd) !== false){
            header("location: ../index.php?error=emptyinput");
            exit();
        }

        loginUser($conn, $uid, $pwd);
    }
    else{
        header("location: ../index.php");
        exit();
    }