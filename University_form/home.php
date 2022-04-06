<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Contact Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <style>
      .error {color: #FF0000; font-size: large; float: center;}
      input[type=submit] {border: black;
        border-style: solid;
        font-size: x-large;
        font-weight: bold;
        height: 2.5rem;
        cursor: pointer;}
    </style>
    <body>
        <?php
          $nameErr = $codeErr = $emailErr = $yearErr = "";
          $name = $code = $email = $year = $depart = "";
          $flag = TRUE;

          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
              $nameErr = "Name is required";
              $flag = FALSE;
            } else {
              $name = test_input($_POST["name"]);
              if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Only letters and white space allowed"; 
              }
            }

              if (empty($_POST["code"])) {
                $codeErr = "Code is required";
                $flag = FALSE;
              } 

            if (empty($_POST["email"])) {
              $emailErr = "Email is required";
              $flag = FALSE;
            } else {
              $email = test_input($_POST["email"]);
              if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format"; 
              }
            }

            if (empty($_POST["year"])) {
              $yearErr = "Year is required";
              $flag = FALSE;
            } else {
              $year = test_input($_POST["year"]);
            }
          }

          function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
         }

        ?>
        <h1>Φόρμα Επικοινωνίας</h1>
        <div class="wrapper">
          <button id="createButton" class="createButton" onclick="document.location='createDB.php'">Δημιουργία ΒΔ</button>
          <img id="contactimage" src="contact.png">
          <button id="showButton" class="showButton" onclick="document.location='showDB.php'">Δείξε στοιχεία</button>
        </div>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
          <label>Ονοματεπώνυμο</label>
          <input type="text" name="name">
          <span class="error"> <?php echo $nameErr;?></span>

          <label>Αριθμός Μητρώου</label>
          <input type="text" name="code">
          <span class="error"> <?php echo $codeErr;?></span>

          <label>Email</label>
          <input type="text" name="email">
          <span class="error"> <?php echo $emailErr;?></span>

          <label>Τμήμα</label>
          <select id="department"; name='depart';>
            <option value="PS";>Πληροφοριακά συστήματα</option>
            <option value="ETY";>Επιστήμη και τεχνολογία υπολογιστών</option>
          </select>

          <label>Έτος φοίτησης</label>
          <label class="radio-inline">
          <input type="radio" id="first" name="year" value='1';>1ο έτος
          <input type="radio" id="second" name="year" value='2';>2ο έτος
          <input type="radio" id="third" name="year" value='3';>3ο έτος
          <input type="radio" id="fourth" name="year" value='4';>4ο έτος
          <span class="error"> <?php echo "<br>"; echo $yearErr; echo "<br>";?></span>

          <input type="submit" name="submit" value="Submit" > 
        </form>

        <?php 
          if (isset($_POST['submit'])&&$flag){
            $name=$_POST['name'];
            $code=$_POST['code'];
            $email=$_POST['email'];
            $depart=$_POST['depart'];
            $year=$_POST["year"];

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "contactDB";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO contacts (code, contact_name, email, department, current_year)
                VALUES ('$code', '$name', '$email','$depart','$year')";
                // use exec() because no results are returned
                $conn->exec($sql);
                echo "<script>alert('New record created');</script>";
                }
            catch(PDOException $e)
                {
                echo $sql . "<br>" . $e->getMessage();
                }

            $conn = null;
        
          }
          ?>
    </body>
</html>