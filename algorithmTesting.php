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
  echo "\n";
} 

# algorithm will update based on users input of abnormality flags being true or false which affects the sensisitivity
function getAbnormalities($MyArray, $n, $MyTimeArray, $sensitivity, $dogWeight, $dogBreed, $age, $sizeDog, $stepCount){
        
    // depending on dog size (big or small), the bpm hearbeats will be in different ranges
    // range is 120 - 160 for small dogs
    // range is 60 - 120 for large dogs

    // CHECK HEARTBEAT INPUT -- can be commented out
    // echo "list of hearbeats recorded: "
    // for ($i = 0; $i < $n; $i++){
    // echo $MyArray[$i]." "; 
    // //echo "\n";
    // }
    
    // echo "\nList of corresponding time readings: ";
    // for ($i = 0; $i < $n; $i++){
    //     echo $MyTimeArray[$i]." "; 
    //     //echo "\n";
    // }

    if ($dogBreed == "Bulldog" || $dogBreed == "Chihuahuas" || $dogBreed == "Maltese" || $dogBreed == "Dachsund" || $dogBreed == "Pomeranian" || $dogBreed == "Pug" || $dogBreed == "Boston Terrier" || $dogBreed == "Shih Tzu" || $dogBreed == "Yorkshire Terrier" || $sizeDog == "Small" ){
       
        // depending on breed set minimum and maximum bpm value
        $minValue = 120;
        $maxValue = 160;
        $count = 0;
        
        

        // check if greater than 160 bpm and depending on sensitivity range
        // if higher than should be. For example, the higher the sensitivity
        // rating, bpm of 155 are ok but not ok with a sensitivity of 1
        $results = array();
  
        foreach($MyArray as $key=>$e){
            $i = 0;
            if($stepCount[$key] < 15 ){

            $difference = $e - $maxValue;
            
            //echo $difference;
            //echo $sensitivity;
            
            $threshold = 30;
           
            if($e>$maxValue && $difference > $threshold/$sensitivity){
               
                
                    $str = "Abnormality detected, specifically the high bmp rate of : ".$e. " at time reading of : ".$MyTimeArray[$key]."";
                    array_push($results, $str);

                
            }

            }
        }
        
        
    
        
        // check if lower than 120 bpm and depending on sensitivity range
        // if lower than should be. For example, the higher the sensitivity
        // rating, bpm of 45 are ok but not ok with a sensitivity of 1
     
        foreach($MyArray as $key=>$in){
                $difference = $minValue - $in;
                
                //echo $difference;
                //echo $sensitivity;
                if($in<$minValue && $difference > $threshold/$sensitivity){
                   
                 
                        $str = "Abnormality detected, specifically the low bmp rate of : ".$in. " at time reading of : " .$MyTimeArray[$key]."";
                        array_push($results, $str);
                    
                    
                }
            }
        }


    if ($dogBreed == "Golden Retriever" || $dogBreed == "Dalmation" || $dogBreed == "Pitbull" || $dogBreed == "Border Collie" || $dogBreed == "Bernese Mountain Dog" || $dogBreed == "Samoyed" || $dogBreed == "Alaskan Malamute" || $dogBreed == "German Shepard" || $dogBreed == "Irish Woldhound" || $sizeDog == "Large" ){

        // depending on breed set minimum and maximum bpm value
        $minValue = 60;
        $maxValue = 120;
        $count = 0;
        
        

        // check if greater than 160 bpm and depending on sensitivity range
        // if higher than should be. For example, the higher the sensitivity
        // rating, bpm of 155 are ok but not ok with a sensitivity of 1
   
        foreach($MyArray as $key=>$e){
            $i = 0;
            if($stepCount[$key] < 15 ){

            $difference = $e - $maxValue;
            
            //echo $difference;
            //echo $sensitivity;
            
            $threshold = 30;
           
            if($e>$maxValue && $difference > $threshold/$sensitivity){
               
                
                    $str = "Abnormality detected, specifically the high bmp rate of : ".$e." at time reading of : "+ $MyTimeArray[$key];
                    array_push($results, $str);

                
            }

            }
        }
        
        
    
        
        // check if lower than 120 bpm and depending on sensitivity range
        // if lower than should be. For example, the higher the sensitivity
        // rating, bpm of 45 are ok but not ok with a sensitivity of 1
     
        foreach($MyArray as $key=>$in){
                $difference = $minValue - $in;
                
                //echo $difference;
                //echo $sensitivity;
                if($in<$minValue && $difference > $threshold/$sensitivity){
                   
                 
                        $str = "Abnormality detected, specifically the bmp rate of : ".$in." at time reading of : "+ $MyTimeArray[$key];
                        array_push($results, $str);
                    
                    
                }
            }
        }
        return $results;
}

