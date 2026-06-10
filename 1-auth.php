<?php
  session_start();
  if($_SESSION['admin']==true){
     
  }else{
   header("Location:index.php");
  }
?>