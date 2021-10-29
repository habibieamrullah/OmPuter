<?php
		
if(isset($_POST["nama"])){
	echo "Ini adalah respons server: Nama kamu adalah: " . $_POST["nama"];
}

if(isset($_GET["nama"])){
	
	$nama = $_GET["nama"];
	
	if($nama == "Jokowi"){
		echo "Respon: Kamu adalah presiden.";
	}else{
		echo "Respon Server: Kamu bukan presiden, tapi " . $nama;
	}
}

?>