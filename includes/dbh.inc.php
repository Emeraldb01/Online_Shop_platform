<?php
    $servername = "localhost";
    $username = "root";
    $password = "wu6ai6vu1227";
    $dbname = "bookstore";

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        print "failed";
        die("Connection failed: " . $conn->connect_error);
    } 
