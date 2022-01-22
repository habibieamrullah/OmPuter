<?php
$id = escsql($_GET["resendemail"]);
$sql = "SELECT * FROM $tableusers WHERE id = $id";
$result = query($sql);
if($result){
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);
		if($row["confirmed"] == 0){
			
			?>
			<p>Email konfirmasi telah dikirimkan. Silahkan cek inbox email Anda.</p>
			<?php
		
			$emailsubject = "Email Verifikasi Pendaftaran";
			$emailcontent = "<p>Halo " . $row["nickname"]. ",<br>Terima kasih udah daftar.</p><p>Klik <a href='" . $baseurl . "?regconfirm=" . $row["uniqid"] . "'>di sini</a> untuk konfirmasi pendaftaran Anda. Jika tidak bisa diklik, copy paste aja teks link di bawah ini ya:</p><p>" . $baseurl . "?regconfirm=" . $row["uniqid"] . "</p>";

			
			?>
			<div id="sendmail">
				<script>
					$.post("<?php echo $baseurl . "async.php" ?>", {
						"sendmail" : "<?php echo $row["email"] ?>",
						"subject" : "<?php echo $emailsubject ?>",
						"message" : "<?php echo $emailcontent ?>",
					}, function(data){
						console.log(data);
					});
					$("#sendmail").remove();
				</script>
			</div>
			<?php
			
		}else{
			?>
			<p>Maaf, terjadi kesalahan!</p>
			<?php
		}
	}else{
		?>
		<p>Maaf, terjadi kesalahan!</p>
		<?php
	}
}