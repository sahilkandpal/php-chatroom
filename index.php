<?php  
  //include this file to access google api elements, code, token, google_client, data in session
   include 'config.php';
   $login_button = '';

   //getting code when user sign in using google api 
   if(isset($_GET["code"]))
{

 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);


 if(!isset($token['error']))
 {
 
  $google_client->setAccessToken($token['access_token']);

 
  $_SESSION['access_token'] = $token['access_token'];


  $google_service = new Google_Service_Oauth2($google_client);

 
  $data = $google_service->userinfo->get();

 
  if(!empty($data['given_name']))
  {
   $_SESSION['user_first_name'] = $data['given_name'];
  }

  if(!empty($data['family_name']))
  {
   $_SESSION['user_last_name'] = $data['family_name'];
  }

  if(!empty($data['email']))
  {
   $_SESSION['user_email_address'] = $data['email'];
  }

  if(!empty($data['gender']))
  {
   $_SESSION['user_gender'] = $data['gender'];
  }

  if(!empty($data['picture']))
  {
   $_SESSION['user_image'] = $data['picture'];
  }
 }
}

//if user is not sign in
if(!isset($_SESSION['access_token']))
{

 $login_button = '<li class="nav-item active"><a class="nav-link text-light" href="'.$google_client->createAuthUrl().'">SIGN IN</a></li>';
}
//if user is sign in
else{
    $login_button = '<img style="height:49px;" src="'.$_SESSION["user_image"].'" class="img-responsive rounded-circle" />';
}
//make connection to database 
   include 'dbcon.php';
//when user submit room code check whether room exist or not and then redirect it to room else show a error
   if(isset($_POST['submit'])){
//check if user is not sign in then redirect on sign page on btn click
    if(isset($_SESSION['access_token'])){
      $code=$_POST['roomname'];
      $q="SELECT roomname FROM rooms";
      $result=mysqli_query($con, $q);
      while($row= mysqli_fetch_array($result)){
        if($code==$row['roomname']){
            echo '<script>window.onload = function(){
              document.getElementById("loadscreen").style.display="flex";
            }
            setTimeout(function(){window.location.href = "http://localhost/whatsapp%20chatroom/room.php?roomname='.$code.'";},3000);</script>';
        }
        else if($code=="http://localhost/whatsapp%20chatroom/room.php?roomname=".$row['roomname']){
            echo '<script>window.onload = function(){
                document.getElementById("loadscreen").style.display="flex";
              }
              setTimeout(function(){window.location.href = "'.$code.'";},3000);</script>';
        }
        else{
           echo '<script>window.onload = function() {document.getElementById("error").innerHTML="  Please enter the valid code or link";var element = document.getElementById("error");
            element.classList.add("fa-exclamation");element.classList.add("fas");}</script>';
            
        }
        }
        }
        else{header("Location:".$google_client->createAuthUrl());}
        }
   
    
    ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.1/css/pro.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>whatsapp chatroom</title>
    <style>
    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
    }
    body{
        height:100%;
        width:100%;
        position:relative;
    }
    .ltext{
        position:relative;
        top:2px;
        color:#f7f7f7;
        left:4px;
        font-weight:500;
    }
    .navbar{
        background-color: #1ebea5!important;
    }
    .navbar-toggler{
        border:none;
    }
    .navbar-toggler:focus{
        outline:none;
    }
    .navbar-collapse {
    transition: 0.5s;
    }
    .btn-light{
        color: #1ebea5!important; 
        font-weight:500;
    }
    .fixedh{
        height:50px;
        margin-top:90px;
    }
    #form{
        /* width:100%; */
        /* margin-top:80px; */
        height:min-content;
    }
   
    .fa-plus-square{
        margin-right:5px;
    }
    .group{
        position:relative;
        top:3px;
    }
    input{
        height:45px!important;
        width:auto!important;
        padding-left:45px!important;
    }
    input:focus{
        border-color:#1ebea5!important;
        outline:none;
        box-shadow:none!important;
        border-width:2px;
    }

    .icon{
        position: absolute;
        color: grey;
        font-size:20px;
        top:15px;
        left:15px;
    }
    .newroomtxt{
        padding-top:22px;
        padding-bottom:22px;
    }
    .room-btn,input{
        margin-right:15px;
    }
    .room-btn{
        width:118px;
    }
    .form-btn{
        background-color: #1ebea5; 
        color:#ffffff;
        font-weight:500;
        padding:10px;
    }
    .form-btn:hover{
        background-color: #12b097; 
        color:#ffffff;
        font-weight:500;
    }
    .big-box{
        margin-top:150px;
    }
    .left-box p:first-child{
        color:#282828;
        font-weight: 400;
        font-size:34px;
        line-height:35px;
    }
    .left-box p:last-child{
        color:#1c1e21;
        font-weight: 100;
        font-size:16px;
        line-height:26px;
        opacity: .78;
    }
    #overlay{
        position:absolute;
        background:rgba(0,0,0,0.6);
        height:100vh;
        width:100%;
        top:0;
        display:none;
        align-items:center;
        justify-content:center;
    }
    .dialog{
        background-color:#fff;
        width:max-content;
        height:200px;
        padding:25px;
        border-radius:10px;
        position:relative;
    }
    .fa-times{
        margin-left:100px;
        font-size:24px;
        color:grey;
        cursor:pointer;
    }
    .dialog p{
        opacity:0.78;
        font-size:15px;
        line-height:18px;
        margin-top:25px;
    }
    .url-box{
    background: #f1f3f4;
    border-radius: 4px;
    color: #000;
    padding-left: 12px;
    padding-top: 15px;
    padding-bottom:15px;
    font-size:17px;
    width:300px;
    height:60px;
    overflow-x: auto;
    white-space: nowrap;
    }
    .fa-clipboard{
    position:absolute;
    top:130px;
    right:15px;
    font-size:20px;
    /* color:green; */
    background:#eee;
    width:50px;
    height:55px;
    display:flex;
    align-items:center;
    justify-content:center;
    }
    .fas{
        margin-top:5px;
        margin-left:5px;
        display:block;
    }
    #loadscreen{
        position:absolute;
        background:rgba(0,0,0,1);
        height:100vh;
        width:100%;
        top:0;
        display:none;
        align-items:center;
        justify-content:center;  
        animation-name:loading;
        animation-duration:3s;
    }
    @keyframes loading{
        from{background-color:rgba(0,0,0,0.7);}
        to{background-color:rgba(0,0,0,1);}
    }
    .loadtext{
        color:#fff;
        font-size:30px;
    }
    </style>
