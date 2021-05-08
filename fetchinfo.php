<?php 
//fetching no. of participants joined the room
$roomname=$_POST['roomname'];
include 'dbcon.php';
$sql="SELECT * FROM rooms WHERE roomname='$roomname'";
$res=mysqli_query($con, $sql);
$count=mysqli_num_rows($res);
echo "$count participants";
?>