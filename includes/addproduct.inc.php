<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
    
    if(isset($_POST["submit"])){
        $name = $_POST["name"];
        $number = $_POST["number"];
        $des = $_POST["description"];
        $price = $_POST["price"];
        $file = $_FILES['file'];

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        require_once 'dbh.inc.php';
        require_once 'function.inc.php';

        if(emptyInputAddItem($name, $number) !== false){
            header("location: ..product.php?error=emptyinput");
            exit();
        }
        if(ItemNameExist($conn, $name) !== false){
            header("location: ../product.php?error=itemnameTaken");
            exit();
        }

        // upload picture

        $fileExt = explode('.', $fileName); // explode the 'fileName' by '.' -> xxx and .jpg
        $AllLowerExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');
        
        if(in_array($AllLowerExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 10000000){;
                    $fileDestination = '../images/uploads/'.$name.".".$AllLowerExt;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    echo $fileDestination;
                    //header("location: ../product.php?uploadsucceed");
                }
                else{
                    echo "File size must be under 500MB.";
                    header("location: ../index.php?error=filesize");
                    exit();
                }
            }
            else{
                echo "There has been an error, pleas retry.";
                header("location: ../index.php?error=error");
                exit();
            }
        }
        else{
            echo "Please upload file of jpg, jpeg, png, or pdf only.";
            echo $AllLowerExt;
            //header("location: ../index.php?error=filetype");
            exit();
        }
        // finish upload picture
        $image = 'images/uploads/'.$name.".".$AllLowerExt;

        addItem($conn, $name, $number, $des, $image, $price);
        header("location: ../product.php");
    }