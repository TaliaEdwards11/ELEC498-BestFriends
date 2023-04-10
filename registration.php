<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Registration Now</title>
	<link rel="stylesheet" href="static/content/site.css">

	<style>
    	.button {
   
    		background-color: #F2A2E8;
    		border: 2px solid black;
    		color: black;
    		padding: 5px 10px;
    		text-align: center;
    		display: inline-block;
    		font-size: 20px;
    		margin: 10px 30px;
    		cursor: pointer;o>
			}
	</style>
</head>
<body>
	 <div>
    	<img src="static/content/logo.png" style="width: 200px; height: 180px;">
    	<button1 class="button" 
            onclick="window.location.href = '/home.php';">
            Home
        </button1>
        <button2 class="button" 
            onclick="window.location.href = '/registration.php';">
            Registration
        </button2>
        <button3 class="button" 
            onclick="window.location.href = '/login.php';">
            Login
        </button3>
        <button4 class="button" 
            onclick="window.location.href = '/aboutUs.php';">
            About Us
        </button4>
    </div>
<?php 
    session_start();
    include("connection.php");
?>

<?php
	if (isset($_POST['registration'])){
		$FName = $_POST['FName'];
		$LName = $_POST['LName'];
		$username = $_POST['username'];
		$password = $_POST['password'];

		//check that this owner does not already exist 
        if(ctype_alnum($username) && strlen($username) > 0 && strlen($username) <=100 && $FName!="" &&  $LName!="" && $password !="" &&   ctype_alpha($FName) && ctype_alpha($LName)) {
                 
            $result = $db->query('select Username, Password, First_Name, Last_Name from Owner WHERE Username = "' . $username . '"');
            $count=0;
            // check if patient already exists 
            while ($row = $result->fetch()) {
                $count= $count+1;
            }
           
            //patient does not exist, proceed
            if($count ==0){
                // insert user in database 
                $insert1 = 'INSERT INTO Owner VALUES ("'.$username.'","'.$password.'","'.$LName.'", "'.$FName.'");';
                $input1 = $db->query($insert1);
                // if this was successful 
                if($input1){
                    // insert a patient with foreign key 
                    $_SESSION['firstName']   = $FName;
                    $_SESSION['lastName'] = $LName;
                    $_SESSION['username'] = $username;
                    $message = 'The owner '.$FName.' '.$LName.' has been registered.';
                     $good=1;
                }else{
                    $message = "Invalid Value";
                    $good=0;
                }
            }else{
                    $message = "An account with this username has already been created";
                    $good=0;  
                  }
        } else{
                $message = "Invalid INPUTS";
                $good=0;
        }
                
    }
?>
	
<div class="mainContainer" style="background-color:#F2A2E8;">
	<H1 style="margin-top: 2%; font-family: 'arial';">Registration</H1>
	<hr style="background-color: #FFFFFF; width:70%; margin:0 auto;"> 


    <?php 
        // if the user is already logged in redirect to the home page 
        if(isset($_SESSION['username']) && $_SESSION['username'] !='') {
            header('location:welcome.php');
        } 
    ?>


<form name="user_create" method="post" style="margin-top: 20px;">
		<table border="0" cellpadding="10" cellspacing="1" width="500" align="center">
			<tr class="tableHeader">
			     <td align="center" colspan="2" >Name</td>
			</tr>
			<tr>
			     <td>
			         <input type="text"   name="FName" placeholder="First Name Here" >
                 </td>
                 <td> <input type="text"  name="LName" placeholder="Last Name Here" ></td>
			</tr>
            <tr class="tableHeader">
			     <td align="center" colspan="2">Username</td>
			</tr>
			<tr>
			     <td colspan="2">
			         <input type="text"  name="username" >
                 </td>
            </tr>
            <tr class="tableHeader">
			     <td align="center" colspan="2">Password</td>
			</tr>
			<tr>
			     <td colspan="2">
			         <input type="password"  name="password" >
                </td>
			</tr>
            
			<tr >
			     <td align="center" colspan="2" class="tableBtn" > <input  class="blueBtn" type="submit" name="registration" value="Submit"></td>
			</tr>
		</table>
    </form>
    <?php 
            if($message!="" && $good== 0) {
                echo '<div class="fail" id="fail" style="width:70%; margin:0 auto; margin-top:50px;" >'.$message.'</div>';

            } elseif($message!="" && $good== 1){
                echo '<div class="good" id="good" style="width:70%; margin:0 auto; margin-top:50px;" >'.$message.'</div>';
            }
    ?>  
	</div>

</body>
</html>

