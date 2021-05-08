<?php 
  include 'dbcon.php';
  $code=$_POST['roomname'];
  $q="SELECT roomname FROM rooms";
  $result=mysqli_query($con, $q);
  while($row= mysqli_fetch_array($result)){
    if($code==$row['roomname']){
        echo 'document.getElementById("loadscreen").style.display="flex";
        document.getElementById("error").innerHTML="";var element = document.getElementById("error");
            element.classList.remove("fa-exclamation");element.classList.remove("fas");
            setTimeout(function(){window.location.href = "http://localhost/whatsapp%20chatroom/room.php?roomname='.$code.'";},3000);';
    break;
    }
    else if($code=="http://localhost/whatsapp%20chatroom/room.php?roomname=".$row['roomname']){
        echo 'document.getElementById("loadscreen").style.display="flex";
          setTimeout(function(){window.location.href = "'.$code.'";},3000);
          document.getElementById("error").innerHTML="";var element = document.getElementById("error");
          element.classList.remove("fa-exclamation");element.classList.remove("fas");';
    break;
    }
    else{
       echo "";
        
    }
    }

?>