function temperatureCheck($sensitivity, $MyTimeArray, $Temp){
        // maximum temperature is 39.2
        // minimum temperature is 38.3

    $tempMinLimit = 38.3;
    $tempMaxLimit = 39.2;
    $results = array();
        $count = 0;
        foreach($Temp as $e){
            if(floatval($e)>$tempMaxLimit+ 3/$sensitivity){
                $str = "Your pet appears to have an elevated temperature of: " .$e. " at time "  .$MyTimeArray[$count]."";
                array_push($results, $str);
              
            } elseif(floatval($e)<$tempMinLimit- 3/$sensitivity){
                $str = "Your pet appears to have a low temperature of: " .$e. " at time "  .$MyTimeArray[$count]."";
                array_push($results, $str);
            
            }
            $count = $count+1;
    }
    return $results;

}


function checkExistingHealthConcerns( $weight, $age, $MyArray){
    $count = 0;
    // small puppies 220 bpm identify Sinus Tachycardia
    if ($weight < 15 &&  $age < 1){
        
            foreach($MyArray as $heart){
                if($heart > 220){
                    $count = $count + 1;
                }
            }
      
        
    }
    // standard dogs 160 bpm identify Sinus Tachycardia
   
    if ($weight > 15  && $age > 1){
        
            foreach($MyArray as $heart){
                if($heart > 160){
                    $count = $count + 1;
                }
            }
        
        
        }
    
      if($count >0){
            return "Flagged: Possibility for Sinus Tachycardia with vet provider. High heartrates appeared " .$count. " times.";
        }

}

function checkWeightConcerns($dogBreed, $size, $weight, $age){
    $flagWeight = False;
    if ($dogBreed == "Bulldog" || $dogBreed == "Chihuahuas" || $dogBreed == "Maltese" || $dogBreed == "Dachsund" || $dogBreed == "Pomeranian" || $dogBreed == "Pug" || $dogBreed == "Boston Terrier" || $dogBreed == "Shih Tzu" || $dogBreed == "Yorkshire Terrier" || $size == "Small"){
        if ($weight > 40 && $age >1){
            $flagWeight = True;
            return "Warning: Weight of pet could possibly be too high for their age and breed";
        }

        if ($weight < 15 && $age >1){
            $flagWeight = True;
            return "Warning: Weight of pet could possibly be too low";
        }

    }


    if ($dogBreed == "Golden Retriever" || $dogBreed == "Dalmation" || $dogBreed == "Pitbull" || $dogBreed == "Border Collie" || $dogBreed == "Bernese Mountain Dog" || $dogBreed == "Samoyed" || $dogBreed == "Alaskan Malamute" || $dogBreed == "German Shepard" || $dogBreed == "Irish Woldhound" || $size == "Large"){
        if ($weight > 65 && $age >1){
            $flagWeight = True;
            return "Warning: Weight of pet could possibly be too high for their age and breed";
        }

        if ($weight < 33 && $age >1){
            $flagWeight = True;
            return "Warning: Weight of pet could possibly be too low";
        }

    }
}



?>