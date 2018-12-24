<?php
session_start();
include('sesion.php');
include('variables.php');
//$prof='../../';
//$anio_lectivo=date("Y");

include($prof.'funciones/bd.php');
$idcarrera=$_POST['idcarrera'];
$anio=$_POST['anio'];
$anio_lectivo=$_POST['selanio'];

$comision=strtoupper($_POST['comision']);
$cupo=strtoupper($_POST['cupo']);

$id=$_POST['id'];

$base = dbConectar();

$consulta="select * from comisiones where idcomision=$id";
$consulta2 = dbConsultar($base,$consulta);



if ($fila = pg_fetch_row($consulta2))
{
	//echo 'actualiza';
		$cadena ="UPDATE COMISIONES SET comision='$comision',cupo='$cupo' where idcomision=$id";

	
	}
else{
	//echo 'inserta';
/*	$cadena ="INSERT INTO COMISIONES (IDCARRERA,ANIO,COMISION,FOPERACION,USUARIO,ANIO_LECTIVO) VALUES";
	$cadena.="($idcarrera,$anio,'$comision',now(),'{$_SESSION['usuario']}',$anio_lectivo);";*/
}


$inscribir = dbConsultar($base,$cadena);
if($inscribir) echo 'Comision actualizada con éxito';
echo '<iframe style="display:none;" onload="trae_comision(\'Comision Modificada con éxito\')"></iframe>';




?>