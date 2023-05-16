<?php
/*$severname = "sql596.main-hosting.eu";
$database = "u876447700_integration";    
$username = "u876447700_root";
$password = "XirTech191200.";

$conn = mysqli_connect($servername, $username, $password, $database);
if(!$conn){
die("Connection failed" . mysqli_connect_error());
}*/


$sname = "localhost";
$uname = "root";
$password = "";
//DB Connection
$db_name = "db1_mapulanglupa";
$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn){
    echo "Connection Failed!";
} 
?>
