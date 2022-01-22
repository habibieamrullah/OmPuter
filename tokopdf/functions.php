<?php

//Make table if not exists
function maketable($table){
	global $connection;
    mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $table (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY
    )");
}

//Check column and make it if not exist
function makecolumn($columnname, $tablename, $ctype){
	global $connection;
    if(!mysqli_query($connection, "SELECT $columnname FROM $tablename")){
        mysqli_query($connection, "ALTER TABLE $tablename ADD $columnname $ctype");
    }
}

//Esc sql
function escsql($data){
	global $connection;
	return mysqli_real_escape_string($connection, $data);
}

//Query
function query($q){
	global $connection;
	return mysqli_query($connection, $q);
}

//Make option data
function getoption($optionname){
	global $connection;
	global $tableoptions;
	$sql = "SELECT optionvalue FROM $tableoptions WHERE optionname = '$optionname'";
	$result = mysqli_query($connection, $sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			return mysqli_fetch_assoc($result)["optionvalue"];
		}else{
			return false;
		}
	}else{
		return false;
	}
}

//Set option data
function setoption($optionname, $optionvalue){
	global $connection;
	global $tableoptions;
	
	//check if row exists
	$sql = "SELECT * FROM $tableoptions WHERE optionname = '$optionname'";
	$result = mysqli_query($connection, $sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			//update
			mysqli_query($connection, "UPDATE $tableoptions SET optionvalue = '$optionvalue' WHERE optionname = '$optionname'");
		}else{
			//add
			mysqli_query($connection, "INSERT INTO $tableoptions (optionname, optionvalue) VALUES ('$optionname', '$optionvalue')");
		}
	}
}

//Secure input
function secureinput($text){
	$text = str_replace("<", "*", $text);
	$text = str_replace(">", "*", $text);
	$text = str_replace("script", "*", $text);
	return $text;
}

//Get user info
function getuserinfo($id){
	global $connection;
	global $tableusers;
	$userinfo = array();
	$sql = "SELECT * FROM $tableusers WHERE id = $id";
	$result = query($sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			$userinfo = mysqli_fetch_assoc($result);
		}
	}
	return $userinfo;
}

//Generate random numbers
function randnum($count){
    return substr(str_shuffle(str_repeat("0123456789", 5)), 0, $count);
}

//Generate random characters
function randchar($count){
    return substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, $count);
}

//Mil to date
function miltodate($mil){
	if(is_numeric($mil)){
    $seconds = $mil / 1000;
		$date = date("d-m-Y", $seconds); 
		$time = date("h:i:sa", $seconds);
		return $date . " " . $time . " (" . humanTiming($seconds) . " ago)";
	}else{
		return "-";
	}
}


//Readable human timing
function humanTiming ($time){
    $time = time() - intval($time); // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
}

//Get current millisecond
function getCurrentMillisecond(){
    return round(microtime(true) * 1000);
}

//Space separator
function spacesep($content, $digits){
	return chunk_split($content . "", $digits, " ");
}

//New new lines
function nonewline($text){
	return trim(preg_replace('/\s\s+/', '', $text));
}

//Get user ip address
function getuserip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}