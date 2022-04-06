<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <title>Create DB</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
<style>
     body{
        background-color: rgb(94, 114, 143);
    }
</style>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE contactDB";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Database created successfully<br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
    
    
try {
    $conn = new PDO("mysql:host=$servername;dbname=contactDB", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE TABLE Contacts (
        code VARCHAR(8) PRIMARY KEY, 
        contact_name VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        department VARCHAR(30),
        current_year INT(1)
        )";
    
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table Contacts created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
    

$conn = null;
?> 
<br>
<button id="returnButton" class="returnButton" onclick="document.location='home.php'">Επιστροφή</button>
</body>
</html
