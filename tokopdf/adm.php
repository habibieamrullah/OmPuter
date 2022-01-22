<?php include("init-admin.php") ?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<title>Admin Page</title>

		<script src="js/jscolor.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="style-admin.css">
	</head>
	<body>
	
		<div id="maincontainer">
		
			<?php
			
			if(isset($_SESSION["ciihuyadmin"])){
				
				?>
				<p><a href="adm.php">Home</a> <!--| <a href="?userpayments">User Payments</a>--> | <a href="?settings">General Settings</a> | <a href="?logout">Logout</a></p>
				<?php
				
				if(isset($_GET["userdetail"])){
					?>
					<h1>User Details</h1>
					<?php
					$id = escsql($_GET["userdetail"]);
					$sql = "SELECT * FROM $tableusers WHERE id = $id";
					$result = query($sql);
					if($result){
						if(mysqli_num_rows($result) > 0){
							$row = mysqli_fetch_assoc($result);
							?>
							<p>Nickname: <?php echo $row["nickname"] ?></p>
							<p>Email: <?php echo $row["email"] ?></p>
							<p>Confirmed: <?php echo $row["confirmed"] ?></p>
							
							<h2>Payments</h2>
							<?php
							$psql = "SELECT * FROM $tablepurchases WHERE userid = $id ORDER BY id DESC";
							$presult = query($psql);
							if($presult){
								if(mysqli_num_rows($presult) > 0){
									while($prow = mysqli_fetch_assoc($presult)){
										?>
										<p>Payment ID: <a href="?paymentdetails=<?php echo $prow["id"] ?>"><?php echo $prow["uniqid"] ?></a></p>
										<?php
									}
								}
							}
							?>
							
							<p>Delete this user? <a href="?deleteuser=<?php echo $id ?>">Click here</a>.</p>
							
							<?php
						}
					}
				}else if(isset($_GET["deleteuser"])){
					$id = escsql($_GET["deleteuser"]);
					query("DELETE FROM $tableusers WHERE id = $id");
					echo "<p>User deleted!</p>";
				}else if(isset($_GET["userpayments"])){
					?>
					<h1>User Payments</h1>
					<?php
					
					if(isset($_GET["delete"])){
						$id = escsql($_GET["delete"]);
						query("DELETE FROM $tablepurchases WHERE id = $id");
						echo $id;
						?>
						<script>
						location.href="?userpayments";
						</script>
						<?php
					}else{
						$sql = "SELECT * FROM $tablepurchases ORDER BY id DESC";
						$result = query($sql);
						
						$totalpayments = 0;
						
						if($result){
							if(mysqli_num_rows($result) > 0){
								?>
								<table class="admintable">
									<tr>
										<th>Payment ID</th>
										<th>Nickname</th>
										<th>Email</th>
										<th>Coin Code</th>
										<th>Amount (USD)</th>
										<th>Amount (IDR)</th>
										<th>Status</th>
										<th>Delete?</th>
									</tr>
									<?php
									while($row = mysqli_fetch_assoc($result)){
										
										$userinfo = getuserinfo($row["userid"]);
										$status = "Unconfirmed";
										if($row["status"] == 1){
											$status = "Confirmed";
										}else if($row["status"] == 2){
											$status = "Confirmation Requested";
										}else if($row["status"] == 3){
											$status = "Temporary Confirmed";
										}else{
											$status = "Unconfirmed";
										}
										
										?>
										<tr>
											<td><a href="?paymentdetails=<?php echo $row["id"] ?>"><?php echo $row["uniqid"] ?></a></td>
											<td><?php echo $userinfo["nickname"] ?></td>
											<td><?php echo $userinfo["email"] ?></td>
											<td><?php echo $row["coincode"] ?></td>
											<td style="text-align: right;">$<?php echo number_format($row["amount"],2) ?></td>
											<td style="text-align: right;">Rp. <?php echo number_format($row["amount"] * getoption("exchangerate")) ?></td>
											<td><?php echo $status ?></td>
											<td><a href="?userpayments&delete=<?php echo $row["id"] ?>">Delete</td>
										</tr>
										<?php
										
										$totalpayments += $row["amount"];
										
									}
									?>
								</table>
								
								<p>Total payments: $<?php echo number_format($totalpayments, 2) ?> (Rp. <?php echo number_format($totalpayments * getoption("exchangerate")) ?>)</p>
								<?php
							}else{
								echo "No Record.";
							}
						}
					}
				}else if(isset($_GET["paymentdetails"])){
					?>
					<h1>Payment Details</h1>
					<?php
					$id = escsql($_GET["paymentdetails"]);
					$sql = "SELECT * FROM $tablepurchases WHERE id = $id";
					$result = query($sql);
					if($result){
						if(mysqli_num_rows($result) > 0){
							$row = mysqli_fetch_assoc($result);
							
							if(isset($_GET["confirmed"])){
								query("UPDATE $tablepurchases SET status = 1 WHERE id = $id");
								if($row["status"] != 3){
									$pamount = $row["amount"];
									$userinfo = getuserinfo($row["userid"]);
									$userid = $userinfo["uniqid"];
									$newbalance = $userinfo["balance"] . $pamount;
									query("UPDATE $tableusers SET balance = $newbalance WHERE uniqid = '$userid'");
									
									$useremail = $userinfo["email"];
									include("mailing.php");
									if($row["lang"] == "id"){
										sendmail($useremail, "Pembelian Kode Koin Ciihuy Anda Terkonfirmasi", "<p>Halo" . $userinfo["nickname"] . "</p><p>Pembayaran kamu dengan ID " . $row["uniqid"] . " telah terkonfirmasi.</p><p>Kode Koin Ciihuy kamu adalah:</p><h1>" . spacesep($row["coincode"], 3) . "</h1><p><i>*Masukkan kode koin tanpa spasi.</i></p><p>Silakan login ke halaman akun Anda untuk melihat detil Kode Koin yang dibeli.</p><p>Terima kasih.</p>");
									}else{
										sendmail($useremail, "Ciihuy Coin Code Payment Confirmation", "<p>Dear" . $userinfo["nickname"] . "</p><p>Your payment with ID " . $row["uniqid"] . " has been confirmed.</p><p>Your Ciihuy Coin Code is:</p><h1>" . spacesep($row["coincode"], 3) . "</h1><p><i>*Enter your coin code without spaces.</i></p><p>Please login to see your Coin Code order details.</p><p>Thank you.</p>");
									}
								}
								?>
								<p>Payment Confirmed!</p>
								<?php
							}else{
								?>
								<p>Payment ID: <?php echo $row["uniqid"] ?></p>
								<p>Payment Time: <?php echo miltodate($row["timestamp"]) ?></p>
								<p>Used on: <?php echo miltodate($row["usedon"]) ?></p>
								<p>Used by: <?php echo $row["usedip"] ?></p>
								<p>Amount: <?php echo number_format($row["amount"], 2) ?></p>
								<p>Proof: <?php echo $row["proof"] ?></p>
								<?php
								if($row["proof"] != ""){
									?>
									<img src="uploads/<?php echo $row["proof"] ?>" style="width: 128px;">
									<?php
								}
								?>
								<p>Note: <?php echo $row["cnote"] ?></p>
								<?php
								if($row["status"] != 1){
									?>
									<p><a href="?paymentdetails=<?php echo $id ?>&confirmed=true">Confirm this payment</a></p>
									<?php
								}
								
							}
						}
					}
				}else if(isset($_GET["settings"])){
					?>
					<h1>General Settings</h1>
					
					<?php
					if(isset($_POST["sitetitle"])){
						$sitetitle = escsql($_POST["sitetitle"]);
						$primarycolor = escsql($_POST["primarycolor"]);
						$secondarycolor = escsql($_POST["secondarycolor"]);
						$linkcolor = escsql($_POST["linkcolor"]);
						
						setoption("sitetitle", $sitetitle);
						setoption("primarycolor", $primarycolor);
						setoption("secondarycolor", $secondarycolor);
						setoption("linkcolor", $linkcolor);
						
						echo "Saved!";
						
					}else{
						?>
						<form method="post">
							<label>Site Title</label>
							<input type="text" name="sitetitle" value="<?php echo getoption("sitetitle") ?>">
							
							<label>Primary Color</label>
							<input type="text" name="primarycolor" value="<?php echo getoption("primarycolor") ?>" data-jscolor="{}"> 
							
							<label>Secondary Color</label>
							<input type="text" name="secondarycolor" value="<?php echo getoption("secondarycolor") ?>" data-jscolor="{}"> 
							
							<label>Link Color</label>
							<input type="text" name="linkcolor" value="<?php echo getoption("linkcolor") ?>" data-jscolor="{}"> 
							
							<input type="submit" value="Save">
						</form>
						<?php
					}
				}else if(isset($_GET["logout"])){
					unset($_SESSION["ciihuyadmin"]);
					?>
					<script>
						location.href="adm.php";
					</script>
					<?php
				}else{
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
									<th>Nickname</th>
									<th>Email</th>
								</tr>
								<?php
								while($row = mysqli_fetch_assoc($result)){
									?>
									<tr>
										<td><a href="?userdetail=<?php echo $row["id"] ?>"><?php echo $row["nickname"] ?></a></td>
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
				}
				
			}else{
				
				if(isset($_POST["username"])){
					$username = $_POST["username"];
					$password = $_POST["password"];
					
					if($username == $adminusername && $password == $adminpassword){
						echo "You are right";
						$_SESSION["ciihuyadmin"] = $username;
						?>
						<script>
							location.href="adm.php";
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