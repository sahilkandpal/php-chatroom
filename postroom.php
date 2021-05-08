<?php
    session_start();
    include 'dbcon.php';
    //unique room id
    $room=uniqid();
    //get username, email, status, color to insert into database 
    if(isset($_SESSION['user_last_name'])){
    $username=$_SESSION['user_first_name']." ".$_SESSION['user_last_name'];
    }
    else{
    $username=$_SESSION['user_first_name'];
    }
    $email=$_SESSION['user_email_address'];
    $status="admin";
    //function to generate random color
    function randomHex() {
        $chars = 'ABCDEF0123456789';
        $color = '#';
        for ( $i = 0; $i < 6; $i++ ) {
           $color .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $color;
     }
    $usercolor=randomHex();
    $sql = "INSERT INTO `rooms` (`roomname`, `username`, `email`, `status`, `usercolor`) VALUES ('$room', '$username', '$email', '$status', '$usercolor');";
    if(mysqli_query($con, $sql)){
        echo "http://localhost/whatsapp%20chatroom/room.php?roomname=$room";
    }
    else{
        echo "ERROR:".mysqli_error($con);
    }


?>