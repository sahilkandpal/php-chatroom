<?php
//fetching name of participants joined the room
include 'dbcon.php';
$roomname=$_POST['roomname'];
         $q="SELECT username FROM rooms WHERE roomname='$roomname'";
         $result=mysqli_query($con, $q);
         while ($row= mysqli_fetch_array($result))
         {      
         ?>      <li> <img class="img-responsive rounded-circle" style="height:49px; width:49px; margin-right:10px;" src="images/user.png" /><?php echo $row['username'];?></li>
             <?php 
                } 
                ?>
              