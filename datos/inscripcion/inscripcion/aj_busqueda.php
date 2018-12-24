<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$dni = $_POST['dni'];

$base = dbConectar();
$clt_busqueda = dbConsultar($base,"select * from personas where dni = $dni");

if($fila = pg_fetch_row($clt_busqueda)){
	$id = $fila[14];
	$apellido = $fila[0];
	$nombre = $fila[1];
	$dni = $fila[2];
	$domicilio = $fila[3];
	$numero = $fila[4];
	$piso = $fila[5];
	$depto = $fila[6];
	$idlocalidad = $fila[8]; 
	$idprovincia = $fila[9];
	$sexo = $fila[12];
	$fecha = explode('-',substr($fila[13],0,10));
	$iddepartamento = $fila[16];
	$nacionalidad = $fila[15];
    $correo = $fila[17];
	$telefono = $fila[11];
    $tipodoc = $fila[18];
	
	$clt_alumno = dbConsultar($base,"select idalumno from alumno where idpersona = $id");
	if($fila2 = pg_fetch_row($clt_alumno)){
		$idalumno = $fila2[0];
	}
	echo '<iframe style="display:none;" onload="datos(\''.$id.'\',\''.$idalumno.'\',\''.$apellido.'\',\''.$nombre.'\',\''.$dni.'\',\''.$domicilio.'\',\''.$numero.'\',\''.$piso.'\',\''.$depto.'\',\''.$idlocalidad.'\',\''.$idprovincia.'\',\''.$sexo.'\',\''.$fecha[2].'\',\''.$fecha[1].'\',\''.$fecha[0].'\',\''.$nacionalidad.'\',\''.$iddepartamento.'\',\''.$correo.'\',\''.$telefono.'\',\''.$tipodoc.'\')"></iframe>';
}
else echo '<iframe style="display:none;" onload="error_busqueda()"></iframe>';

?>
