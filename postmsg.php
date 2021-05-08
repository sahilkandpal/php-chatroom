<?php
//posting msg with email
    session_start();
    $email=$_SESSION['user_email_address'];
    include 'dbcon.php';
    $roomname=$_POST['roomname']; 
    $username=trim($_POST['username']); 
    $msg=$_POST['text'];
    $sql = "INSERT INTO `usermsg` (`roomname`, `username`, `msg`, `email`) VALUES ('$roomname', '$username', '$msg', '$email');";
    if(mysqli_query($con, $sql)){
        // echo "inserted";
    }
    else{
        echo "ERROR:".mysqli_error($con);
    }


?>