<?php
   include("connection.php");
    // check type of request
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    switch($requestMethod) {
    // if this is a post request enter data in database
	case 'POST':	
        // extract info from request body 
        $body=json_decode(trim(file_get_contents('php://input'),"\xEF\xBB\xBF"), true);
            
        // check if information is present in the request body 
        if(isset($body['date']) && isset($body['time'])&& isset($body['heart']) && isset($body['user'])&& isset($body['dog'])){
        
        $date = $body['date'];
        $time = $body['time'];
        $rate = $body['heart'];
        $dogname = $body['dog'];
        $username = $body['user'];
        $temp = $body['temperature'];
        $steps = $body['steps'];
        
        // update the heart rate table
		$result = $db->query("insert into Heart_Rate values ('" . $date . "', '" . $time . "', " . $rate . ",'" . $dogname . "', '" . $username . "');");
         
        if($result){
            echo "Success";
        }else{
            echo "Writing to the database failed";
        }
        
        }else{
            echo "Missing a value in the API call!";
        }
            
        // update the step table
        $result2 = $db->query("insert into Steps values ('" . $date . "', '" . $time . "', " . $steps . ",'" . $dogname . "', '" . $username . "');");
         // update the temperature table 
        $result3 = $db->query("insert into Temperature values ('" . $date . "', '" . $time . "', " . $temp . ",'" . $dogname . "', '" . $username . "');");
		break;

	default:
    // don't accept other request such as GET
	echo "This API only does POST.";
	break;
}

?>
