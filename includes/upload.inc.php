<?php
if(isset($_POST["submit"])){
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName); // explode the 'fileName' by '.' -> xxx and .jpg
    $AllLowerExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');
    
    if(in_array($AllLowerExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 10000000){
                $fileNameUpload = uniqid('', true).".".$AllLowerExt;
                $fileDestination = '../images/uploads/'.$fileNameUpload;
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
        header("location: ../index.php?error=filetype");
        exit();
    }

}