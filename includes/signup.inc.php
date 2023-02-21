<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

    if(isset($_POST["submit"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $uid = $_POST["uid"];
        $bday = $_POST["bday"];
        $pwd = $_POST["pwd"];
        $pwdrepeat = $_POST["pwdrepeat"];

        require_once 'dbh.inc.php';
        require_once 'function.inc.php';
        
        if(emptyInputSignup($name, $email, $uid, $pwd, $pwdrepeat) !== false){
            header("location: ../signin.php?error=emptyinput");
            exit();
        }
        if(invalidUid($uid) !== false){
            header("location: ../signin.php?error=invalidUid");
            exit();
        }
        if(invalidEmail($email) !== false){
            header("location: ../signin.php?error=invalidEmail");
            exit();
        }
        if(pwdMatch($pwd, $pwdrepeat) !== false){
            header("location: ../signin.php?error=pwdMismatch");
            exit();
        }
        if(uidExist($conn, $uid, $email) !== false){
            header("location: ../signin.php?error=usernameTaken");
            exit();
        }

        createUser($conn, $name, $email, $uid, $pwd, $bday);
        header("location: ../signin.php");
    }
    else{
        header("location: ../signin.php");
        exit();
    }