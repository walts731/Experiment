<?php
 $conn = mysqli_connect('localhost','root','12345','experiment');

 if(!$conn){
     die(mysqli_error($conn));
 }
?>