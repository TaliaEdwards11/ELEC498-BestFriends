<head>
        <link rel="stylesheet" href="static/content/site.css">
</head>
<?php
// quick sort -- calls partition function 
// split heartbeats based on partition similar to isolation forest
// recursive function
function quicksort(&$Array, $left, $right) {
  if ($left < $right) { 
    $pivot = partition($Array, $left, $right);
    quicksort($Array, $left, $pivot-1);
    quicksort($Array, $pivot+1, $right);
  }
}

function partition(&$Array, $left, $right) {
  $i = $left;
  $pivot = $Array[$right];
  for($j = $left; $j <=$right; $j++) {
    if($Array[$j] < $pivot) {
      $temp = $Array[$i];
      $Array[$i] = $Array[$j];
      $Array[$j] = $temp;
      $i++;
    }
  }

  $temp = $Array[$right];
  $Array[$right] = $Array[$i];
  $Array[$i] = $temp;
  return $i;
}

// function to print array
function PrintArray($Array, $n) { 
  for ($i = 0; $i < $n; $i++) 
    echo $Array[$i]." "; 
  echo "<br>";
} 

function getAbnormalities($MyArray, $n, $MyTimeArray, $minValue, $maxValue, $sensitivity, $dogSize, $dogBreed, $existingCondition){
    echo "Statistics: <br>";
    echo "Maximum heartbeat recorded to be: ";
    echo $MyArray[$n-1]." ";
    echo "<br>";
    if ($MyArray[$n-1] > 180){
        echo "Check for Sinus Tachycardia with vet provider. ";
    }
    echo "Minimum heartbeat recorded to be: ";
    echo $MyArray[0]." ";
    echo "<br>";
    echo "With a sensitivity of ";
    echo $sensitivity;
    echo "<br>";
    echo "List of heartbeat bpm readings:";
    
    
    // depending on dog size (big or small), the bpm hearbeats will be in different ranges
    // range is 120 - 160 for small dogs
    
    // range is 60 - 120 for large dogs
    

    
    for ($i = 0; $i < $n; $i++){
        echo $MyArray[$i]." "; 
        //echo "<br>";
    }
    echo "<br>";
    echo "\nList of corresponding time readings: ";
    for ($i = 0; $i < $n; $i++){
        echo $MyTimeArray[$i]." "; 
        //echo "<br>";
    }
    
    // check if greater than 100 bpm and depending on sensitivity range
    // if higher than should be. For example, the higher the sensitivity
    // rating, bpm of 115 are ok but not ok with a sensitivity of 1
    foreach($MyArray as $key=>$e){
            $i = 0;
            $difference = $e - 100;
            $sensitivity = $sensitivity * 0.5;
            //echo $difference;
            //echo $sensitivity;
            if($e>$maxValue && $difference > $sensitivity){
                echo "\nAbnormality detected, specifically the bmp rate of : ";
                echo $e; 
                echo " and time reading of : ";
                echo $MyTimeArray[$key];
                echo "\nThis is a fast heartbeat. Advise to check in with Vet if high reading continues";
            }
        }
        echo "<br>";
        
    // check if lower than 100 bpm and depending on sensitivity range
    // if lower than should be. For example, the higher the sensitivity
    // rating, bpm of 45 are ok but not ok with a sensitivity of 1
    foreach($MyArray as $key=>$in){
            $difference = 60 - $in;
            $sensitivity = $sensitivity * 0.5;
            //echo $difference;
            //echo $sensitivity;
            if($in<$minValue && $sensitivity < $difference){
                echo "Abnormality detected, specifically the bmp rate of : ";
                echo $in; 
                echo " and time reading of : ";
                echo $MyTimeArray[$key];
                echo "<br>";
            }
        }
}

function temperatureCheck($MyTimeArray, $n, $tempMinLimit, $tempMaxLimit){
        // maximum temperature is 104
        // minimum temperature is 99
        
        foreach($MyTimeArray as $key=>$e){
            if($e>$tempMaxLimit||$e<$tempMinLimit){
                echo "Temperature readings are concerning\n";
            }

        }
    echo "Normal internal temperature readings";
}


function healthIssueCheck($dogBreed, $weight, $age){
    // small puppies 220 bpm identify Sinus Tachycardia
    
    // small dogs 180 bpm identify Sinus Tachycardia
    
    // standard size 160 bpm identify Sinus Tachycardia
    
    // giant breeds 140 bpm 
}

function checkStepsPerMin($stepCount, $petName){
    // check if step count in 1 minute is high (means they are exercising)
    for ($i = 0; $i > $n; $i++){
        echo $MyTimeArray[$i]." "; 
        echo $petName;
        echo "\n Seems to be going for a walk";
    }

}

// test the code
$MyArray = array(50.02,45.00,60.00,70.00, 55.00);
$MyTimeArray = array(18.05,18.06,18.07,18.08,18.08);
$MyTemperatureArray = array(70, 70.1, 70.3, 72, 71, 71.7, 70.6);
$n = sizeof($MyArray); 
echo "Original Heartbeat Array\n";
PrintArray($MyArray, $n);

quicksort($MyArray, 0, $n-1);
echo "\nSorted Heartbeat Array\n";
PrintArray($MyArray, $n);

echo "\nAbnormality Detection: \n";
getAbnormalities($MyArray, $n, $MyTimeArray, 60, 100, 3, 30, "Doguino", "Obesity");

$MyTemperatureArray = array(38.3,38.4,38.3);
temperatureCheck($MyTemperatureArray,3, 38.2,40.2);

?>