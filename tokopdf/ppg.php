<?php
include("tables.php");
include("dbcon/dbcon.php");
include("functions.php");

if(isset($_POST["puniqid"])){
	$uniqid = escsql(secureinput($_POST["puniqid"]));
	$sql = "SELECT * FROM $tablepayments WHERE uniqid = '$uniqid' AND status = 0";
	$result = query($sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			query("UPDATE $tablepayments SET status = 3 WHERE uniqid = '$uniqid'");
			$uid = $row["userid"];
			$usql = "SELECT * FROM $tableusers WHERE id = '$uid'";
			$uresult = query($usql);
			$uinfo = mysqli_fetch_assoc($uresult);
			$newbalance = $uinfo["balance"] + $row["amount"];
			query("UPDATE $tableusers SET balance = $newbalance WHERE id = $uid");
			echo 1;
			sendmail($adminemail, "C3 PayPal Payment Has Been Made", "Dear admin,<br>PayPal payment of " . $uniqid . " has been made.");
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
}