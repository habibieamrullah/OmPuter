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
			uploadAndResize($namagambar, "gambar", "uploads/"  , 32);
			echo "Yes!";
			
		}
		?>
	
		<form method="post" enctype="multipart/form-data">
			<input type="text" name="namagambar">
			<input type="file" name="gambar">
			<input type="submit" value="Upload">
		</form>
		
	</body>
</html>