<?php

//echo file_get_contents("EE_login_error_page.html");


  $UserName= $_POST["username"];
  $UserPassword= $_POST["psw"];
  $b = $_POST["bus"];

 // check if the user inputed all the credentials
   if (empty($UserName) || empty($UserPassword) || empty($b)){
     echo file_get_contents("EE_login_error_page.html");
     echo "<p style='text-align:center;'>" . "1 or more fields was not entered" . "</p>";
     return;
   }
   else {

   $servername = "localhost";
   $username = "julian_heymans";
   $password = "cashmoneyAP1!";
   $db = "EagleEYE";

   // Create connection
   $conn = mysqli_connect($servername, $username, $password, $db);
   // Check connection
   if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
   }


     $sql = "SELECT DBname FROM DatabaseNames";

    $result = mysqli_query($conn,$sql) or die("bad query");

  while($row = mysqli_fetch_assoc($result)) {

       $dbName = $row['DBname'];

       if ($dbName == $b){
         //Valid Business Database
         //connect to Business Database
         $conn = mysqli_connect($servername, $username, $password, $b);
         // Check connection
         if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
         }

         //check USERNAME and PASSWORD
         $sql = "SELECT UserName FROM Employee";
        $result = mysqli_query($conn,$sql) or die("bad query");

        while($row = mysqli_fetch_assoc($result)){

          $UN = $row['UserName'];

          if($UN == $UserName){
            //valid USERNAME
            //check PASSWORD

            $sql = "SELECT Password FROM Employee WHERE UserName = '$UserName'";
            $result = mysqli_query($conn,$sql) or die("bad query");
            $row = mysqli_fetch_assoc($result);
            $PW = $row["Password"];

            if($PW == $UserPassword){
              //access granted show login screen
              echo file_get_contents("EE_home_page.html");






              return;
            }
            else{
              //access denied wrong PASSWORD
              echo file_get_contents("EE_login_error_page.html");
              echo "<p style='text-align:center;'>" . "incorrect password" . "</p>";
              return;
            }


        }
       }
       echo file_get_contents("EE_login_error_page.html");
       echo "<p style='text-align:center;'>" . "invalid username" . "</p>";
       return;

       }
   }
     //invalid business DATABASE
     echo file_get_contents("EE_login_error_page.html");
     echo "<p style='text-align:center;'>" . "invalid business database" . "</p>";
     return;





}

 ?>
