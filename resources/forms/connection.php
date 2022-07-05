<?php

    $host ="127.0.0.1";
    $user_name ="root";
    $db_name = "todo";
    $password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $user_name, $password);

    //set pdo error mode
    $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn ->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS"));

    }catch (PDOException $exception) {
        die("Could not connect to the database :" . $exception->getMessage());
    }


