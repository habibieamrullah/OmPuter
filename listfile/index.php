<!DOCTYPE html>
<html>
	<head>
		<title>Om Puter</title>		
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	</head>
	<body>
		
		<label>Ketik untuk cari cepat:</label>
		<input id="caricepat" onkeyup="cariCepat()">
		<?php
		
		$direktori = "uploads";
		
		foreach(scandir($direktori) as $item){
			if($item == "." || $item == ".."){
				
			}else{
				?>
				<div class="gambar">
					<img src='uploads/<?php echo $item ?>' style='width: 128px; margin: 10px; display: inline-block; border: 1px solid black; vertical-align: top;'>
					<p><?php echo $item ?></p>
				</div>
				
				<?php
			}
			
		}
		
		?>
		
		<script>
		function cariCepat(){
			
			var kataYangDicari = $("#caricepat").val();
			
			$(".gambar").each(function(){
				if($(this).html().toLowerCase().indexOf(kataYangDicari.toLowerCase()) > -1){
					$(this).show();
				}else{
					$(this).hide();
				}
			});
			
		}
		</script>
		
	</body>
</html>