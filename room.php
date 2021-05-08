<?php
    // mkdir("test");
    include 'dbcon.php';
    include 'config.php';
    $email=$_SESSION['user_email_address'];
    if(!isset($_SESSION['user_last_name'])){
        $username=$_SESSION['user_first_name']; 
    }
    else{$username=$_SESSION['user_first_name']." ".$_SESSION['user_last_name']; }
    $roomname=$_GET['roomname']; 
    if(!isset($_SESSION['access_token'])){
        header("Location:".$google_client->createAuthUrl());
    }
    //if url roomname is not valid then redirect it to error page
    $sql="SELECT * FROM rooms WHERE roomname='$roomname'";
    $res=mysqli_query($con, $sql);
    if(mysqli_num_rows($res)==0){
        header("Location: error.php");
    }
    //check if users already joined the room if not then insert his data with member status and color
    $q="SELECT * FROM rooms WHERE email='$email'";
    $r=mysqli_query($con, $q);
    if(mysqli_num_rows($r)==0){
        $status="member";
        function randomHex() {
            $chars = 'ABCDEF0123456789';
            $color = '#';
            for ( $i = 0; $i < 6; $i++ ) {
               $color .= $chars[rand(0, strlen($chars) - 1)];
            }
            return $color;
         }
        $usercolor=randomHex();
        $query = "INSERT INTO `rooms` (`roomname`, `username`, `email`, `status`, `usercolor`) VALUES ('$roomname', '$username', '$email', '$status', '$usercolor');";
        mysqli_query($con, $query);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp chatroom</title>
    <style>
        ::-webkit-scrollbar {
    width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
    background: #eeeeee; 
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
    background: lightgrey; 
    }

    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
    }
    .txt{
        margin:40px 60px;
    }
    .msgbox{
        background-color:#c5fcb8;
        padding:8px 60px 5px 10px;
        border-radius:8px;
        color:#303030;
        position:relative;
        width:max-content;
        max-width:500px;
        margin-left:auto;
    }
    .msgbox:before{
        content: "";
        position: absolute;
        border-left: 2px solid transparent;
        border-right: 15px solid transparent;
        border-top: 12px solid #cdffc2;
        border-bottom: 6px solid transparent;
        right:-10px;
        top:0px;
    }
    .nmsgbox{
        background-color:#fff;
        padding:8px 60px 5px 10px;
        border-radius:8px;
        color:#303030;
        position:relative;
        width:max-content;
        max-width:500px;
    }
    .nmsgbox:before{
        content: "";
        position: absolute;
        border-left: 15px solid transparent;
        border-right: 2px solid transparent;
        border-top: 12px solid #fff;
        border-bottom: 6px solid transparent;
        left:-10px;
        top:0px;
    }
    .username{
        font-size:12px;
    }
    .message{
        font-size:14px;
        width:max-content;
        max-width:480px;
        word-wrap:break-word;
    }
    .wrapper{
        height:100vh;
        width:100%;
    }
        .msgouter{
            position: absolute;
            z-index: -1;
            background-image:url(images/background.png);
            opacity:0.2;
            background-color:#5e7500;
            height:100%;
            top:0;
            width:80%;
        }
        .msgarea{
            position: relative;
            z-index: 1;
            overflow-x:hidden;
            overflow-y:scroll;
            color:black;
            height:100%;
            width:100%;
            opacity:1;
        }
        .form-group{
            margin-bottom:0;
            justify-content:space-around;
        }
        #submit{
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:25px;
            color:grey;
        }
        #submit:hover{
            color:#07bc4c;
        }
        input{
            border:none!important;
            border-radius:20px!important;
            padding:22px 20px!important;
            flex:0.9;
        }
        input:focus{
        border:none!important;
        outline:none;
        box-shadow:none!important;
    }
    .form-group{
        padding:10px;
        background-color:#ededed;
    }
    
        .left-box{
            /* width:80%; */
            /* height:100vh; */
            flex:8;
            flex-direction:column;
        }
        .right-box{
          flex:2;
          display:flex;
          flex-direction:column;
        }
        li{
            list-style:none;
            padding:10px 30px;
            border-top: 0.1px solid #eeeeee;
            border-bottom:1px solid #eeeeee;
            font-size:17px;
        }
        li:hover{
            background-color:#eeeeee;
        }
        .head{
            background-color:#ededed;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:18px 0;
            border-left:1px solid rgba(0,0,0,0.08);
        }
        .part{
            padding:10px 25px;
            color:teal;
            font-size:14px;
        }
        .name{
            flex:1;
            overflow-x:hidden;
            overflow-y:scroll;
        }
    </style>
</head>
<body>
<div class="wrapper d-flex">
    <div class="left-box d-flex">
    <div class="msgouter"></div>
    <div class="msgarea" id="msgplace"></div>
    <div class="form-group border d-flex">
        <input class="form-control" type="text" id="mymsg" placeholder="Type a message" autocomplete="off">
        <span id="submit" class="fas fa-paper-plane"></span>
    </div>    
    </div>
    <div class="right-box">
    <div class="head">Chatroom info</div>
    <div class="part" id="part-count"></div>
    <div class="name">
    <ul id="part-detail">

    </ul>
    </div>
    </div>
</div>    
    <script>
    //fetching data every 100ms to retrieve msgs and userinfo from db by sending post request to fetch.php and fetchinfo.php
        function fetchdata() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("msgplace").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","fetch.php?roomname=<?php echo $roomname;?>&username=<?php echo $username?>",true);
    xmlhttp.send(); 
    $.post("fetchinfo.php", {roomname:'<?php echo $roomname;?>'}, function(data,status){$("#part-count").html(data);});
    $.post("fetchuserinfo.php", {roomname:'<?php echo $roomname;?>'}, function(data,status){$("#part-detail").html(data);});
} setInterval(fetchdata, 100);

//on enter key send msg by sending request to postmsg.php
$("#mymsg").keydown(function(event){ 
    if(event.which==13){
    var usermsg=$.trim($("#mymsg").val());
    if(usermsg!=""){
    $.post("postmsg.php", {text:usermsg,roomname:'<?php echo $roomname;?>',username:'<?php echo $username;?>'}); 
    $("#mymsg").val('');
    }
    }
});
// on  click on submit send msg by sending request to postmsg.php
$("#submit").click(function(){
  var usermsg=$.trim($("#mymsg").val());
  if(usermsg!=""){
  $.post("postmsg.php", {text:usermsg,roomname:'<?php echo $roomname;?>',username:'<?php echo $username;?>'}); 
  $("#mymsg").val('');
  }
});

    </script>
</body>
</html>