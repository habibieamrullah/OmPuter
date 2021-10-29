<!DOCTYPE html>
<html>
	<head>
		<title>Om Puter</title>		
		<script src="jquery.min.js"></script>
	</head>
	<body>
	
		
		<input id="nama" placeholder="nama">
		<button onclick="submitNama()">Kirim</button>
	
		
		<script>
			
			function submitNama(){
				
				var nama = $("#nama").val();
				
				$.get("backend.php?nama=" + nama , function(data){
					console.log(data);
				});

				
			}
			
		</script>
		
	</body>
</html>