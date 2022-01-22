<?php

$baseurl = "http://localhost/OmPuter/tokopdf/";

$adminusername = "habibie";
$adminpassword = "habibie";

$bookadminusername = "habibie";
$bookadminpassword = "habibie";

$adminemail = "habibieamrullah@gmail.com";


date_default_timezone_set('Asia/Jakarta');

//Database connection
$host = "localhost";
$dbuser = "root";
$dbpassword = "";
$databasename = "mydatabase";

$connection = mysqli_connect($host, $dbuser, $dbpassword, $databasename);
$connection->set_charset("utf8");