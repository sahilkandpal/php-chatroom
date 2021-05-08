<?php 
//connecting to the database
$server = "localhost";
$username = "root";
$password = "";
$dbname = "whatsappchatroom";
$con = mysqli_connect($server, $username, $password, $dbname);
if (!$con) {
  die("connection to this database failed due to".mysqli_connect_error());
}
else{
// echo "success";
}
?>