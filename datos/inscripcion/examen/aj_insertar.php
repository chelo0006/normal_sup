<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$idcarrera=$_POST['idcarrera'];
$idalumno=$_POST['idalumno'];
$base = dbConectar();
$materias = explode(',',$_POST['materias']);
$fechas = explode(',',$_POST['fechas']);

$consulta='select * from inscripcion_examen where idcarrera='.$idcarrera.' and idalumno='.$idalumno.' and idmateria='.$materias[0].' and fecha_inscripcion = \''.$fechas[0].'\'';

$consulta2 = dbConsultar($base,$consulta);

if ($fila = pg_fetch_row($consulta2)){}
else{
	$cadena ="INSERT INTO INSCRIPCION_EXAMEN (IDALUMNO,IDCARRERA,IDMATERIA,ANIO_LECTIVO,FECHA_INSCRIPCION,FOPERACION,USUARIO) VALUES";
	$cadena.="($idalumno,$idcarrera,".$materias[0].",2018,'".$fechas[0]."',now(),'{$_SESSION['usuario']}');";
}

for($i=1;$i<sizeof($materias);$i++){
	$consulta = 'select * from inscripcion_examen where idcarrera='.$idcarrera.' and idalumno='.$idalumno.' and idmateria='.$materias[$i].' and fecha_inscripcion = \''.$fechas[$i].'\'';
	$consulta2 = dbConsultar($base,$consulta);
	if ($fila = pg_fetch_row($consulta2)){}
	else{
		$cadena.='INSERT INTO INSCRIPCION_EXAMEN (IDALUMNO,IDCARRERA,IDMATERIA,ANIO_LECTIVO,FECHA_INSCRIPCION,FOPERACION,USUARIO) VALUES';
		$cadena.="($idalumno,$idcarrera,".$materias[$i].",2018,'".$fechas[$i]."',now(),'{$_SESSION['usuario']}');";
	}
}

$inscribir = dbConsultar($base,$cadena);
if($inscribir){
	echo 'Inscripcion realizada con éxito';
	echo '<iframe style="display:none;" onload="mostrar_materias(\'Inscripcion realizada con éxito\')"></iframe>';
}
?>