<?php
if(isset($_POST["email"])){
	$email = escsql($_POST["email"]);
	$password = md5(escsql($_POST["password"]));
	$sql = "SELECT * FROM $tableusers WHERE email = '$email' AND password = '$password'";
	$result = query($sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			if($row["confirmed"] == 0){

				?>
				<p>Kamu belum mengkonfirmasi pendaftaran akun Ciihuy. Klik <a href="?resendemail=<?php echo $row["id"] ?>">di sini</a> untuk kirim ulang email konfirmasi dan klik link di dalamnya.</p>
				<?php

			}else{
				$_SESSION["bookstoreuser"] = $row["email"];
				?>
				<p>Selamat datang! Tunggu sejenak, Anda akan diarahkan ke area akun Anda.</p>
				<script>
					setTimeout(function(){
						location.href="<?php echo $baseurl ?>";
					},100);
				</script>
				<?php
			}
		}else{
			echo "Account not found!";
		}
	}else{
		echo "Account not found!";
	}
}else{
	?>
	
	<h2>Login</h2>
	<form method="post">
		<label>Email</label>
		<input type="email" name="email" style="width: 100%;" placeholder="Email">
		<label>Password</label>
		<input type="password" name="password" style="width: 100%;" placeholder="Password">
		<input class="submitbutton" type="submit" value="Login">
	</form>
	<p>Belum punya akun? Klik <a href="?signup">di sini</a> untuk daftar.</p>	
	<p>Lupa password? Klik <a href="?forgotpassword">di sini</a> untuk reset password</p>

	
	<?php
}
?>