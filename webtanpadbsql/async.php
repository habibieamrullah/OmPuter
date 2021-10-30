<?php

if(isset($_POST["item"])){
	echo "Data yang disubmit: " . $_POST["item"] . " dan data ini akan disimpan ke dalam file teks.";
	
	$data = $_POST["item"];
	$myfile = fopen("data.txt", "w") or die("Error file tidak bisa dibuat!");
	fwrite($myfile, $data);
	fclose($myfile);	
	
}