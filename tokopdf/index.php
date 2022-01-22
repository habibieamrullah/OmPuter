<?php include("init.php") ?>

<?php

if(isset($_SESSION["bookstoreuser"])){
	
	$currentuseremail = escsql($_SESSION["bookstoreuser"]);
	$sql = "SELECT * FROM $tableusers WHERE email = '$currentuseremail'";
	$result = query($sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$userinfo = new stdClass();
			$userinfo->id = $row["id"];
			$userinfo->p = $row["password"];
			$userinfo->name = $row["nickname"];
			$userinfo->email = $row["email"];
		}
	}
	
}

function catidtoname($catid){
	global $tablecategories;
	return mysqli_fetch_assoc(query("SELECT * FROM $tablecategories WHERE id = $catid"))["title"];
}

function getbookinfo($bookid){
	global $tablebooks;
	return mysqli_fetch_assoc(query("SELECT * FROM $tablebooks WHERE id = $bookid"));
}

function bookidtothumb($bookid){
	global $tablebooks;
	$result = query("SELECT * FROM $tablebooks WHERE id = $bookid");
	if($result){
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			?>
			<div class="homebookthumb">
				<a href="?bookinfo=<?php echo $row["id"] ?>">
					<img src="bookcovers/<?php echo $row["cover"] ?>" style="width: 100%;">
					<div>
						<h3><?php echo $row["title"] ?></h3>
						<p><?php echo $row["author"] ?></p>
						<h4 style="color: <?php echo getoption("primarycolor") ?>;"><b>Rp. <?php echo number_format($row["price"]) ?></b></h4>
					
					</div>
				</a>
				<button class="addtocartbutton" onclick="removefromcart(<?php echo $bookid ?>)"><i class="fa fa-trash"></i> Hapus</button>
			</div>
			<?php
		}
	}
}

function showbooks($sql){
	global $tablepurchases;
	global $tablebooks;
	global $userinfo;
	$result = query($sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				?>
				<div class="homebookthumb">
					<a href="?bookinfo=<?php echo $row["id"] ?>">
						<img src="bookcovers/<?php echo $row["cover"] ?>" style="width: 100%;">
						<div>
							<h3><?php echo $row["title"] ?></h3>
							<p><?php echo $row["author"] ?></p>
							<h4 style="color: <?php echo getoption("primarycolor") ?>;"><b>Rp. <?php echo number_format($row["price"]) ?></b></h4>
						
						</div>
					</a>
					<?php
					if(isset($_SESSION["bookstoreuser"])){
						$bookid = $row["id"];
						$psql = "SELECT * FROM $tablepurchases WHERE bookid = $bookid AND userid = $userinfo->id";
						$presult = query($psql);
						if(mysqli_num_rows($presult) > 0){
								$prow = mysqli_fetch_assoc($presult);
								if($prow["paid"] == 0){
								?>
								<button class="viewcartbutton" onclick="viewcart()"><i class="fa fa-shopping-cart"></i> Lihat Keranjang</button>
								<?php
							}else if($prow["paid"] == 2){
								?>
								<button class="viewcartbutton" onclick="viewpayments('<?php echo $prow["paymentid"] ?>')"><i class="fa fa-hourglass-half"></i> Menunggu Pembayaran</button>
								<?php
							}else if($prow["paid"] == 1){
								?>
								<button class="viewcartbutton" onclick="readbook(<?php echo $bookid ?>)"><i class="fa fa-book"></i> Baca Buku</button>
								<?php
							}
						}else{
							?>
							<button class="addtocartbutton" onclick="addtocart(<?php echo $row["id"] ?>)"><i class="fa fa-shopping-cart"></i> Tambahkan</button>
							<?php
						}
					}else{
						?>
						<button class="addtocartbutton" onclick="addtocart(<?php echo $row["id"] ?>)"><i class="fa fa-shopping-cart"></i> Tambahkan</button>
						<?php
					}
					?>
				</div>
				<?php
			}
		}else{
			echo "<p>Belum ada buku</p>";
		}
	}
}






?>

