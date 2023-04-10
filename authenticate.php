    
<?php 
    session_start();
    include("connection.php");
     
    //log in the user and make sure the user is correct
    if(isset($_POST['login'])){
        $username=  $_POST['username'];
        $password=  $_POST['password'];
        if(ctype_alnum($username) && strlen($username) > 0 && strlen($username) <= 100){
       
            $result = $db->query('select Username, Password, First_Name, Last_Name from Owner WHERE Username = "' . $username . '" and Password = "' . $password . '"');
            $count=0;
            while ($row = $result->fetch()) {
                // patient found, save info
	            $_SESSION['username']   = $row['Username'];
              $_SESSION['firstName']   = $row['First_Name'];
              $_SESSION['lastName']   = $row['Last_Name'];
               $count= $count+1;
    
            }
            // no issues with input but the patient does not exist
            if($count == 0){
                $message= "This owner does  ".$username."   " .$password. "  not exist or the wrong password has been entered. Do you want to <a href='/registration.php'>register a user </a>?</h4>";
   
            } 
            // if the patient exists redirect the page to the home page until logout is clicked 
            else{     
                header('location:welcome.php');
            }
        }
       else{
           $message= "Incorrect Input";
            
       }
    }
       
?>