<?php
//fetching username and msgs from db
include 'dbcon.php';
$roomname=$_GET['roomname'];
$username=$_GET['username'];
         $q="SELECT username, msg, email FROM usermsg WHERE roomname='$roomname'";
         $result=mysqli_query($con, $q);
         while ($row= mysqli_fetch_array($result))
         {      
         ?>     <div class="txt" style="<?php if($username!=$row['username']){?>text-align:left;<?php }?>">
                <div class="<?php if($username!=$row['username']){echo "nmsgbox";}else{echo "msgbox";}?>">
                <div class="username" style="color:<?php $uname=$row['username']; $email=$row['email']; $query="SELECT usercolor FROM rooms WHERE roomname='$roomname' AND email='$email'"; $res=mysqli_query($con, $query); $r= mysqli_fetch_array($res); echo $r['usercolor'];?>;"><?php echo $row['username'];?></div> 
                <div class="message"><?php echo $row['msg'];?></div> 
                </div>
                </div>
             <?php 
                } 
                ?>
              