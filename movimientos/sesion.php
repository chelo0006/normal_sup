<?php
session_start();
if (isset($_SESSION['inicio_sesion'])){
   if ($_SESSION['inicio_sesion']=="0"){
      header("Location: ../index.php");
      exit();
      }
   }
else {
    header("Location: ../index.php");
    exit();
}
?>