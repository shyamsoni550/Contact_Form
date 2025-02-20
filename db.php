<?php
   $conn=mysqli_connect("localhost","root","","contact_form");
   echo "<br>";
   if ($conn)
   {
        // echo "connected";
   }
   else
   {
        echo "not connected" . mysqli_connect_error($conn);
   }
?>