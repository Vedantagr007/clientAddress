<?php

    $server = 'localhost';
    $username = 'root';
    $password = 'root';
    $db = 'client_addres_book';

    // create connection
    $conn = mysqli_connect($server, $username, $password, $db);

    if(!$conn) die("Connection failed: ".mysqli_connect_error());
?>