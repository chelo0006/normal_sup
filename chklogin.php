<?php 
session_start();
include('funciones/bd.php');
$prof = "";
$usuario = $_GET['usuario'];
$clave = $_GET['clave'];

$_SESSION['usuario'] = $usuario;

$enlace = dbConectar();
$Consulta = dbConsultar($enlace,"select * from usuarios where usuario = '$usuario' and pass = '".md5($clave)."'");

if($fila = pg_fetch_row($Consulta)){
   $_SESSION['inicio_sesion'] = "1";				    
   $destino = "datos/opciones.php";
   $_SESSION['perfil'] = $fila[3]; 
   }
else{
   $_SESSION['inicio_sesion']="0";	
   $destino = "index.php?e=1";
   };
header("Location: {$destino}");

exit();
?>