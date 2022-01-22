<!DOCTYPE html>
<html>
	<head>
		<title>Baca Data Dari Database</title>
		<style>
			table, tr, th, td{
				border: 1px solid black;
				border-collapse: collapse;
			}
			
			td{
				padding: 20px;
			}
		</style>
	</head>
	<body>
	
		<h1>Data dari Database "Data Murid"</h1>
		<?php
		$servername = "localhost";
		$username = "root";
		$password = "";
		$database = "datamurid";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $database);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		//echo "Connected successfully";
		
		
		require_once('phpqrcode/qrlib.php'); 
		
		
		$sql = "SELECT * FROM muridmath ORDER BY id DESC";
		$result = mysqli_query($conn, $sql);

		$datasaya = "<table><tr><th>ID</th><th>Nama</th><th>Nomor</th><th>QRCode</th></tr>";
		
		
		while($row = mysqli_fetch_assoc($result)){
			
			$qrvalue = $row["nomor"];
			
			$tempDir = "pdfqrcodes/"; 
			$codeContents = $qrvalue; 
			$fileName = $qrvalue . '.png'; 
			$pngAbsoluteFilePath = $tempDir.$fileName; 
			$urlRelativeFilePath = $tempDir.$fileName; 
			if (!file_exists($pngAbsoluteFilePath)) { 
				QRcode::png($codeContents, $pngAbsoluteFilePath); 
			}
			
			$datasaya .= "<tr><td>" . $row["id"] . "</td><td>" . $row["nama"] . "</td><td>" .$row["nomor"]. "</td><td><img src='pdfqrcodes/" .$row["nomor"]. ".png' width='64px'></td></tr>";

		}
		
		
		$datasaya .= "</table>";
		
		echo $datasaya;
		
		?>
	</body>
</html>

