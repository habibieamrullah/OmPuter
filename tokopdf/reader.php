<?php include("init.php") ?>

<?php

if(isset($_GET["userid"]) && isset($_GET["p"]) && isset($_GET["bookid"])){
	$userid = escsql($_GET["userid"]);
	$p = escsql($_GET["p"]);
	$bookid = escsql($_GET["bookid"]);
	
	$result = query("SELECT * FROM $tableusers WHERE id = $userid AND password = '$p'");
	if($result){
		if(mysqli_num_rows($result) > 0){
			$result = query("SELECT * FROM $tablepurchases WHERE bookid = $bookid AND userid = $userid AND paid = 1");
			if($result){
				if(mysqli_num_rows($result) > 0){
					$result = query("SELECT * FROM $tablebooks WHERE id = $bookid");
					if($result){
						if(mysqli_num_rows($result) > 0){
							
							$row = mysqli_fetch_assoc($result);
							
							$file = $row["pdf"];
							$filename = $row["pdf"];
							
							//echo $file;
							
														
							// Header content type
							header('Content-type: application/pdf');
							  
							header('Content-Disposition: inline; filename="' . $filename . '"');
							  
							header('Content-Transfer-Encoding: binary');
							  
							header('Accept-Ranges: bytes');
							  
							// Read the file
							readfile("pdfuplds/" . $file);
							
							
						}
					}
				}
			}
		}
	}
}

?>