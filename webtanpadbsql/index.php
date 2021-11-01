<!DOCTYPE html>
<html>
	<head>
		<title>Om Puter</title>
		<script src="jquery.min.js"></script>
	</head>
	<body>
	
		<?php
		
			$item = array();
			
			$data = "";
			if(file_exists("data.txt"))
				$data = file_get_contents("data.txt");
			if($data != "")
				$item = json_decode($data);
			
		?>
		
		
		<div id="tambahdata" class="halaman">
			<h2>Tambah Data</h2>
			<input id="itembaru">
			<button onclick="tambahitem()">Tambah Item</button>
		</div>
		
		<div id="editdata" class="halaman">
			<h2>Edit Data</h2>
			<input id="edititem">
			<button id="tombolsimpan">Simpan</button>
		</div>
		
		<div id="listitem"></div>
		
		
		
		
		<script>
			
			var item = <?php echo json_encode($item) ?>;
			
			function listitem(){
				$("#listitem").html("");
				
				var nomorurut = 1;
				
				for(var i = 0; i < item.length; i++){
					$("#listitem").append(nomorurut + ". " + item[i].item + " (ID# " + item[i].id + ") |<span style='color: green; cursor: pointer;' onclick='edititem(" + i + ")'> edit</span> | <span style='color: red; cursor: pointer;' onclick='hapusitem(" + i + ")'>hapus</span> <br>");
					
					nomorurut++;
				}
			}
			
			listitem();
			
			function tambahitem(){
				var iditem;
				
				if(item.length == 0){
					iditem = 0;
				}else{
					iditem = item[item.length-1].id + 1;
				}
				
				var itembaru = $("#itembaru").val();
				
				
				item.push({
					"id" : iditem,
					"item" : itembaru
				});
				
				kirimdata();
			}
			
			function kirimdata(){
				$.post("async.php", {
					"item" : JSON.stringify(item)
				}, function(data){
					//alert(data);
					//location.reload();
					listitem();
					$("#itembaru").val("").focus();
				});
			}
			
			
			function hapusitem(idx){
				item.splice(idx, 1);
				kirimdata();
			}
			
			
			$("#editdata").hide();
			
			function edititem(idx){
				$("#tambahdata").hide();
				$("#editdata").show();
				$("#edititem").val(item[idx].item);
				$("#tombolsimpan").attr("onclick", "simpandatabaru("+idx+")");
			}
			
			function simpandatabaru(idx){
				var databaru = $("#edititem").val();
				item[idx].item = databaru;
				kirimdata();
			}
			
		</script>
	
	</body>
</html>