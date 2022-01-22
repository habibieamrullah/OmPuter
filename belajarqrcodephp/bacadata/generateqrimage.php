<?php
    require_once('phpqrcode/qrlib.php'); 
	
	$qrvalue = "Hello...";
    
	$tempDir = "pdfqrcodes/"; 
	$codeContents = $qrvalue; 
	$fileName = 'someqrcode.png'; 
	$pngAbsoluteFilePath = $tempDir.$fileName; 
	$urlRelativeFilePath = $tempDir.$fileName; 
	if (!file_exists($pngAbsoluteFilePath)) { 
		QRcode::png($codeContents, $pngAbsoluteFilePath); 
	}
    
    echo "Done generating QR Code Image."
    
?>