<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <title>Show DB</title>
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
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Code</th><th>Name</th><th>Email</th><th>Department</th><th>Current_Year</th></tr>";

class TableRows extends RecursiveIteratorIterator {
     function __construct($it) {
         parent::__construct($it, self::LEAVES_ONLY);
     }

     function current() {
         return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
     }

     function beginChildren() {
         echo "<tr>";
     }

     function endChildren() {
         echo "</tr>" . "\n";
     }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contactdb";

try {
     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $stmt = $conn->prepare("SELECT code, contact_name, email, department, current_year FROM contacts");
     $stmt->execute();

     // set the resulting array to associative
     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

     foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
         echo $v;
     }
}
catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?> 

<br>
<button id="returnButton" class="returnButton" onclick="document.location='home.php'">Επιστροφή</button>

</body>
</html