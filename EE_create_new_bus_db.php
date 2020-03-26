<?php



    $servername = "localhost";
    $username = "julian_heymans";
    $password = "cashmoneyAP1!";

    $bus = $_POST["DBname"];

    $Fname= $_POST["firstName"];
    $Lname= $_POST["lastName"];
    $Email= $_POST["email"];
    $UserName= $_POST["username"];
    $UserPassword= $_POST["psw"];

    $pos="Business Manager";


    // check if the user inputed all the credentials
      if (empty($UserName) || empty($UserPassword) || empty($Fname) || empty($Lname)|| empty($Email)|| empty($pos)){
        echo file_get_contents("EE_login_error_page.html");
        echo "<p style='text-align:center;'>" . "1 or more fields was not entered" . "</p>";
        return;
      }
      else {

         //check if the database being created already exists in EagleEYE DATABASE
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

           if ($dbName == $bus){
             //Business DATABASE already exists
             echo file_get_contents("EE_login_error_page.html");
             echo "<p style='text-align:center;'>" . "Business Database " . $bus.  " already exists" . "</p>";
             return;
           }
         }
         //Valid Business database, $bus does not yet exist
         // Create connection
        echo file_get_contents("EE_creation_success_page.html");

         $conn = mysqli_connect($servername, $username, $password);
         // Check connection
         if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
         }


         $sql = "CREATE DATABASE $bus";

         if ($conn->query($sql) === TRUE) {
            // echo    "New database created successfully";
         } else {
             echo "Error: " . $sql . "<br>" . $conn->error;
         }



         // Create connection
         $conn = mysqli_connect($servername, $username, $password, $bus);
         // Check connection
         if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
         }

           //create Employee Table
         $sql = "CREATE TABLE Employee (FirstName VARCHAR(40) NOT NULL,
              LastName VARCHAR(40) NOT NULL,
              Email VARCHAR(40) NOT NULL,
              UserName VARCHAR(40) NOT NULL,
              Password VARCHAR(40) NOT NULL,
              Position VARCHAR(40) NOT NULL
              )";

         if ($conn->query($sql) === TRUE) {
             //echo    "New table created successfully";
         } else {
             echo "Error: " . $sql . "<br>" . $conn->error;
         }


         //create MainObjectives TABLE
          $sql = "CREATE TABLE MainObjectives (
            Title VARCHAR (40) NOT NULL,
            Content VARCHAR (40) NOT NULL,
            Priority VARCHAR (40) NOT NULL  )";

            if ($conn->query($sql) === TRUE) {
                //echo    "New table created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            //create DepartObjectives TABLE
             $sql = "CREATE TABLE DepartObjectives (
               Title VARCHAR (40) NOT NULL,
               Content VARCHAR (40) NOT NULL,
               Priority VARCHAR (40) NOT NULL  )";

               if ($conn->query($sql) === TRUE) {
                   //echo    "New table created successfully";
               } else {
                   echo "Error: " . $sql . "<br>" . $conn->error;
               }

               //create PersonalObjectives TABLE
                $sql = "CREATE TABLE PersonalObjectives (
                  Title VARCHAR (40) NOT NULL,
                  Content VARCHAR (40) NOT NULL,
                  Priority VARCHAR (40) NOT NULL  )";

                  if ($conn->query($sql) === TRUE) {
                      //echo    "New table created successfully";
                  } else {
                      echo "Error: " . $sql . "<br>" . $conn->error;
                  }




        $sql = "INSERT INTO Employee (FirstName, LastName, Email, UserName, Password,
        Position)
        VALUES ('$Fname', '$Lname', '$Email', '$UserName', '$UserPassword', '$pos')";

        if ($conn->query($sql) === TRUE) {
          //  echo    "New table created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, "EagleEYE");
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

         $sql = "INSERT INTO DatabaseNames (DBname) VALUES ('$bus')";

         if ($conn->query($sql) === TRUE) {
          //   echo    "added to EagleEYE successfully";
         } else {
             echo "Error: " . $sql . "<br>" . $conn->error;
         }




         $conn -> close();







      }








 ?>
