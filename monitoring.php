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
        cursor: pointer;>
      }

      #myChart {
        font-size: 50px;
    }
  </style>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>



<body>
	 <?php 
    session_start();
    include("connection.php");
    include("algorithmTesting.php");
?>
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
            onclick="window.location.href = '/monitoring.php';">
            Monitoring
        </button3>
    </div>

  
	<?php
    if(isset($_POST['UpdateSensitivity'])){
        if(isset($_POST['index'])){
            $index = $_POST['index'];
        } else{
            $index = array();
        }
        $sensitivity = floatval($_SESSION['sensitivity']);
        // count number of false detections and update sensitivity
        $falseDetections = count($index);
        // no false detection and user pressed update sensitivity
        // make more sensitive 
        if (  $falseDetections == 0){
                 $newSensitivity  =  $sensitivity + 0.2;
        } // be only a little bit more sensitive is more sensitive 
        elseif ($falseDetections > 5){
                $newSensitivity  = $sensitivity - 0.5;
        }
        elseif ( $falseDetections < 5  ){
                 $newSensitivity = $sensitivity - 0.2;
        }
        if($newSensitivity <0.5){
            //set to lowest sensitivity of 0.5
            $newSensitivity = 0.5; 
        }
        $message= 'The chosen dog ' .$_SESSION['dog'].' has an updated sensitivity from '. $sensitivity. ' to '.$newSensitivity.'';
        $good=1;
        $result = $db->query('UPDATE Dog SET  Sensitivity = '.$newSensitivity.' WHERE Name = "'.$_SESSION['dog'].'" and  Owner_Username = "'.$_SESSION['username'].'"');
            
        
        
    }
	if(isset($_POST['dog_btn'])){
            $dog=  $_POST['dog'];
            $_SESSION['dog'] = $dog;
            if( $dog!=""){
               
                    $count=0;
 
                    $q1 = "SELECT HDate, HTime, Heartbeatpm, Dog_Name, Owner_UserName FROM Heart_Rate WHERE Owner_UserName = '" .$_SESSION['username']."' AND Dog_Name = '".$dog."' ;";
                    
                    $r1 = $db->query($q1);
                    // this data is saved in an array
                    $time= array();
                    $heartRate = array();
                
                    while ($row0 = $r1->fetch()) {
                        $count= $count +1;
                        if($count>50){
                            break;
                        }
                        $timeValue = ''.$row0["HDate"].' '.$row0["HTime"].'';
                        
                      array_push($time, $timeValue);
                        array_push($heartRate, ''.$row0["Heartbeatpm"].'' );
                     
                    
                    }

                    $count=0;

                    $q2 = "SELECT HDate, HTime, Stepspm, Dog_Name, Owner_UserName FROM Steps WHERE Owner_UserName = '" .$_SESSION['username']."' AND Dog_Name = '".$dog."' ;";
                    
                    $r2 = $db->query($q2);
                    // this data is saved in an array
                    $time2= array();
                    $steps = array();
                
                    while ($row0 = $r2->fetch()) {
                        $count= $count +1;
                        if($count>50){
                            break;
                        }
                        $timeValue = ''.$row0["HDate"].' '.$row0["HTime"].'';
                        
                      array_push($time2, $timeValue);
                        array_push($steps, ''.$row0["Stepspm"].'' );
                    }

                    $count=0;

                    $q3 = "SELECT HDate, HTime, Temppm, Dog_Name, Owner_UserName FROM Temperature WHERE Owner_UserName = '" .$_SESSION['username']."' AND Dog_Name = '".$dog."' ;";
                    
                    $r3 = $db->query($q3);
                     // this data is saved in an array
                     $time3= array();
                     $temp = array();
                
                    while ($row0 = $r3->fetch()) {
                        $count= $count +1;
                        if($count>50){
                            break;
                        }
                        $timeValue = ''.$row0["HDate"].' '.$row0["HTime"].'';
                        
                      array_push($time3, $timeValue);
                        array_push($temp, ''.$row0["Temppm"].'' );
                    }

                    $count=0;

                    $q4 = "SELECT HDate, HTime, EntryNum, Audio, Dog_Name, Owner_UserName FROM Audio WHERE Owner_UserName = '" .$_SESSION['username']."' AND Dog_Name = '".$dog."' ;";
                    
                    $r4 = $db->query($q4);
                     // this data is saved in an array
                     $time4= array();
                     $audio = array();
                
                    while ($row0 = $r4->fetch()) {
                        $count= $count +1;
                        if($count>50){
                            break;
                        }
                        $timeValue = ''.$row0["HDate"].' '.$row0["HTime"].' - ' .$row0["EntryNum"].'';
                        
                      array_push($time4, $timeValue);
                        array_push($audio, ''.$row0["Audio"].'' );
                    }


                    if(count($heartRate) == 0 && count($steps) == 0 && count($temp) == 0 && count($audio) ==0){
                        $message= 'The chosen dog is ' .$dog.' has no data. ';
                        $good=0;
                        
                    }
                    else{
                        
                        $message= 'The chosen dog is ' .$dog.'';
                        $good=1;

                        $result = $db->query('select Name, Dog_Type, Dog_Size, Age, Weight, Sensitivity, Address, Owner_Username from Dog WHERE Name = "' . $dog . '" and  Owner_Username = "'.$_SESSION['username'].'"');
                        $count=0;
                 
                        while ($row = $result->fetch()) {
                            $sensitivity = floatval($row["Sensitivity"]);
                            $dogWeight = (int)$row["Weight"];
                            $age = (int)$row["Age"];
                            $size = $row["Dog_Size"];
                            $type = $row["Dog_Type"];
                        }
                    $_SESSION['sensitivity'] = $sensitivity;
                        
                        
                       $resultHeart= getAbnormalities($heartRate, count($heartRate), $time, $sensitivity, $dogWeight, $type, $age, $size, $steps);
                        
                        $resultTemp = temperatureCheck($sensitivity, $time3, $temp);
                        if(count($resultTemp) ==0 && count($resultHeart)==0){
                            $message2= 'No abnormalities detected :)';
                            $good2 = 1;
                        }else{
                           
                            echo '<form name="abnormalities" method="post" style="margin-top: 20px;">';
		                   echo '<table border="0" cellpadding="10" cellspacing="1" width="300" align="center">';
                            echo '<div class="fail" id="fail" style="width:70%; margin:0 auto; margin-top:50px;" >';
                            $results = array_merge($resultTemp, $resultHeart);
                            $count = 0;
                                 echo '<label style="color:black;"> Select all abnormalities that should be ignored and press update sensitivity. Note if update sensitivity is pressed with no selection, the sensitivity will be raised.</label><br>';
                            foreach ($results as $line) {
                               
                                echo '<input type="checkbox" name="index[]" value="'.$count.'">';
                                echo '<label for="vehicle1"> '.$line.'</label><br>';
                                 $count = $count +1 ; 
                                
                              
                            }
                             echo '</div>';
                            
			               echo '<tr >';
			      echo '<td align="center" colspan="2" class="tableBtn" > <input class="blueBtn" type="submit" name="UpdateSensitivity" value="Update Sensitivity"></td>';
			    echo '</tr>';
                             echo '</table>';
                            echo '</form>';
                            
                        }
                        
                        
                        $messageW = checkWeightConcerns($type, $size, $dogWeight, $age);  
         
                        if($messageW){
                        echo '<div class="warning" id="warning" style="width:70%; margin:0 auto; margin-top:50px;" >'.$messageW.'</div>';}
                        
                     
                         $messageE = checkExistingHealthConcerns($dogWeight, $age, $heartRate); 
             
                        if($messageE){
                        echo '<div class="warning" id="warning" style="width:70%; margin:0 auto; margin-top:50px;" >'.$messageE.'</div>';}
                        
                        

                    } 

            
            }
    }
