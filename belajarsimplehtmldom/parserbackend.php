<?php


include("simple_html_dom.php");


if(isset($_POST["pageurl"])){
	
	$url = $_POST["pageurl"];	
	$html = file_get_html($url);
	
	$links = "";
	
	foreach($html->find(".listing-title") as $lt){
		
		$link = $lt->find(".track-click", 0)->href . ",";
		$links .= $link;
		
	}
	
	echo $links;

}




if(isset($_POST["url"])){
	
	$connection = mysqli_connect("localhost", "root", "", "mydatabase");
	$rumah123 = $_POST["url"];
	$subhmtl = file_get_html($rumah123);
		
	$title = $subhmtl->find(".r123-listing-summary-v2__title", 0)->plaintext;
	$price = $subhmtl->find(".r123-listing-summary-v2__price", 0)->plaintext;
	$description = $subhmtl->find(".ui-molecules-toggle", 0)->plaintext;
	$image = $subhmtl->find("picture", 0)->find("img", 0)->src;

	$imagename = explode("/", $image);
	$imagename = end($imagename);
	$destination = "images/" . $imagename;

	file_put_contents($destination, file_get_contents($image));

	mysqli_query($connection, "INSERT INTO properti123 (title, price, description, image, rumah123) VALUES ('$title', '$price', '$description', '$imagename', '$rumah123')");

	echo 1;
}

?>