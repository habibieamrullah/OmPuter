<?php 
include("functions.php");
$connection = mysqli_connect("localhost", "root", "", "mydatabase"); 
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Watty Property - Agen Spesialis Jual Beli Properti</title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">

		<style>
			body{
				padding: 0px;
				margin: 0px;
				
				background: url(webimages/bg.jpg) no-repeat fixed center; 
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
				
				font-family: 'Quicksand', sans-serif;
			}
			
			h1, h2, h3, h4, h5, p{
				margin: 0px;
				margin-bottom: 0.5em;
			}
			
			#content{
				margin-top: 5em; 
				margin-left: 10em; 
				margin-right: 10em; 
				margin-bottom: 5em;
			}
			
			.lihat{
				background-color: #006bb6;
				color: white;
				cursor: pointer;
				display: inline-block;
				padding: 0.5em;

				margin-top: 0.5em;
			}
			
		</style>
	</head>
	<body>
		
		<div id="content">
		
			<?php
			if(isset($_GET["properti"])){
				$id = mysqli_real_escape_string($connection, $_GET["properti"]);
				$sql = "SELECT * FROM properti123 WHERE id = $id";
				$result = mysqli_query($connection, $sql);
				if($result){
					$row = mysqli_fetch_assoc($result);
					?>
					
					<div style="background-color: white; padding: 1em;">
						<div style="display: table; width: 100%;">
							<div style="display: table-cell; vertical-align: top;">
								<img src="images/<?php echo $row["image"] ?>" style="width: 10em; ">
							</div>
							<div style="display: table-cell; vertical-align: top; padding-left: 1em; width: 100%;">
								<h1><?php echo $row["title"] ?></h1>
								<p><b><?php echo $row["price"] ?></b></p>
								<div><?php echo $row["description"] ?></div>
								
								<a href="<?php echo $row["rumah123"] ?>" target="_blank"><div class="lihat">Lihat di Rumah123</div></a>
							</div>
						</div>
						
					</div>
					
					<div style="background-color: white;  padding: 2em;">
						<div style="display: table;">
							<div style="display: table-cell;">
								<div style="display: inline-block; vertical-align: middle;">
									<img src="webimages/pp.jpg" style="width: 5em; border-radius: 50%;">
								</div>
							</div>
							<div style="display: table-cell;">
								<div style="display: inline-block; vertical-align: middle; margin-left: 1em;">
									<h3 style="color: #006bb6;">Watty Property</h3>
									<h4>Agen Spesialis Jual Beli Properti Hermawatti</h4>
									<p>Alamat: Ruko Mendrisio 2 Blok A No. 9 Cihuni Kec. Pagedangan Tangerang 15334 Banten</p>
								</div>
							</div>
						</div>
						<div style="text-align: right;">
							<a href="https://www.rumah123.com/agen-properti/sagentus-indonesia/hermawatty-738711/" target="_blank"><img src="webimages/rumah123.png" style="width: 20%; "></a>
							<a href="https://wa.me/6287886443776" target="_blank"><img src="webimages/wa.png" style="width: 20%; margin-left: 0.5em; "></a>
						</div>
					</div>
					
					<?php
				}
				
			}else{
				?>
				<div style="background-color: white;  padding: 2em;">
					<div style="display: table;">
						<div style="display: table-cell;">
							<div style="display: inline-block; vertical-align: middle;">
								<img src="webimages/pp.jpg" style="width: 10em; border-radius: 50%;">
							</div>
						</div>
						<div style="display: table-cell;">
							<div style="display: inline-block; vertical-align: middle; margin-left: 1em;">
								<h1 style="color: #006bb6;">Watty Property</h1>
								<h3>Agen Spesialis Jual Beli Properti Hermawatti</h3>
								<p>Alamat: Ruko Mendrisio 2 Blok A No. 9 Cihuni Kec. Pagedangan Tangerang 15334 Banten</p>
							</div>
						</div>
					</div>
					<div style="text-align: right;">
						<a href="https://www.rumah123.com/agen-properti/sagentus-indonesia/hermawatty-738711/" target="_blank"><img src="webimages/rumah123.png" style="width: 30%; "></a>
						<a href="https://wa.me/6287886443776" target="_blank"><img src="webimages/wa.png" style="width: 30%; margin-left: 0.5em; "></a>
					</div>
				</div>
				
				<?php
		
				
				$sql = "SELECT * FROM properti123 ORDER BY id DESC";
				$result = mysqli_query($connection, $sql);
				if($result){
					
					while($row = mysqli_fetch_assoc($result)){
						
						?>
						<div style="background-color: white; padding: 1em; margin-top: 3em;">
							<div style="display: table; width: 100%;">
								<div style="display: table-cell; vertical-align: top;">
									<img src="images/<?php echo $row["image"] ?>" style="width: 10em; ">
								</div>
								<div style="display: table-cell; vertical-align: top; padding-left: 1em; width: 100%;">
									<h3><?php echo $row["title"] ?></h3>
									<p><b><?php echo $row["price"] ?></b></p>
									<div><?php echo shorten_text($row["description"], 114) ?></div>
									
									<a href="?properti=<?php echo $row["id"] ?>"><div class="lihat">Lihat Properti</div></a>
								</div>
							</div>
							
						</div>
						<?php
						
					}
					
				}
				
				?>
				<?php
			}
			?>
			
			
			
			
		</div>
		
		
	</body>
</html>