<?php
include("init-admin.php");
if(isset($_POST["bookupload"])){
	
	
	
	$title = escsql($_POST["bookupload"]);
	$author = escsql($_POST["author"]);
	$category = escsql($_POST["category"]);
	$description = escsql($_POST["description"]);
	$price = escsql($_POST["price"]);
	
	include("compressimage.php");
	$cover = uploadAndResize("Cover-" . randnum(10), "cover", "bookcovers", 256);
	$uploadfile = $_FILES["upload_file"]["tmp_name"];
	$folder="pdfuplds/";
	$pdf = "pdf-" . randnum(10) . ".pdf";
	if(!file_exists("pdfuplds"))
		mkdir("pdfuplds");
	move_uploaded_file($_FILES["upload_file"]["tmp_name"], $folder . $pdf);
	
	query("INSERT INTO $tablebooks (title, author, catid, description, price, cover, pdf, status) VALUES ('$title', '$author', $category, '$description', $price, '$cover', '$pdf', 1)");
	
	exit();
}
?>