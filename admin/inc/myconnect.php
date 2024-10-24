
<?php 
$host = "localhost";
$user = "root";
$pass = "";
$database = "web_man_fashion";

$dbc = mysqli_connect($host, $user , $pass , $database);
mysqli_set_charset($dbc, "utf8");
?>