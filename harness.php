<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dog Registration Form</title>
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
            onclick="window.location.href = '/welcome.php';">
            Home
        </button1>
        <button2 class="button" 
            onclick="window.location.href = '/dogRegister.php';">
            Pet Registration 
        </button2>
        <button3 class="button" 
            onclick="window.location.href = '/harness.php';">
            Harness
        </button3>
        <button3 class="button" 
            onclick="window.location.href = '/monitoring.php';">
            Monitoring
        </button3>
    </div>

<?php
  session_start();
  include("connection.php");
?>

<?php
  if (isset($_POST['harness'])){
    $name = $_POST[''];
    $type = $_POST['type'];
    $size = $_POST['size'];
    $age = $_POST['age']; 
    $weight = $_POST['weight'];
    $sensitivity = $_POST['sensitivity'];

    //check if pet exists
    $valid_types = array('Bulldogs', 'Pug', 'Pekingese', 'Saint Bernards', 'Great Danes', 'Mastiffs', 'Boxers', 'Doberman Pinschers', 'Other');

    $valid_size = array('Extra Small','Small', 'Medium', 'Large', 'Extra Large');

    if (ctype_alpha($name) && in_array($type, $valid_types) && in_array($size, $valid_size) && ctype_digit($age) && ctype_digit($weight) && ctype_digit($sensitivity)){

      $result = $db->query('select Name, Dog_Type, Dog_Size, Age, Weight, Sensitivity, Owner_Username from Dog WHERE Name = "' . $name . '" and  Owner_Username = "'.$_SESSION['username'].'"');
            $count=0;
            // check if pet already exists 
            while ($row = $result->fetch()) {
                $count= $count+1;
            }
           
            //pet does not exist, proceed
            if($count ==0){
                // insert user in database 
                $insert1 = 'INSERT INTO Dog VALUES ("'.$name.'","'.$type.'","'.$size.'", "'.$age.'","'.$weight.'","'.$sensitivity.'","'.$_SESSION['username'].'"');
                $input1 = $db->query($insert1);
                // if this was successful 
                if($input1){
                    // insert a patient with foreign key 
                    $_SESSION['name']   = $name;
                    $_SESSION['type'] = $type;
                    $_SESSION['size'] = $size;
                    $_SESSION['age'] = $age;
                    $_SESSION['weight'] = $weight;
                    $_SESSION['sensitivity'] = $sensitivity;
                    $message = 'The pet '.$name.' has been registered.';
                     $good=1;
                }else{
                    $message = "Invalid Value";
                    $good=0;
                }
            }else{
                    $message = "This pet has already been registered.";
                    $good=0;  
                  }
        } else{
                $message = "Invalid INPUTS";
                $good=0;
        }
                
    }
?>

<div class="mainContainer" style="background-color:#F2A2E8;">
  <H1 style="margin-top: 2%; font-family: 'arial';">Harness Orders</H1>
  <hr style="background-color: #FFFFFF; width:70%; margin:0 auto;">     

  <form name="user_create" method="post" style="margin-top: 20px;">
    <table border="0" cellpadding="10" cellspacing="1" width="500" align="center">

      <tr class="tableHeader">

        <!-- backend to choose pet from the Pet Registration Page -->
        <label for="type">Which Pet would you like to order the harness for?</label>
          <select id="type" name="type">
            <option value="Pet1">Pet1</option>
            <option value="Pet2">Pet2</option>
          </select><br><br>

        <label for="size">Harness Size:</label>
          <select id="type" name="type">
          <option value="Extra Small">Extra Small</option>
          <option value="Small">Small</option>
          <option value="Medium">Medium</option>
          <option value="Large">Large</option>
          <option value="Extra Large">Extra Large</option>
        </select><br><br>

        <label for="name">Full Address:</label>
          <input type="text" id="name" name="name" required>
      </tr>
      <tr >
           <td align="center" colspan="2" class="tableBtn" > <input  class="blueBtn" type="submit" name="register" value="Order"></td>
      </tr>
    </form>
    <?php 
            if($message!="" && $good== 0) {
                echo '<div class="fail" id="fail" style="width:70%; margin:0 auto; margin-top:50px;" >'.$message.'</div>';

            } elseif($message!="" && $good== 1){
                echo '<div class="good" id="good" style="width:70%; margin:0 auto; margin-top:50px;" >'.$message.'</div>';
            }
    ?> 
  </body>
</html>
