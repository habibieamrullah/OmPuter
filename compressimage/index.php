<!DOCTYPE html>
<html>
	<head>
		<title>Om Puter</title>		
	</head>
	<body>
	
		<?php
		
		if(isset($_POST["namagambar"])){
			
			include("compressimage.php");
			
			$namagambar = $_POST["namagambar"];
			
			uploadAndResize($namagambar, "filegambar", "uploads/", 512);
			
			echo "Berhasil diunggah!";
			
		}
		
		?>
		
		<form method="post" enctype="multipart/form-data">
		
			<input placeholder="Nama Baru Gambar" name="namagambar">
			<input type="file" name="filegambar">
			<input type="submit" value="Unggah">
			
		</form>
		
	</body>
</html>