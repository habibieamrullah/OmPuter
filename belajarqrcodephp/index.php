<!DOCTYPE html>
<html>
	<head>
		<title>QR Code dan PHP</title>
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
		
		
		if(isset($_GET["tambahdata"])){
			
			?>

			<h1>Tambah Data</h1>
			<form method="post">
				<label>Nama</label>
				<input name="nama">
				<label>Nomor</label>
				<input name="nomor" type="number">
				<input type="submit" value="Tambah Data">
			</form>
			<?php
		
			if(isset($_POST["nama"])){
				
				$nama = mysqli_real_escape_string($conn, $_POST["nama"]);
				$nomor = mysqli_real_escape_string($conn, $_POST["nomor"]);
				
				echo "Nama adalah = " . $nama;
				
				mysqli_query($conn, "INSERT INTO muridmath (nama, nomor) VALUES ('$nama', '$nomor')");
				require_once('phpqrcode/qrlib.php'); 
				$qrvalue = $nomor;
				$tempDir = "qr/"; 
				$codeContents = "http://localhost/OmPuter/belajarqrcodephp/index.php?cek=" . $qrvalue; 
				$fileName = $qrvalue . '.png'; 
				$pngAbsoluteFilePath = $tempDir.$fileName; 
				$urlRelativeFilePath = $tempDir.$fileName; 
				if (!file_exists($pngAbsoluteFilePath)) { 
					QRcode::png($codeContents, $pngAbsoluteFilePath); 
				}
				
			}
			
		}
		
		
		
		if(isset($_GET["cek"])){
			
			$nomor = mysqli_real_escape_string($conn, $_GET["cek"]);
			
			$sql = "SELECT * FROM muridmath WHERE nomor = $nomor";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($result);
			
			?>
			<h1>Detil Data</h1>
			<p>ID = <?php echo $row["id"] ?></p>
			<p>Nama = <?php echo $row["nama"] ?></p>
			<p>Nomor = <?php echo $row["nomor"] ?></p>
			<?php
			
		}else{
			
			?>
			<h1>Data dari Database "Data Murid"</h1>
			<?php
			
			$sql = "SELECT * FROM muridmath ORDER BY id DESC";
			$result = mysqli_query($conn, $sql);

			$datasaya = "<table><tr><th>ID</th><th>Nama</th><th>Nomor</th><th>QRCode</th></tr>";
			
			
			while($row = mysqli_fetch_assoc($result)){
				
				$datasaya .= "<tr><td>" . $row["id"] . "</td><td>" . $row["nama"] . "</td><td>" .$row["nomor"]. "</td><td><img src='qr/" .$row["nomor"]. ".png' width='64px'></td></tr>";

			}
			
			
			$datasaya .= "</table>";
			
			echo $datasaya;
		}
		
		
		
		
		?>
	</body>
</html>

