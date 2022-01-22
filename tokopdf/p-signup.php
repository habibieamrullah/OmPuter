<?php
if(isset($_POST["email"])){
	
	?>
	<h3>Daftar</h3>
	<?php
	
	$nickname = escsql($_POST["nickname"]);
	$email = escsql($_POST["email"]);
	$password = md5(escsql($_POST["password"]));
	
	if($email != "" && $password != ""){
	
		$sql = "SELECT * FROM $tableusers WHERE email = '$email'";
		$result = query($sql);
		if($result){
			if(mysqli_num_rows($result) > 0){
				echo "<p>Email ini sudah terdaftar sebelumnya.</p>";
			}else{
				
				$uniqid = uniqid();
				$ts = getCurrentMillisecond();
				query("INSERT INTO $tableusers (nickname, email, password, uniqid, confirmed, timestamp) VALUES ('$nickname', '$email', '$password', '$uniqid', 0, '$ts')");
				
				$emailsubject = "Selamat datang! Anda telah terdaftar.";
				$emailcontent = "<p>Halo " . $nickname. ",<br>Terima kasih udah daftar.</p><p>Klik <a href='" . $baseurl . "?regconfirm=" . $uniqid . "'>di sini</a> untuk konfirmasi pendaftaranmu. Kalau tidak bisa diklik, copy paste aja teks link di bawah ini ya:</p><p><a href='" . $baseurl . "?regconfirm=" . $uniqid . "'>" . $baseurl . "?regconfirm=" . $uniqid . "</a></p>";
				
				echo "<p>Terima kasih sudah mendaftar. Silahkan cek email Anda dan klik link verifikasi yang kami kirimkan.</p>";
				
				?>
				<div id="sendmail">
					<script>
						$.post("<?php echo $baseurl . "async.php" ?>", {
							"sendmail" : "<?php echo $email ?>",
							"subject" : "<?php echo $emailsubject ?>",
							"message" : "<?php echo $emailcontent ?>",
						}, function(data){
							console.log(data);
						});
						$("#sendmail").remove();
					</script>
				</div>
				<?php
				
			}
		}
	}else{
		echo "<p>Maaf, data tidak lengkap.</p>";
	}
	
}else{	
	?>

	<h3>Daftar</h3>
	<form method="post">
		<label>Nama</label>
		<input type="text" name="nickname" style="width: 100%;" placeholder="Nama">
		<label>Email</label>
		<input type="email" name="email" style="width: 100%;" placeholder="Email">
		<label>Password</label>
		<input type="password" name="password" style="width: 100%;" placeholder="Password">
		
		<p>Dengan mendaftarkan diri, berarti Anda setuju dengan <a href="doc-kebijakanprivasi.html">Kebijakan Privasi</a> dan <a href="doc-syaratketentuan.html">Syarat dan Ketentuan</a> kami.</p>
		
		<input class="submitbutton" type="submit" value="Daftar">
	</form>
	<p>Sudah punya akun? Klik <a href="?account">di sini</a> untuk masuk.</p>

	<?php
}
?>
