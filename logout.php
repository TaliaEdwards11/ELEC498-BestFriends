<?php
    session_start();
    // remove saved data and send user to login page 
    $_SESSION['username'] = '';
    $_SESSION['firstName'] = '';
    $_SESSION['lastName'] = '';
    if(empty($_SESSION['username'])){ 
        header("location: home.php");
    }
    
?>