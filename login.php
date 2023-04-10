<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Login</title>
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
    // check if a owner is logged in 
    // if they are already logged in redirect to home page 
    if(isset($_SESSION['username']) && $_SESSION['username'] !='') {
        header('location:welcome.php');
    } 
?>
    
<?php 
    // checks if submitted pw is correct
    // saves the session data 
    include("authenticate.php");
?>

<header>
	<div class="mainContainer" style="background-color: #F2A2E8;">
	    <H1 style="margin-top: 2%; font-family: 'arial';">Login</H1>
	    <hr style="background-color: #FFFFFF; width:70%; margin:0 auto;"> 
	        
	        
	    <form name="login" method="post" style="margin-top: 0px;">
		
			<table border="0" cellpadding="10" cellspacing="1" width="500" align="center">
				<tr class="tableHeader">
	                <td align="center" colspan="2">Enter Username</td>
				</tr>
				<tr>
	                <td>
	                    <input type="text" id="username"  name="username" placeholder="">
	                </td>
				</tr>
				<tr class="tableHeader">
	                <td align="center" colspan="2">Enter Password</td>
				</tr>
				<tr>
	                <td>
	                    <input type="password" id="password"  name="password" placeholder="">
	                </td>
				</tr>
				<tr>
	                <td align="center" colspan="2" class="tableBtn" > 
	                    <input  class="blueBtn" type="submit" name="login" value="Submit">
	                </td>
				</tr>
			</table>
	    </form>    
		<?php 
        // display error messages to inform the user of issues 
        if($message!="") {
            echo '<div class="fail" id="fail" style="width:70%; margin:0 auto; margin-top:50px;" >'.$message.'</div>';
        } 
    ?>
	</div>
</header>
</body>
</html>

