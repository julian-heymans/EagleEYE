<?php


    $Fname= $_POST["firstName"];
    $Lname= $_POST["lastName"];
    $Email= $_POST["email"];
    $UserName= $_POST["username"];
    $UserPassword= $_POST["psw"];
    $pos = $_POST["pos"];
    $business = $_POST["bus"];


    // check if the user inputed all the credentials
      if (empty($UserName) || empty($UserPassword) || empty($Fname) || empty($Lname)|| empty($Email)|| empty($pos)|| empty($business) ){
        echo file_get_contents("EE_login_error_page.html");
        echo "<p style='text-align:center;'>" . "1 or more fields was not entered" . "</p>";
        return;
      }
      else {

    $servername = "localhost";
    $username = "julian_heymans";
    $password = "cashmoneyAP1!";

    $EE = "EagleEYE";

    //check if database entered actually exists

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $EE);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT DBname FROM DatabaseNames";

    $result = mysqli_query($conn,$sql) or die("bad query");

         while($row = mysqli_fetch_assoc($result)) {

       $dbName = $row['DBname'];

       if ($dbName == $business){
         //Valid Business Database

         // Create connection
         $conn = mysqli_connect($servername, $username, $password, $business);
         // Check connection
         if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
         }


         $sql = "SELECT UserName FROM Employee";

         $result = mysqli_query($conn,$sql) or die("bad query");

            while($row = mysqli_fetch_assoc($result)){

                 $UN = $row['UserName'];

                 if($UN == $UserName){
                    //username already exists
                    echo file_get_contents("EE_login_error_page.html");
                    echo "<p style='text-align:center;'>" . "The Username entered already exists" . "</p>";
                    return;
                 }
             }
            //username is valid
            //all conditions met, create new Employee
             $sql = "INSERT INTO Employee (FirstName, LastName, Email, UserName, Password,
             Position)
             VALUES ('$Fname', '$Lname', '$Email', '$UserName', '$UserPassword', '$pos')";

             if ($conn->query($sql) === TRUE) {
               echo file_get_contents("EE_new_emp_creation_success_page.html");
                // echo    "New record created successfully";
             } else {
               echo file_get_contents("EE_login_error_page.html");
                 echo "SQL Error";
             }


             $conn -> close();
             return;



       }
   }
   echo file_get_contents("EE_login_error_page.html");
   echo "<p style='text-align:center;'>" . "Invalid Business Database" . "</p>";
   return;
}

 ?>