?>

	


	<h1>Monitoring</h1>
	<?php
		echo '<form name="select_dog" method="post" style="margin-top: 20px;">';
		      echo '<table border="0" cellpadding="10" cellspacing="1" width="300" align="center">';
                echo '<tr class="tableHeader">';
			     echo '<td align="center" colspan="2" id="test">Choose Your Dog</td>';
			    echo '</tr>';
			    echo '<tr >';
			     echo '<td>';
			         echo '<select name="dog" >';  
                        $query = "SELECT Name, Owner_Username FROM Dog WHERE Owner_Username ='" .$_SESSION['username']."';";
                        $result = $db->query($query);
                        echo '<option value="">Select Dog</option>';
                        while ($row = $result->fetch()) {
                            echo '<option value="';             
                            echo $row["Name"];
                            echo '">' . $row["Name"] . "</option>";
                        }   
                    echo '</select>';
                 echo '</td>';
			    echo '</tr>';
                echo '<tr >';
			      echo '<td align="center" colspan="2" class="tableBtn" > <input class="blueBtn" type="submit" name="dog_btn" value="Select Dog"></td>';
			    echo '</tr>';
            echo '</table>';
           echo '</form>';

            if($message!="" && $good== 0) {
                echo '<div class="fail" id="fail" style="width:70%; margin:0 auto; margin-top:50px;" >'.$message.'</div>';

            } elseif($message!="" && $good== 1){
                echo '<div class="good" id="good" style="width:70%; margin:0 auto; margin-top:50px;" >'.$message.'</div>';
            }
            if($message2!="" && $good2== 0) {
                echo '<div class="fail" id="fail" style="width:70%; margin:0 auto; margin-top:50px;" >'.$message2.'</div>';

            } elseif($message2!="" && $good2== 1){
                echo '<div class="good" id="good" style="width:70%; margin:0 auto; margin-top:50px;" >'.$message2.'</div>';
            }
    
	?>


    <?php
    if (count($heartRate)>0){
    echo '<h3 style="color: #000000"> Heart Rate Monitoring </h3>';
    echo '<table>';
        echo '<thead>';
            echo '<tr>';
                echo '<th>Time</th>';
                echo '<th>Heart Rate(bpm)</th>';
            echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $count1=0;
        foreach($time as $currentTime){
            echo '<tr>';
                echo '<td>'.$currentTime.'</td>';
                echo '<td>'.$heartRate[$count1].'</td>';
                $count1=$count1+1;
            echo '</tr>';
            }
        echo '</tbody>';
    echo '</table>';

        echo '<canvas id="myChart" width="600" height="200"></canvas>';

    }
    if(count($steps)>0){

        echo '<br></br>';
        echo '<br></br>';
        echo '<br></br>';
    echo '<h3 style="color: #ff6347"> Steps Monitoring </h3>';


        echo '<table>';
        echo '<thead>';
            echo '<tr>';
                echo '<th>Time</th>';
                echo '<th>Steps pm)</th>';
            echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $count1=0;
        foreach($time2 as $currentTime){
            echo '<tr>';
                echo '<td>'.$currentTime.'</td>';
                echo '<td>'.$steps[$count1].'</td>';
                $count1=$count1+1;
            echo '</tr>';
            }
        echo '</tbody>';
    echo '</table>';
    echo '<canvas id="myChart2" width="600" height="200"></canvas>';

    }

    if(count($temp)>0){

        echo '<br></br>';
        echo '<br></br>';
        echo '<br></br>';
    echo '<h3 style="color: #008200"> Temperature Monitoring </h3>';


        echo '<table>';
        echo '<thead>';
            echo '<tr>';
                echo '<th>Time</th>';
                echo '<th>Temperature pm</th>';
            echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $count1=0;
        foreach($time3 as $currentTime){
            echo '<tr>';
                echo '<td>'.$currentTime.'</td>';
                echo '<td>'.$temp[$count1].'</td>';
                $count1=$count1+1;
            echo '</tr>';
            }
        echo '</tbody>';
    echo '</table>';
        echo '<canvas id="myChart3" width="600" height="200"></canvas>';
    }
    if(count($audio)>0){


        echo '<br></br>';
        echo '<br></br>';
        echo '<br></br>';
    echo '<h3 style="color: #ff00ff"> Audio Monitoring </h3>';


        echo '<table>';
        echo '<thead>';
            echo '<tr>';
                echo '<th>Time and Entry</th>';
                echo '<th>Audio</th>';
            echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $count1=0;
        foreach($time4 as $currentTime){
            echo '<tr>';
                echo '<td>'.$currentTime.'</td>';
                echo '<td>'.$audio[$count1].'</td>';
                $count1=$count1+1;
            echo '</tr>';
            }
        echo '</tbody>';
    echo '</table>';
        echo '<canvas id="myChart4" width="600" height="200"></canvas>';
    }
    ?>


	<script>
		var ctx = document.getElementById('myChart').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: <?php echo json_encode($time, JSON_NUMERIC_CHECK); ?>,
				datasets: [{
					label: 'Heart Rate (bpm)',
					data: <?php echo json_encode($heartRate, JSON_NUMERIC_CHECK); ?>,
					backgroundColor: 'rgba(0, 0, 0, 1)',
					borderColor: 'rgba(0, 0, 0, 1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
	</script>
    <script>
        var ctx2 = document.getElementById('myChart2').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($time2, JSON_NUMERIC_CHECK); ?>,
                datasets: [{
                    label: 'Steps pm',
                    data: <?php echo json_encode($steps, JSON_NUMERIC_CHECK); ?>,
                    backgroundColor: 'rgba(255, 99, 71, 1)',
                    borderColor: 'rgba(255, 99, 71, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
     <script>
        var ctx3 = document.getElementById('myChart3').getContext('2d');
        var myChart3 = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($time3, JSON_NUMERIC_CHECK); ?>,
                datasets: [{
                    label: 'Temperature pm',
                    data: <?php echo json_encode($temp, JSON_NUMERIC_CHECK); ?>,
                    backgroundColor: 'rgba(0, 130, 0, 1)',
                    borderColor: 'rgba(0, 130, 0, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

    <script>
        var ctx4 = document.getElementById('myChart4').getContext('2d');
        var myChart4 = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($time4, JSON_NUMERIC_CHECK); ?>,
                datasets: [{
                    label: 'Audio',
                    data: <?php echo json_encode($audio, JSON_NUMERIC_CHECK); ?>,
                    backgroundColor: 'rgba(255, 0, 255, 1)',
                    borderColor: 'rgba(255, 0, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

</body>
</html>