</head>
<body>
<div class="wrapper">
  <nav class="navbar navbar-expand-lg navbar-light p-3">
  <div class="container">
  <a class="navbar-brand" href="#"><img src="images/logo.svg"><span class="ltext">Chatroom</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon ml-auto"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav ml-auto align-items-center">
  <li class="nav-item active">
  <a class="nav-link text-light" href="#">SECURITY</a>
  </li>
  <li class="nav-item active">
  <a class="nav-link text-light" href="#">FEEDBACK</a>
  </li>
  <?php echo $login_button?> 
  </ul>
  </div>
  </div>
  </nav>

  <div class="container big-box">
  <div class="row mx-auto justify-content-center">
  <div class="col-md-5 left-box">
  <p>Simple. Secure.<br>Reliable messaging.</p>
  <p class="mt-4">With WhatsApp Chatrooms, you'll get fast, simple, secure messaging, and it will keep you anonymous all over the world.
  messages are end-to-end encryped and secured so only you and the person you're communicating with can read to them, and nobody in between.
  </p>
  </div>
  <div class="col-md-auto">
<div class="fixedh d-flex">
<!-- first check session redirect to sign in page on btn click  -->
      <a <?php if(!isset($_SESSION['access_token'])){echo 'href="'.$google_client->createAuthUrl().'"';}?>>
      <div  class="btn room-btn form-btn" id="roombtn"><span class="far fa-plus-square"></span><span>New room</span></div>
      </a>
      <div class="group" id="form">
      <span class="fa fa-keyboard icon"></span>
      <input required type="text" class="form-control d-inline" name="roomname" placeholder="Enter a code or link" id="code">
      <a <?php if(!isset($_SESSION['access_token'])){echo 'href="'.$google_client->createAuthUrl().'"';}?>>
      <span class="btn form-btn" id="joinbtn" type="submit" name="submi">JOIN</span>
      </a>
      <div id="error" class="text-danger"></div>
      </div>
      </div>
      </div>

    </div>
  </div>
</div>

  <div id="overlay">
  <div class="dialog">
    <h6>Here's the link to your chatroom<span class="far fa-times" id="close-btn"></span></h6>
    <p>Copy this link and send it to people you want to chat<br>
       with.Be sure to save it so you can use it later, too. 
    </p>
    <div class="url-box" id="url"></div>
    
  <span class="fa fa-clipboard" id="clipboard"></span>

  </div>
  </div>

  <div id="loadscreen">
  <div class="loadtext">Joining...</div>
  </div>
  
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
<?php
//if there is a session then on btn click a post request will be sent to postroom.php to insert room in database
if(isset($_SESSION['access_token'])){

echo 'document.getElementById("roombtn").onclick = function() {opendialog()};
 function opendialog(){
 document.getElementById("overlay").style.display="flex";
 $.post("postroom.php", function(data,status){$("#url").html(data);});
      }  
      document.getElementById("joinbtn").onclick = function() {loadscreen()};
      $("#code").keydown(function(event){ 
        if(event.which==13){
           loadscreen();
        }
    });
      function loadscreen(){
          var room = document.getElementById("code").value;
      $.post("checkroom.php", {roomname:room}, function(data,status){
          if(data==""){document.getElementById("error").innerHTML="  Please enter the valid code or link";var element = document.getElementById("error");
            element.classList.add("fa-exclamation");element.classList.add("fas");}
          else{$("#special").html(data);}
        });
      }'; }?>
  document.getElementById("close-btn").onclick = function() {closedialog()};
 
  function closedialog(){
  document.getElementById("overlay").style.display="none";
  }
  //copy url to clipboard
  document.getElementById("clipboard").onclick = function() {Text()};
  function Text(){
  var elm = document.getElementById("url");
  if(document.body.createTextRange) {
  var range = document.body.createTextRange();
    range.moveToElementText(elm);
    range.select();
    document.execCommand("Copy");
    alert("Copied div content to clipboard");
  }
  else if(window.getSelection) {
    // other browsers

    var selection = window.getSelection();
    var range = document.createRange();
    range.selectNodeContents(elm);
    selection.removeAllRanges();
    selection.addRange(range);
    document.execCommand("Copy");
    alert("Copied Room Url");
  }
}
</script>
<script id="special"></script>
</body>
</html>