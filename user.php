<?php
include 'dbcon.php';
$roomname=$_GET['roomname'];
$q="SELECT * FROM rooms WHERE roomname='$roomname'";
$result=mysqli_query($con, $q);
if(mysqli_num_rows($result)==0){
  header("Location:http://localhost/whatsapp%20chatroom/error.php");
}
else{
  if(isset($_POST['submit'])){
    
    $username=$_POST['username']; 
    $password=$_POST['password']; 
    if(strlen($username)<3 || strlen($username)>8){
      echo '<script>alert("please type username between 3 to 8 characters")</script>'; 
    }
    else{
      function randomHex() {
        $chars = 'ABCDEF0123456789';
        $color = '#';
        for ( $i = 0; $i < 6; $i++ ) {
           $color .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $color;
     }
    
     $usercolor=randomHex(); 
      $sql="SELECT * FROM userinfo WHERE roomname='$roomname'";
      $rs=mysqli_query($con, $sql);
      if(mysqli_num_rows($rs)==0){$status="admin";}else{$status="member";} 
      $query="INSERT INTO userinfo (`roomname`, `username`, `status`, `usercolor`) VALUES ('$roomname', '$username', '$status', '$usercolor');";
      $res=mysqli_query($con, $query);
      if(!$res){echo "ERROR:".mysqli_error($con);}
      header("Location: http://localhost/whatsapp%20chatroom/room.php?username=$username&&roomname=$roomname");
    }
  
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<title>Document</title>
<style>
    body{
    height:100vh;
    background-color:#fffee6;
    }
    .bgimg:before{
    content: "";
    position: absolute;
    z-index: -1;
    height:100%;
    width:100%;
    background:url(images/background.png);
    opacity:0.1;
    }
    .wrapper{
      height:450px;
      width:400px;
      border-radius:10px;
      background-color:rgba(0,0,0,0.1);
      align-items:center;
      justify-content:center;
    }
    form{
      position:relative;
      height:500px;
      width:400px;
      padding:10px 40px;
    }
    img{
      margin-left:5px;
      margin-top: 70px;
      height:50px;
    }
    .txt{
      position:absolute;
      color:rgba(255,255,255,0.8);
      font-weight:700;
      font-size:25px;
      top:85.2px;
      left:225px;
    }
    input{
    margin-top: 40px;
    padding:26px 20px!important;
    box-shadow:none!important;
    border:none!important;
    }
    input:focus{
      border:none;
    }
    .btn{
      margin-top:40px;
      background-color:#14a891;
      color:#ffffff;
      font-weight:500;
      padding:8px 20px;
    }
    .btn:hover{
      color:#ffffff;
    }
    p{
      margin-bottom:0!important;
      margin-top:30px;
      font-size:14px;
      opacity:0.5;
    }
</style>
</head>
<body class="d-flex justify-content-center align-items-center bgimg">
  <div class="wrapper d-flex">
  <form action="user.php?roomname=<?php echo $roomname;?>" method="post">
      <img src="images/logo.svg"><span class="txt">Chatroom</span>
      <input type="text" name="username" placeholder="Type username" autocomplete="off" class="form-control">
      <input type="password" name="password" placeholder="Type password" autocomplete="off" class="form-control"> 
      <p>**This username will be display in your chat.</p>
      <button type="submit" name="submit" class="btn">Sign in</button>
  </form> 
  </div>

</body>
</html>

