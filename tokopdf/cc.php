<?php

if(isset($_POST["coincode"])){
	include("tables.php");
	include("dbcon/dbcon.php");
	include("functions.php");

	$coincode = escsql(secureinput($_POST["coincode"]));
	
	$sql = "SELECT * FROM $tablepayments WHERE coincode = '$coincode' AND used = 0 AND (status = 1 OR status = 3)";
	$result = query($sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$ccid = $row["id"];
			$ts = getCurrentMillisecond();
			$uip = getuserip();
			query("UPDATE $tablepayments SET used = 1, usedon = '$ts', usedip = '$uip' WHERE id = $ccid");
			echo (int)($row["amount"] * 1000);
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
}