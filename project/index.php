<?php 
    require_once("bootstrap.php");
    if(!isset($_SESSION["id"])){
        header("location: login.php");
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <title>Inspiration Hunter</title>
</head>
<body>
    <h1>Inspiration Hunter</h1>
    <p>Dit onderdeel wordt later nog aangevuld.</p>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>