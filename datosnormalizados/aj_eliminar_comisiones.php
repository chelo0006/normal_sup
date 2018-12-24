<?php
session_start();
include('sesion.php');
include('variables.php');
include($prof.'funciones/bd.php');

$idcarrera=$_POST['idcarrera'];
$anio=$_POST['anio'];
$comision=$_POST['comision'];
$id=$_POST['id'];

$base = dbConectar();

$consulta="select * from comisiones where idcomision=$id";
$consulta2 = dbConsultar($base,$consulta);



if ($fila = pg_fetch_row($consulta2))
{
//	echo 'actualiza';
		$cadena ="DELETE FROM COMISIONES  where idcomision=$id";

	
	}

$inscribir = dbConsultar($base,$cadena);
if($inscribir) echo 'Comision eliminada con éxito';

echo '<iframe style="display:none;" onload="trae_comision(\'Comisión eliminada con éxito\')"></iframe>';

?>