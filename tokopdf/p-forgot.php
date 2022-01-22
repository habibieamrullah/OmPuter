<h3>Reset Password</h3>

<?php

if(isset($_GET["rcode"])){
	$rcode = escsql($_GET["rcode"]);
	//echo $rcode;
	
	$sql = "SELECT * FROM $tableusers WHERE resetcode = '$rcode'";
	$result = query($sql);
	if($result){
		
		if(mysqli_num_rows($result) > 0){
			
			if(isset($_POST["newpassword"])){
				$newpassword = md5(escsql($_POST["newpassword"]));
				query("UPDATE $tableusers SET password = '$newpassword', resetcode = '' WHERE resetcode = '$rcode'");
				?>
				<p>Password baru Anda telah disimpan</p>
				<script>
					setTimeout(function(){
						location.href = baseurl;
					}, 3000);
				</script>
				<?php
			}else{
				
				?>
				<form method="post">
					<label>Masukkan password baru Anda</label>
					<input name="newpassword" placeholder="Password baru" type="password">
					<input type="submit" value="Simpan" class="submitbutton">
				</form>
				<?php
				
			}
			
		}else{
			echo "Link tidak valid!";
			?>
			<script>
				setTimeout(function(){
					location.href = baseurl;
				},3000);
			</script>
			<?php
		}
	}else{
		
	}
	
}else{
	if(isset($_POST["forgotpasswordemail"])){
		$email = escsql($_POST["forgotpasswordemail"]);
		
		$sql = "SELECT * FROM $tableusers WHERE email = '$email'";
		$result = query($sql);
		if($result){
			if(mysqli_num_rows($result) > 0){
				$rcode = randchar(20);
				query("UPDATE $tableusers SET resetcode = '$rcode' WHERE email = '$email'");
				?>
				<p>Kami telah mengirimkan link untuk reset password. Silakan cek inbox email Anda.</p>
				<?php
				
				$recipient = $email;
				$subject = "Permintaan Reset Password";
				
				$message = "<p>Halo.</p><p>Silakan klik link ini untuk reset passwordnya yah: <a href='".$baseurl. "?forgotpassword&rcode=" . $rcode . "'>".$baseurl. "?forgotpassword&rcode=" . $rcode . "</a></p><p>Terima kasih.</p>";

				
				?>
				<div id="sendmail">
					<script>
						$.post("<?php echo $baseurl . "async.php" ?>", {
							"sendmail" : "<?php echo $email ?>",
							"subject" : "<?php echo $subject ?>",
							"message" : "<?php echo $message ?>",
						}, function(data){
							console.log(data);
						});
						$("#sendmail").remove();
					</script>
				</div>
				<?php

			}else{
				?>
				<p>Email tidak ditemukan!</p>
				<script>
					setTimeout(function(){
						window.history.back();
					}, 3000);
				</script>
				<?php
			}
		}
	}else{
		?>
		<form method="post">
			<label>Ketik alamat email Anda yang digunakan untuk mendaftar:</label>
			<input type="email" name="forgotpasswordemail">
			<input type="submit" value="Kirim Permintaan" class="submitbutton">
		</form>
		<?php
	}
}

?>

