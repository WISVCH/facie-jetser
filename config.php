<?php
//	$mysqli = mysqli_connect("localhost.mysql", "root", "", "facie_jetser");
//	die(mysqli_error($mysqli));

    $servername = "127.0.0.1";
    $username = "facieUser";
    $password = "faciePassword";
    $database = "facie_jetser";
    $port     =  3306;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

?>