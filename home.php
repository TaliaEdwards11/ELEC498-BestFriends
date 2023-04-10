<!doctype html>
<html lang="en">

<head>
    
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="static/content/site.css">

    <style>
    	.button {
    		background-color: white;
    		border: 2px solid black;
    		color: black;
    		padding: 5px 10px;
    		text-align: center;
    		display: inline-block;
    		font-size: 20px;
    		margin: 10px 30px;
    		cursor: pointer;
			}
	</style>
</head>
<!-- <?php 
    session_start();
    // check if a owner is logged in 
    // if they are already logged in redirect to home page 
    if(isset($_SESSION['username']) == "") {
        header('location:login.php');
    } 
?>
 --><body>
    <div>
    	<img src="static/content/logo.png" style="width: 200px; height: 180px;">
    </div>
    <div class="mainContainer" style="background-color: #F2A2E8;">
    <H1 style="margin-top: 1%; font-family: 'arial';">Welcome to Best Friends</H1>
    <hr style="background-color: #FFFFFF; width:50%; margin:0 auto;"> 
    <!-- Adding link to the button on the onclick event -->
    <button1 class="button" 
    onclick="window.location.href = '/registration.php';">
        Register Now!
    </button1>
    <button2 class="button" 
    onclick="window.location.href = '/login.php';">
        Login
    </button2>
    <button3 class="button" 
    onclick="window.location.href = '/aboutUs.php';">
        About Us
    </button3>
    <p1 style="margin-top: 1%; font-family:'arial';">
        <br>The smart harness is just what you need for your fury friend! The Best Friends' harness is designed to protect and monitor your dog in multiple different ways. It includes tracking their heart rate, barking abnormalities and more! 
        <br>
        <br>If you think Best Friends is the perfect product for your dog, register with us today!
        <br>
    </p1>

</body>

</html>