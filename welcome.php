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

<?php 
    session_start();
    // check if a owner is logged in 
    // if they are already logged in redirect to home page 
    if(!(isset($_SESSION['username'])) || $_SESSION['username'] =='') {
        header('location:login.php');
    } 
?>

<body>
    <div>
    	<img src="static/content/logo.png" style="width: 200px; height: 180px;">
        <a href="logout.php">
        <button1 class="button">
            Logout
        </button1>
    </a>
    </div>
    <div class="mainContainer" style="background-color: #F2A2E8;">
    <?php
    if($_SESSION['username']!='') {
            echo '<h1 style="margin-top:30px;">Welcome '.$_SESSION['firstName']. ' ' .$_SESSION['lastName'].'</h1>';
        }
    ?>
    <hr style="background-color: #FFFFFF; width:50%; margin:0 auto;"> 
    <!-- Adding link to the button on the onclick event -->
    <button2 class="button" 
    onclick="window.location.href = '/dogRegister.php';">
        Pet Information
    </button2>
    <button3 class="button" 
    onclick="window.location.href = '/monitoring.php';">
        Monitoring
    </button3>
    <p1 style="margin-top: 1%; font-family:'arial';">
        <br>Welcome! Head to the different tabs to add your pet information, order a harness and start the monitoring process!
        <br>
    </p1>

</body>

</html>