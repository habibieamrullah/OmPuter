<?php

$data = "Ini adalah tulisan saya";
$myfile = fopen("data.txt", "w") or die("Orror file tidak bisa dibuat!");
fwrite($myfile, $data);
fclose($myfile);