<h3>Konfirmasi Pendaftaran</h3>
<?php
$c = escsql($_GET["regconfirm"]);
$sql = "SELECT * FROM $tableusers WHERE uniqid = '$c' AND confirmed = 0";
$result = query($sql);
if($result){
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);
		query("UPDATE $tableusers SET confirmed = 1 WHERE uniqid = '$c'");
		$_SESSION["bookstoreuser"] = $row["email"];
		?>
		<p>Terima kasih telah mendaftar. Anda akan diarahkan ke area akun Anda.</p>
		<script>
			setTimeout(function(){
				location.href="<?php echo $baseurl ?>?account";
			},3000);
			
			$.post("<?php echo $baseurl . "async.php" ?>", {
				"sendmail" : "<?php echo $adminemail ?>",
				"subject" : "Notifikasi Pendaftaran Anggota Baru di <?php echo getoption("sitetitle") ?>",
				"message" : "Halo Admin, <?php echo $row["email"] ?> telah terdaftar di <?php echo getoption("sitetitle") ?>.",
			}, function(data){
				console.log(data);
			});
			$("#sendmail").remove();
		</script>
		<?php
	}else{
		?>
		<p>Mohon maaf, link tidak valid.</p>
		<?php
	}
}