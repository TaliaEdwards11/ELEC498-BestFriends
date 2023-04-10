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
      <button class="button" 
            onclick="window.location.href = '/welcome.php';">
            Home
        </button>
        <button class="button" 
            onclick="window.location.href = '/dogRegister.php';">
            Pet Registration 
        </button>
        <button class="button" 
            onclick="window.location.href = '/monitoring.php';">
            Monitoring
        </button>
    </div>

<?php
  session_start();
  include("connection.php");
?>
<?php
  if (isset($_POST['dogregister'])){
    $name = $_POST['name'];
    $type = $_POST['type'];
    $size = $_POST['size'];
    $age = $_POST['age']; 
    $weight = $_POST['weight'];
    $sensitivity = $_POST['sensitivity'];
    $address = $_POST['address'];

    //check if pet exists
    $valid_types = array('Bulldogs', 'Pug', 'Pekingese', 'Saint Bernards', 'Great Danes', 'Mastiffs', 'Boxers', 'Doberman Pinschers', 'Other');

    $valid_size = array('Extra Small','Small', 'Medium', 'Large', 'Extra Large');

    if (ctype_alpha($name)){

        $result = $db->query('select Name, Dog_Type, Dog_Size, Age, Weight, Sensitivity, Address, Owner_Username from Dog WHERE Name = "' . $name . '" and  Owner_Username = "'.$_SESSION['username'].'"');
              $count=0;
              // check if pet already exists 
              while ($row = $result->fetch()) {
                  $count= $count+1;
              }
           
             //pet does not exist, proceed
              if($count ==0){
                 // insert user in database
                  $insert1 = 'INSERT INTO Dog VALUES ("'.$name.'","'.$type.'","'.$size.'", '.$age.','.$weight.','.$sensitivity.',"'.$address.'","'.$_SESSION['username'].'")';
                  $input1 = $db->query($insert1);
                  // if this was successful 
                 if($input1){
                     // insert a pet with foreign key 
                     
                     $message = "The pet " .$name." has been registered and a harness has been ordered.";
                      $good=1;
              }
                 else{
                   $message = "Invalid Value";
                   $good=0;
                 }
             }
             else{
               $message = "This pet has already been registered.";
               $good=0;  
             }
    } 
     else{
       $message = "Invalid INPUTS";
       $good=0;
      }
}
                
?>

<div class="mainContainer" style="background-color:#F2A2E8;">
  <H1 style="margin-top: 2%; font-family: 'arial';">Dog Registration</H1>
  <hr style="background-color: #FFFFFF; width:70%; margin:0 auto;">


 <?php
    if(!$_SESSION['username'] || $_SESSION['username'] =='') {
            header('location:login.php');
        } 
  ?>  

<form name="user_create" method="post" style="margin-top: 20px;">
    <table border="0" cellpadding="10" cellspacing="1" width="500" align="center">

      <tr class="tableHeader">
      <label for="name">Name: </label>
        <input type="text" id="name" name="name" required><br><br>

      <label for="type">Dog Type: </label>
        <select id="type" name="type">
          <option value="Bulldogs">Bulldogs</option>
          <option value="Pug">Pug</option>
          <option value="Pekingese">Pekingese</option>
          <option value="Saint Bernards">Saint Bernards</option>
          <option value="Great Danes">Great Danes</option>
          <option value="Mastiffs">Masstifs</option>
          <option value="Boxers">Boxers</option>
          <option value="Doberman Pinschers">Doberman Pinschers</option>
          <option value="Other">Other</option>
        </select><br><br>

      <label for="size">Dog Size:</label>
        <select id="size" name="size">
          <option value="Extra Small">Extra Small</option>
          <option value="Small">Small</option>
          <option value="Medium">Medium</option>
          <option value="Large">Large</option>
          <option value="Extra Large">Extra Large</option>
        </select><br><br>

      <label for="age">Age:</label>
        <input type="number" id="age" name="age" required><br><br>

      <label for="weight">Weight (kgs in nearest whole number):</label>
       <input type="number" id="weight" name="weight" required><br><br>

      <label for="sensitivity">Please rate your pet's sensitivity to certain foods or medications</label><br>
      (1 being not sensitive to 3 for being very sensitive):
       <input type="number" id="sensitivity" name="sensitivity" required><br><br>

       <label for="address">Full House Address: </label>
        <input type="text" id="address" name="address" required><br><br>
    
    </tr>
      <tr >
           <td align="center" colspan="2" class="tableBtn" > <input  class="blueBtn" type="submit" name="dogregister" value="Submit"></td>
      </tr>
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
