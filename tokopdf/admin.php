<?php 

include("init-admin.php");

function getbookinfo($bookid){
	global $tablebooks;
	return mysqli_fetch_assoc(query("SELECT * FROM $tablebooks WHERE id = $bookid"));
}

?>



<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<title>Admin Page</title>
		<script src="js/jscolor.min.js"></script>
		<script src="js/jquery/jquery.min.js"></script>
		<script src="js/jquery.form.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="style-bookadmin.css">
	</head>
	<body>
	
		<div id="maincontainer">
		
			<?php
			
			if(isset($_SESSION["bookadmin"])){
				
				?>
				<p>
					<a href="admin.php">Buku</a> | 
					<a href="?categories">Kategori</a> | 
					<a href="?sliders">Slider</a> | 
					<a href="?users">Para Pengguna</a> | 
					<a href="?sales">Penjualan</a> | 
					<a href="?paymentinstruction">Instruksi Pembayaran</a> | 
					<a href="?logout">Keluar</a>
				</p>
				<?php
				
				if(isset($_GET["categories"])){
					
					if(isset($_GET["edit"])){
						$id = escsql($_GET["edit"]);
						$row = mysqli_fetch_assoc(query("SELECT * FROM $tablecategories WHERE id = $id"));
						?>
						<h1>Edit Kategori</h1>
						
						<?php
						if(isset($_POST["newcategory"])){
							$newcat = escsql($_POST["newcategory"]);
							query("UPDATE $tablecategories SET title = '$newcat' WHERE id = $id");
							?>
							<div class="alertbox">Kategori berhasil diperbarui.</div>
							<?php
						}else{
							?>
							
							<form method="post">
								<label>Judul kategori:</label>
								<input type="text" name="newcategory" value="<?php echo $row["title"] ?>">
								<input type="submit" value="Perbarui">
							</form>
							
							<?php
						}
						
					}else{
						?>
						<h1>Kategori</h1>
										
						
						<?php
						
						if(isset($_GET["delete"])){
							$id = escsql($_GET["delete"]);
							query("DELETE FROM $tablecategories WHERE id = $id");
							?>
							<div class="alertbox">Satu kategori berhasil dihapus.</div>
							<?php
						}
						
						if(isset($_POST["newcategory"])){
							
							$newcat = escsql($_POST["newcategory"]);
							
							query("INSERT INTO $tablecategories (title) VALUES ('$newcat')");
							
							?>
							<div class="alertbox">Kategori baru telah ditambahkan.</div>
							<?php
							
						}
						?>
						
						<h3>Kategori yang sudah ada</h3> 
						<?php
						$sql = "SELECT * FROM $tablecategories ORDER BY title ASC";
						$result = query($sql);
						if($result){
							
							if(mysqli_num_rows($result) > 0){
								echo "<ul>";
								while($row = mysqli_fetch_assoc($result)){
									
									?>
									<li><?php echo $row["title"] ?> [ <a href="?categories&edit=<?php echo $row["id"] ?>">Edit</a> | <a href="?categories&delete=<?php echo $row["id"] ?>">Hapus</a> ]</li>
									<?php
									
								}
								echo "</ul>";
							}else{
								echo "<p>Belum ada kategori yang sudah ditambahkan.</p>";
							}
							
						}
						?>
						
						<h3>Tambah kategori baru</h3>
						<form method="post">
							<label>Kategori baru:</label>
							<input type="text" name="newcategory">
							<input type="submit" value="Tambahkan">
						</form>
						
						<?php
					}
					
				}else if(isset($_GET["users"])){
					?>
					<h1>Users</h1>
					<?php
					$sql = "SELECT * FROM $tableusers ORDER BY id DESC";
					$result = query($sql);
					if($result){
						
						if(mysqli_num_rows($result) > 0){
							?>
							<table class="admintable">
								<tr>
									<th>Nama</th>
									<th>Email</th>
								</tr>
								<?php
								while($row = mysqli_fetch_assoc($result)){
									?>
									<tr>
										<td><!--<a href="?userdetail=<?php echo $row["id"] ?>">--><?php echo $row["nickname"] ?><!--</a>--></td>
										<td><?php echo $row["email"] ?></td>								
										
									</tr>
									<?php
								}
								?>
							</table>
							
							<?php
						}else{
							echo "<p>No data</p>";
						}
					}
				}else if(isset($_GET["userdetail"])){
					?>
					<h1>Detil Pengguna</h1>
					<?php
					$id = escsql($_GET["userdetail"]);
					$sql = "SELECT * FROM $tableusers WHERE id = $id";
					$result = query($sql);
					if($result){
						if(mysqli_num_rows($result) > 0){
							$row = mysqli_fetch_assoc($result);
							?>
							<p>Nama: <?php echo $row["nickname"] ?></p>
							<p>Email: <?php echo $row["email"] ?></p>
							<p>Terkonfirmasi: <?php echo $row["confirmed"] ?></p>
							<!--
							<h2>Payments</h2>
							<?php
							$psql = "SELECT * FROM $tablepurchases WHERE userid = $id ORDER BY id DESC";
							$presult = query($psql);
							if($presult){
								if(mysqli_num_rows($presult) > 0){
									while($prow = mysqli_fetch_assoc($presult)){
										?>
										<p>Payment ID: <a href="?paymentdetails=<?php echo $prow["id"] ?>"><?php echo $prow["id"] ?></a></p>
										<?php
									}
								}
							}
							?>
							-->
							<!--<p>Delete this user? <a href="?deleteuser=<?php echo $id ?>">Click here</a>.</p>-->
							
							<?php
						}
					}
				}else if(isset($_GET["sliders"])){
					
					
					if(isset($_GET["edit"])){
						$id = escsql($_GET["edit"]); 
						?>
						<h1>Edit Link Slider</h1>
						
						<?php
						if(isset($_POST["sliderlink"])){
							$sliderlink = escsql($_POST["sliderlink"]);
							query("UPDATE $tablesliders SET link = '$sliderlink' WHERE id = $id");
							?>
							<div class="alertbox">Link slider berhasil diperbarui.</div>
							<?php
						}else{
							?>
							
							<p>*Untuk edit gambar, pilih hapus slider dan tambahkan slider baru.</p>
							<?php
							
							$sql = "SELECT * FROM $tablesliders WHERE id = $id";
							$result = query($sql);
							if($result){
								if(mysqli_num_rows($result) > 0){
									$row = mysqli_fetch_assoc($result);
									?>
									<form method="post">
										<label>Gambar slider</label>
										<div>
											<img src="uploads/<?php echo $row["image"] ?>" style="width: 512px;">
										</div>
										<label>Link Slider</label>
										<input type="text" name="sliderlink" value="<?php echo $row["link"] ?>">
										<input type="submit" value="Perbarui Link">
									</form>
									<?php
								}
							}
						}
						
					}else{
						
						?>
						<h1>Slider</h1>
						
						<?php
						if(isset($_FILES["slider"])){
							$sliderlink = escsql($_POST["sliderlink"]);						
							include("compressimage.php");
							$slider = uploadAndResize("Slider-" . randnum(10), "slider", "uploads", 2100);
							if($slider != ""){
								query("INSERT INTO $tablesliders (image, link) VALUES ('$slider', '$sliderlink')");
								?>
								<div class="alertbox">Slider berhasil ditambahkan.</div>
								<?php
							}
						}
						
						?>
						
						<h3>Slider yang sudah ditambahkan</h3>
						<?php
						
						if(isset($_GET["delete"])){
							$id = escsql($_GET["delete"]);
							$sliderimage = mysqli_fetch_assoc(query("SELECT * FROM $tablesliders WHERE id = $id"))["image"];
							query("DELETE FROM $tablesliders WHERE id = $id");
							$targetfile = "uploads/" . $sliderimage;
							if(file_exists($targetfile)){
								unlink($targetfile);
							}
							?>
							<div class="alertbox">Slider berhasil dihapus.</div>
							<?php
						}
						
						$sql = "SELECT * FROM $tablesliders ORDER BY id DESC";
						$result = query($sql);
						if($result){
							if(mysqli_num_rows($result) > 0){
								while($row = mysqli_fetch_assoc($result)){
									?>
									<div style="margin-bottom: 10px;">
										<div>
											<a href="<?php echo $row["link"] ?>"><img src="<?php echo "uploads/" . $row["image"] ?>" style="width: 512px"></a>
										</div>
										<div>[ <a href="?sliders&edit=<?php echo $row["id"] ?>">edit</a> | <a href="?sliders&delete=<?php echo $row["id"] ?>">hapus</a> ]</div>
									</div>
									<?php
								}
							}else{
								echo "<p>Belum ada slider yang ditambahkan.</p>";
							}
						}
						
						?>
						<h3>Tambah slider</h3>
						<form method="post" enctype="multipart/form-data">
							<label>Gambar slider (disarankan 2100 * 300)</label>
							<input type="file" name="slider" accept="image/*">
							<label>Link Slider</label>
							<input type="text" name="sliderlink">
							<input type="submit" value="Tambahkan">
						</form>
						<?php
						
					}
					
				}else if(isset($_GET["paymentinstruction"])){
					?>
					<h1>Instruksi Pembayaran</h1>
					
					<?php
					if(isset($_POST["paymentinstruction"])){
						$paymentinstruction = escsql($_POST["paymentinstruction"]);
						setoption("paymentinstruction", $paymentinstruction);
						?>
						<div class="alertbox">Instruksi pembayaran berhasil disimpan.</div>
						<?php
					}
					?>
					
					<form method="post">
						<label>Keterangan cara pembayaran untuk pembeli</label>
						<textarea name="paymentinstruction"><?php echo getoption("paymentinstruction") ?></textarea>
						<input type="submit" value="Simpan">
					</form>
					
					<?php
				}else if(isset($_GET["sales"])){
					
					if(isset($_GET["confirm"])){
						
						$paymentid = escsql($_GET["confirm"]);
						
						query("UPDATE $tablepayments SET status = 1 WHERE paymentid = '$paymentid'");
						query("UPDATE $tablepurchases SET paid = 1 WHERE paymentid = '$paymentid'");
						
						?>
						<h1>Konfirmasi Pembayaran Pelanggan</h1>
						<p>Pembayaran dengan ID #<?php echo $paymentid ?> telah berhasil dikonfirmasi.</p>
						<?php
					}else{
						?>
						<h1>Penjualan</h1>
						
						<?php
						$sql = "SELECT * FROM $tablepayments ORDER BY id DESC";
						$result = query($sql);
						if($result){
							if(mysqli_num_rows($result) > 0){
								echo "<table class='admintable'><tr><th>ID</th><th>Total</th><th>Status</th></tr>";
								while($row = mysqli_fetch_assoc($result)){
									?>
									<tr>
										<td><a href="?paymentdetails=<?php echo $row["paymentid"] ?>"><?php echo $row["paymentid"] ?></a></td>
										<td>Rp. <?php echo number_format($row["total"]) ?></td>
										<td><?php if($row["status"] == 0){ echo "Belum dikonfirmasi <a href='?sales&confirm=" . $row["paymentid"] . "'>Klik untuk Konfirmasi</a>"; } else { echo "Telah dikonfirmasi"; } ?></td>
									</tr>
									<?php
								}
								echo "</table>";
							}
						}
					}
					
					
					
				}else if(isset($_GET["paymentdetails"])){
					$paymentid = escsql($_GET["paymentdetails"]);
					?>
					<h3>Detil Transaksi #<?php echo $paymentid ?></h3>
				
					<?php
					$sql = "SELECT * FROM $tablepurchases WHERE paymentid = '$paymentid' ORDER BY id DESC";
					$result = query($sql);
					
					$userinfo = "undefined";
					if($result){
						if(mysqli_num_rows($result) > 0){
							$total = 0;
							
							
							//$temprow = mysqli_fetch_assoc($result);
							$currentuserid = mysqli_fetch_assoc(query("SELECT * FROM $tablepurchases WHERE paymentid = '$paymentid' LIMIT 1"))["userid"];
							$usql = "SELECT * FROM $tableusers WHERE id = $currentuserid";
							$uresult = query($usql);
							if($uresult){
								if(mysqli_num_rows($uresult) > 0){
									$userrow = mysqli_fetch_assoc($uresult);
									$userinfo = new stdClass();
									$userinfo->id = $userrow["id"];
									$userinfo->p = $userrow["password"];
									$userinfo->name = $userrow["nickname"];
									$userinfo->email = $userrow["email"];
								}
							}
							
							
							?>
							<p>Pembeli: <?php echo $userinfo->name ?> (<?php echo $userinfo->email ?>)</p>
							<?php
							
							
							echo "<table class='admintable'><tr><th>Judul Buku</th><th>Penulis</th><th>Harga</th></tr>";
							while($row = mysqli_fetch_assoc($result)){
								?>
								<tr>
									<td><?php echo getbookinfo($row["bookid"])["title"] ?></td>
									<td><?php echo getbookinfo($row["bookid"])["author"] ?></td>
									<td><?php echo "Rp. " . number_format($row["price"]) ?></td>
								</tr>
								<?php
								$total += $row["price"];
							}
							echo "</table>";
							echo "<p>Total: Rp. " . number_format($total);
						}
					}
					
					
				}else if(isset($_GET["logout"])){
					unset($_SESSION["bookadmin"]);
					?>
					<script>
						location.href="admin.php";
					</script>
					<?php
				}else if(isset($_GET["editbook"])){
					$id = escsql($_GET["editbook"]);
					$row = mysqli_fetch_assoc(query("SELECT * FROM $tablebooks WHERE id = $id"));
					?>
					<h1>Edit Buku</h1>
					
					<?php
					if(isset($_POST["bookupload"])){
						$title = escsql($_POST["bookupload"]);
						$author = escsql($_POST["author"]);
						$catid = escsql($_POST["category"]);
						$description = escsql($_POST["description"]);
						$price = escsql($_POST["price"]);
						$status = escsql($_POST["status"]);
						query("UPDATE $tablebooks SET title = '$title', author = '$author', catid = $catid, description = '$description', price = $price, status = $status WHERE id = $id");
						?>
						<div class="alertbox">Buku berhasil diperbarui.</div>
						<?php
					}else{
						?>
					
						<form method="post">
							<label>Judul buku</label>
							<input name="bookupload" value="<?php echo $row["title"] ?>">
							<label>Penulis</label>
							<input name="author" value="<?php echo $row["author"] ?>">
							<label>Kategori</label>
							<select name="category">
								<?php
								$result = query("SELECT * FROM $tablecategories ORDER BY title ASC");
								while($crow = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $crow["id"] ?>" <?php if($row["catid"] == $crow["id"]){ echo "selected"; } ?>><?php echo $crow["title"] ?></option>
									<?php
								}
								?>
							</select>
							<br>
							<label>Keterangan</label>
							<textarea name="description"><?php echo $row["description"] ?></textarea>
							<label>Harga</label>
							<input type="number" name="price" value="<?php echo $row["price"] ?>">
							
							<select name="status">
								<option <?php if($row["status"] == 1) {echo "selected";} ?> value=1>Aktif</option>
								<option <?php if($row["status"] == 0) {echo "selected";} ?> value=0>Tidak Aktif</option>
							</select>
							
							<input type="submit" value="Perbarui">
						</form>
						<?php
					}
					
				}
				else{
					?>
					<h1>Buku</h1>
					
					<h3>Buku yang sudah ditambahkan</h3>
					
					
					<?php
					
					$sql = "SELECT * FROM $tablebooks ORDER BY id DESC";
					$result = query($sql);
					if($result){
						if(mysqli_num_rows($result) > 0){
							while($row = mysqli_fetch_assoc($result)){
								?>
								<a href="?editbook=<?php echo $row["id"] ?>"><img src="bookcovers/<?php echo $row["cover"] ?>" style="display: inline-block; vertical-align: top; width: 64px;<?php if($row["status"] == 0){ echo " filter: grayscale(100%)"; } ?>"></a>
								<?php
							}
						}else{
							echo "<p>Belum ada buku yang ditambahkan.</p>";
						}
					}
					
					?>
					<h3>Tambah buku baru</h3>
					
					<div id="bookuploadform">
						<form action="bookupload.php" id="bookupload" name="bookupload" method="post" enctype="multipart/form-data">
							<label>Judul buku</label>
							<input name="bookupload">
							<label>Penulis</label>
							<input name="author">
							<label>Kategori</label>
							<select name="category">
								<?php
								$result = query("SELECT * FROM $tablecategories ORDER BY title ASC");
								while($row = mysqli_fetch_assoc($result)){
									?>
									<option value="<?php echo $row["id"] ?>"><?php echo $row["title"] ?></option>
									<?php
								}
								?>
							</select>
							<br>
							<label>Keterangan</label>
							<textarea name="description"></textarea>
							<label>Harga</label>
							<input type="number" name="price">
							
							<label>Cover Buku (188 * 256 px)</label>
							<input name="cover" type="file" accept="image/*">
							
							<label>File PDF</label>
							<input name="upload_file" type="file">
							
							<input type="submit" value="Tambahkan" onclick="uploadbook()">
						</form>
					</div>
					<script>
					function uploadbook(){
						$('#bookupload').ajaxForm({
							beforeSubmit: function() {
								$("#bookuploadform").html("Proses upload telah dimulai!");
							},

							uploadProgress: function(event, position, total, percentComplete) {
								$("#bookuploadform").html("Sedang upload: " + percentComplete + "%");
							},

							success: function() {
								$("#bookuploadform").html("Upload usai!");
								setTimeout(function(){
									
									location.href = "admin.php";
									
								}, 2000);
							},

							complete: function(xhr) {
								console.log("Done!");
								/*
								if(xhr.responseText)
								{
									document.getElementById("output_image").innerHTML=xhr.responseText;
								}
								*/
							}
						});
					}
					</script>
					<?php
				}
				
			}else{
				
				if(isset($_POST["username"])){
					$username = $_POST["username"];
					$password = $_POST["password"];
					
					if($username == $bookadminusername && $password == $bookadminpassword){
						echo "You are right";
						$_SESSION["bookadmin"] = $username;
						?>
						<script>
							location.href="admin.php";
						</script>
						<?php
					}else{
						echo "Wrong!";
					}
				}else{
					?>
					<form method="post">
						<label>Username</label>
						<input type="text" name="username">
						<label>Password</label>
						<input type="password" name="password">
						<input type="submit" value="Login">
					</form>
					<?php
				}
			}
			
			?>
			
		</div>
	</body>
</html>