<!DOCTYPE html>
<html>
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<title><?php echo getoption("sitetitle") ?></title>
		<script src="js/jquery/jquery.min.js"></script>
		<script src="js/jscolor.min.js"></script>
		<script src="js/bookstore.js"></script>
		<script>
			var baseurl = "<?php echo $baseurl ?>";
		</script>
		
		<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
		
		<?php include("style.php") ?>
		
		<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
        <script type="text/javascript" src="slick/slick.min.js"></script>
		
		
	</head>
	<body>
		
		<!-- top color art -->
		<div class="topcolorart"></div>
		
		<!-- header-->
		<div class="maxwidtha">
			<div style="width: 100%; margin-bottom: 10px; display: table;">
			
				<div class="tcell" style="vertical-align: middle; width: 2em;">
					<a href="<?php echo $baseurl ?>" style="color: inherit;"><img src="images/icon.png" style="width: 32px; display: inline-block; vertical-align: middle;"></a>
				</div>
				
				<div class="tcell" style="vertical-align: middle; width: 20%;">
					<a href="<?php echo $baseurl ?>" style="color: inherit;"><h1 id="headertext" style="margin: 0px; display: inline-block; vertical-align: middle; margin-left: 0.5em; font-size: 18px;"><?php echo getoption("sitetitle") ?></h1></a>
				</div>
				
				<div class="tcell" style="vertical-align: middle; width: 60%;">
					<div style="width: 100%; box-sizing: border-box; padding: 0.5em;">
						<div style="width: 100%; display: table; box-sizing: border-box;">
							<div style="display: table-cell; background-color: #ebebeb;"><input id="searchq" style="background-color: inherit; color: gray; width: 100%; padding: 10px; box-sizing: border-box; border: none; outline: none;"></div>
							<div style="display: table-cell; background-color: <?php echo getoption("primarycolor") ?>; text-align: center; color: white; cursor: pointer; padding: 0.5em;" onclick="search()"><i class="fa fa-search"></i></div>
						</div>
					</div>
				</div>
				
				<div class="tcell" style="vertical-align: middle; width: 5em; text-align: right;">
					<!--<a href="?cart"><i class="fa fa-shopping-cart" style="margin: 0.5em;"></i></a>-->
					<a href="?account"><i class="fa fa-user" style="margin: 0.5em;"></i><span class="hideonmobile"> Akun</span></a>
				</div>
				
			</div>
		</div>
		
		<!-- book categories -->
		<div class="hideondesktop" align="center" onclick="togglebookcat()">
			<i class="fa fa-bars"></i> Kategori Buku
		</div>
		<div class="hideonmobile" id="bookcat">
			<div class="maxwidthb" style="padding-top: 30px;">
				<?php
				$sql = "SELECT * FROM $tablecategories ORDER BY title ASC";
				$result = query($sql);
				if($result){
					if(mysqli_num_rows($result) > 0){
						while($row = mysqli_fetch_assoc($result)){
							?>
							<a href="?catid=<?php echo $row["id"] ?>"><div class="categorymenuitem"><?php echo $row["title"] ?></div></a>
							<?php
						}
					}
				}
				?>
			</div>
		</div>
		
		<!-- home slider -->
		<div class="hideonmobile">
			<div id="homesliders" style="width: 100%;">
				<?php
				$sql = "SELECT * FROM $tablesliders ORDER BY id DESC";
				$result = query($sql);
				if($result){
					if(mysqli_num_rows($result) > 0){
						while($row = mysqli_fetch_assoc($result)){
							?>
							<div style="width: 100%;">
								<a href="<?php echo $row["link"] ?>"><img src="<?php echo "uploads/" . $row["image"] ?>" style="width: 100%;"></a>
							</div>
							<?php
						}
					}
				}
				?>
			</div>
		</div>
		<script>
			$("#homesliders").slick({
				autoplay: true,
				infinite: true,
				pauseOnFocus: false,
				pauseOnHover: false,
				autoplaySpeed: 2300,
				arrows : false,
			});
		</script>
		
		
		<?php
		if(isset($_GET["bookinfo"])){
			//book info
			
			$id = escsql($_GET["bookinfo"]);
			$result = query("SELECT * FROM $tablebooks WHERE id = $id");
			if($result){
				if(mysqli_num_rows($result) > 0){
					$row = mysqli_fetch_assoc($result);
					?>
					<div class="maxwidtha" style="padding-top: 30px;">
						<h1 style="margin-bottom: 10px;"><?php echo $row["title"] ?></h1>
						<div style="display: table; width: 100%;">
							<div style="display: table-cell; width: 25%; vertical-align: top;">
								<img src="bookcovers/<?php echo $row["cover"] ?>" style="width: 100%;">
							</div>
							<div style="display: table-cell; width: 70%; vertical-align: top; padding-left: 14px;">
								<p><b>Judul: </b><?php echo $row["title"] ?></p>
								<p><b>Penulis: </b><?php echo $row["author"] ?></p>
								<div><?php echo nl2br($row["description"]) ?></div>
								
								<?php
								if(isset($_SESSION["bookstoreuser"])){
									$bookid = $row["id"];
									$psql = "SELECT * FROM $tablepurchases WHERE bookid = $bookid AND userid = $userinfo->id";
									$presult = query($psql);
									if(mysqli_num_rows($presult) > 0){
											$prow = mysqli_fetch_assoc($presult);
											if($prow["paid"] == 0){
											?>
											<button class="viewcartbutton" onclick="viewcart()"><i class="fa fa-shopping-cart"></i> Lihat Keranjang</button>
											<?php
										}else if($prow["paid"] == 2){
											?>
											<button class="viewcartbutton" onclick="viewpayments('<?php echo $prow["paymentid"] ?>')"><i class="fa fa-hourglass-half"></i> Menunggu Pembayaran</button>
											<?php
										}else if($prow["paid"] == 1){
											?>
											<button class="viewcartbutton" onclick="readbook(<?php echo $bookid ?>)"><i class="fa fa-book"></i> Baca Buku</button>
											<?php
										}
									}else{
										?>
										<button class="addtocartbutton" onclick="addtocart(<?php echo $row["id"] ?>)"><i class="fa fa-shopping-cart"></i> Tambahkan</button>
										<?php
									}
								}else{
									?>
									<button class="addtocartbutton" onclick="addtocart(<?php echo $row["id"] ?>)"><i class="fa fa-shopping-cart"></i> Tambahkan</button>
									<?php
								}
								?>
								
							</div>
						</div>
					</div>
					<?php
				}
			}
			
			?>
			<!-- random books -->
			<div class="maxwidtha" style="padding-top: 30px;">
				<h3 style="margin-bottom: 30px;">Buku lainnya yang Anda mungkin tertarik:</h3>
				<?php
				
				$sql = "SELECT * FROM $tablebooks WHERE status = 1 ORDER BY rand() LIMIT 14";
				$result = query($sql);
				if($result){
					echo "<div id='randombooks'>";
					if(mysqli_num_rows($result) > 0){
						while($row = mysqli_fetch_assoc($result)){
							?>
							<div style="padding: 14px;"><a href="?bookinfo=<?php echo $row["id"] ?>"><img src="bookcovers/<?php echo $row["cover"] ?>" style="width: 100%;"></a></div>
							<?php
						}
						
					}
					echo "</div>";
					?>
					<script>
					$("#randombooks").slick({
						autoplay: true,
						infinite: true,
						slidesToShow: 6,
						slidesToScroll: 1,
						pauseOnFocus: false,
						pauseOnHover: false,
						autoplaySpeed: 2300,
						arrows : false,
					});
					</script>
					<?php
				}
				
				?>
			</div>
			<?php
			
		}
		
		else if(isset($_GET["cart"])){
			//cart
			?>
			<div class="maxwidtha" style="padding-top: 30px;">
				<h1 style="margin-bottom: 10px;">Keranjang Belanja Anda</h1>
			
				<?php
				
				if(isset($_SESSION["bookstoreuser"])){
					
					if(isset($_GET["add"])){
						$id = escsql($_GET["add"]);
						
						$sql = "SELECT * FROM $tablepurchases WHERE bookid = '$id' AND userid = $userinfo->id";
						$result = query($sql);
						if($result){
							if(mysqli_num_rows($result) > 0){
								echo "Buku ini sudah Anda tambahkan sebelumnya.";
							}else{
								echo "Anda telah menambahkan buku baru ke keranjang. Tunggu sejenak, halaman ini akan diperbarui.";
								$ts = getCurrentMillisecond();
								$bookprice = mysqli_fetch_assoc(query("SELECT * FROM $tablebooks WHERE id = $id"))["price"];
								query("INSERT INTO $tablepurchases (bookid, userid, timestamp, price) VALUES ($id, $userinfo->id, '$ts', $bookprice)");
							}
							?>
							<script>
								setTimeout(function(){
									location.href = "?cart";
								}, 2000);
							</script>
							<?php
						}
						
					}else if(isset($_GET["remove"])){
						
						$id = escsql($_GET["remove"]);
						query("DELETE FROM $tablepurchases WHERE bookid = $id AND userid = $userinfo->id");
						?>
						<p>Buku berhasil dihapus dari keranjang belanja Anda. Tunggu sejenak, halaman ini akan diperbarui.</p>
						<script>
							setTimeout(function(){
								location.href = "?cart";
							}, 2000);
						</script>
						<?php
						
					}else if(isset($_GET["checkout"])){
						
						$sql = "SELECT * FROM $tablepurchases WHERE paid = 0 AND userid = $userinfo->id";
						$result = query($sql);
						if($result){
							if(mysqli_num_rows($result) > 0){
								
								$total = 0;
								while($row = mysqli_fetch_assoc($result)){
									$total += $row["price"];
								}
								
								$paymentid = randnum(10);
								?>
								<p>Silahkan melakukan pembayaran sebagaimana yang dijelaskan pada instruksi di bawah ini. Setelah pembayaran terkonfirmasi, Anda dapat mengakses buku-buku yang Anda.</p>
								<h2>Instruksi Pembayaran Faktur <a href="?account&payments&details=<?php echo $paymentid ?>">#<?php echo $paymentid ?></a></h2>
								<div style="border: 1px dashed black; padding: 20px; border-radius: 10px; margin-bottom: 10px;"><?php echo nl2br(getoption("paymentinstruction")) ?></div>
								<p>Instruksi pembayaran ini juga telah dikirimkan ke alamat email Anda: <?php echo $userinfo->email ?></p>
								
								<div id="sendmail">
									<script>
										$.post("<?php echo $baseurl . "async.php" ?>", {
											"sendmail" : "<?php echo $userinfo->email ?>",
											"subject" : "Silakan selesaikan pembayaran Anda #<?php echo $paymentid ?>",
											"message" : "<p>Yang terhormat <?php echo $userinfo->name ?>,<br>Silakan melakukan pembayaran sebesar Rp. <?php echo number_format($total) ?> dengan cara di bawah ini:</p><div><?php echo nl2br(nonewline(getoption("paymentinstruction"))) ?></div><p>Terima kasih.</p>",
										}, function(data){
											console.log(data);
										});
										$("#sendmail").remove();
									</script>
								</div>
								
								<?php
								
								query("UPDATE $tablepurchases SET paymentid = '$paymentid', paid = 2 WHERE paid = 0 AND userid = $userinfo->id");
								$ts = getCurrentMillisecond();
								query("INSERT INTO $tablepayments (paymentid, timestamp, userid, total) VALUES ('$paymentid', '$ts', $userinfo->id, $total)");
							}else{
								echo "<p>Tidak ada data yang ditampilkan.</p>";
							}
						}
						
						
					}else{
						$sql = "SELECT * FROM $tablepurchases WHERE userid = $userinfo->id AND paid = 0 ORDER BY id DESC";
						$result = query($sql);
						if($result){
							if(mysqli_num_rows($result) > 0){
								$total = 0;
								while($row = mysqli_fetch_assoc($result)){
									bookidtothumb($row["bookid"]);
									$total += $row["price"];
								}
								
								?>
								<hr>
								<h2>Total belanja Anda: <span style="color: <?php echo getoption("primarycolor") ?>;">Rp. <?php echo number_format($total) ?></span></h2>
								<button class="viewcartbutton" onclick="checkout()"><i class="fa fa-credit-card"></i> Bayar Sekarang</button>
								<?php
							}else{
								echo "Keranjang belanja Anda kosong.";
							}
						}
					}

				}else{
					?>
					<p>Anda belum masuk. Silahkan <a href="?account">login</a> terlebih dahulu.</p>
					<?php
				}
				?>
			</div>
			<?php
		}
		
		else if(isset($_GET["account"])){
			
			//user account
			
			if(isset($_SESSION["bookstoreuser"])){
				//user account dashboard
				?>
				<div class="maxwidthb" style="padding-top: 30px;">
					<h1>Akun</h1>
					
					<div style="display: table; width: 100%;">
						<div style="display: table-cell; vertical-align: top; width: 128px;">
							<a href="?account"><div class="leftmenuitem">Buku Anda</div></a>
							<a href="?account&payments"><div class="leftmenuitem">Pembayaran</div></a>
							<a href="?logout"><div class="leftmenuitem">Keluar</div></a>
						</div>
						<div style="display: table-cell; vertical-align: top; padding-left: 20px;">
							
							<?php
							if(isset($_GET["payments"])){
								
								if(isset($_GET["details"])){
									$paymentid = escsql($_GET["details"]);
									?>
									<h3>Detil Transaksi #<?php echo $paymentid ?></h3>
									
									<?php
									$sql = "SELECT * FROM $tablepurchases WHERE paymentid = '$paymentid' ORDER BY id DESC";
									$result = query($sql);
									if($result){
										if(mysqli_num_rows($result) > 0){
											$total = 0;
											echo "<table><tr><th>Judul Buku</th><th>Penulis</th><th>Harga</th></tr>";
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
								}else{
									?>
									<h3>Riwayat Pembayaran</h3>
									<?php
									$result = query("SELECT * FROM $tablepayments WHERE userid = $userinfo->id");
									if($result){
										if(mysqli_num_rows($result) > 0){
											echo "<table><tr><th>ID</th><th>Total</th><th>Status</th></tr>";
											while($row = mysqli_fetch_assoc($result)){
												?>
												<tr>
													<td><a href="?account&payments&details=<?php echo $row["paymentid"] ?>"><?php echo $row["paymentid"] ?></a></td>
													<td>Rp. <?php echo number_format($row["total"]) ?></td>
													<td><?php if($row["status"] == 0){ echo "Belum dikonfirmasi"; }else{ echo "Telah dikonfirmasi"; } ?></td>
												</tr>
												<?php
											}
											echo "</table>";
										}else{
											?>
											<p>Belum ada riwayat pembayaran.</p>
											<?php
										}
									}
								}
								
								
							}else if(isset($_GET["readbook"])){
								$bookid = escsql($_GET["readbook"]);
								$sql = "SELECT * FROM $tablepurchases WHERE bookid = $bookid AND paid = 1 AND userid = $userinfo->id";
								$result = query($sql);
								if($result){
									if(mysqli_num_rows($result) > 0){
										?>
										<p>Membaca buku</p>
										<iframe id="reader" src="<?php echo $baseurl ?>reader.php?userid=<?php echo $userinfo->id ?>&p=<?php echo $userinfo->p ?>&bookid=<?php echo $bookid ?>" style="width: 100%; height: 720px;"></iframe>
										
										<p align="center"><a href="<?php echo $baseurl ?>reader.php?userid=<?php echo $userinfo->id ?>&p=<?php echo $userinfo->p ?>&bookid=<?php echo $bookid ?>" download><i class="fa fa-file-pdf-o"></i> Download</a></p>
										<?php
									}
								}
							}else{
								echo "<h3>Buku Anda</h3>";
								$sql = "SELECT * FROM $tablepurchases WHERE userid = $userinfo->id AND paid = 1";
								$result = query($sql);
								if($result){
									if(mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc($result)){
											$bookinfo = getbookinfo($row["bookid"]);
											?>
											<div class="homebookthumb">
												<a href="?bookinfo=<?php echo $bookinfo["id"] ?>">
													<img src="bookcovers/<?php echo $bookinfo["cover"] ?>" style="width: 100%;">
													<div>
														<h3><?php echo $bookinfo["title"] ?></h3>
														<p><?php echo $bookinfo["author"] ?></p>
														<!--<h4 style="color: <?php echo getoption("primarycolor") ?>;"><b>Rp. <?php echo number_format($bookinfo["price"]) ?></b></h4>-->
													
													</div>
												</a>
												<a href="?account&readbook=<?php echo $row["bookid"] ?>"><button class="viewcartbutton"><i class="fa fa-book"></i> Baca Buku</button></a>
											</div>
											<?php
										}
									}else{
										echo "<p>Anda belum memiliki buku.</p>";
									}
								}else{
									echo "<p>Terjadi kesalahan!</p>";
								}
							}
							?>
						</div>
					</div>
				</div>
				<?php
			}else{
				
				//login
				?>
				<div class="maxwidthc" style="padding-top: 30px;">
				<?php
				include("p-login.php");
				?>
				</div>
				<?php
			}
			
		}
		
		else if(isset($_GET["resendemail"])){
			//resend email
			?>
			<div class="maxwidthc" style="padding-top: 30px;">
			<?php
			include("p-resendemail.php");
			?>
			</div>
			<?php
		}
		
		else if(isset($_GET["signup"])){
			//signup
			?>
			<div class="maxwidthc" style="padding-top: 30px;">
			<?php
			include("p-signup.php");
			?>
			</div>
			<?php
		}
		
		else if(isset($_GET["forgotpassword"])){
			//forgot password
			?>
			<div class="maxwidthc" style="padding-top: 30px;">
			<?php
			include("p-forgot.php");
			?>
			</div>
			<?php
		}
		
		else if(isset($_GET["regconfirm"])){
			//registration confirmation
			?>
			<div class="maxwidthc" style="padding-top: 30px;">
			<?php
			include("p-regconfirm.php");
			?>
			</div>
			<?php
		}
		
		
		else if(isset($_GET["catid"])){
			//book by catid
			$catid = escsql($_GET["catid"]);
			?>
			<div class="maxwidthb" style="padding-top: 30px;">
				<h1 style="margin-bottom: 10px;">Buku dalam Kategori "<?php echo catidtoname($catid) ?>"</h1>
				<?php 
				$sql = "SELECT * FROM $tablebooks WHERE status = 1 AND catid = $catid ORDER BY id DESC LIMIT 100";
				showbooks($sql);
				?>
			</div>
			<?php
		}
		
		else if(isset($_GET["search"])){
			//registration confirmation
			$q = escsql($_GET["search"]);
			?>
			<div class="maxwidtha" style="padding-top: 30px;">
				<h1 style="margin-bottom: 10px;">Pencarian "<?php echo $q ?>"</h1>
				<?php
				$sql = "SELECT * FROM $tablebooks WHERE status = 1 AND (title LIKE '%$q%' OR author LIKE '%$q%' OR description LIKE '%$q%') ORDER BY id DESC LIMIT 100";
				showbooks($sql);
				?>
			</div>
			<?php
		}
		
		else if(isset($_GET["logout"])){
			unset($_SESSION["bookstoreuser"]);
			?>
			<script>
				location.href=baseurl;
			</script>
			<?php
		}
		
		else{
			//home
			?>
			
			
			<!-- latest books -->
			<div class="maxwidthb" style="padding-top: 30px;">
				<?php 
				$sql = "SELECT * FROM $tablebooks WHERE status = 1 ORDER BY id DESC LIMIT 100";
				showbooks($sql);
				?>
			</div>
			<?php
		}
		?>
		
		
		
		
		
		<!-- footer -->
		<div id="tfooter" style="width: 100%; text-align: center;">					
			<?php include("p-footer.php"); ?>
		</div>
	
	
		
	</body>
</html>