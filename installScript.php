<?php
    $conn = mysqli_connect($_POST["host"], $_POST["dbuser"], $_POST["dbpass"]);
    if(!$conn) {
        displayMsg("error", "Wrong passowrd for database");
        exit();
    } 
    else {
        displayMsg("success", "Connected");

        $sql = "CREATE DATABASE IF NOT EXISTS " . $_POST["dbname"];
        try {
            $conn->query($sql);
            displayMsg ("success", "Database created successfully");
        }
        catch(mysqli_sql_exeception $exception){
            displayMsg("error", "Database already exists");
        }
    }
    $conn->close();
    $conn = mysqli_connect($_POST["host"], $_POST["dbuser"], $_POST["dbpass"], $_POST["dbname"]);

    if(!$conn) {
        displayMsg("error", "Wrong passowrd for database");
        exit();
    } else {
        displayMsg("success", "Make Tables");
    
        include_once("../../prefabs/createTable.php");
        include_once("../../prefabs/dummyData.php");

        makeEnv();
    }
    $conn->close();
?>
