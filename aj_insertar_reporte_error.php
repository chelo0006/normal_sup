<?php
session_start();
include('sesion.php');
include($prof.'variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$base = dbConectar();

$descripcion=$_POST['descripcion'];
$ruta=$_POST['ruta'];

	$cadena ="INSERT INTO REPORTE_ERROR (RUTA,DESCRIPCION_ERROR,USUARIO,FOPERACION) VALUES";
	$cadena.="('".$ruta."','".$descripcion."','{$_SESSION['usuario']}',now());";

$inscribir = dbConsultar($base,$cadena);
if($inscribir) echo 'Error reportado con éxito';
 
echo '<iframe style="display:none;" onload="finalizar_informe_error()"></iframe>';
?>