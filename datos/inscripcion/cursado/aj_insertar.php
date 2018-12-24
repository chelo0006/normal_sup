<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$idcarrera=$_POST['idcarrera'];
$idalumno=$_POST['idalumno'];
$base = dbConectar();
$materias = explode(',',$_POST['materias']);
$comisiones = explode(',',$_POST['comisiones']);

$consulta='select * from inscripcion_cursado where idcarrera='.$idcarrera.' and idalumno='.$idalumno.' and idmateria='.$materias[0];
$consulta2 = dbConsultar($base,$consulta);

if ($fila = pg_fetch_row($consulta2)){}
else{
	$cadena ="INSERT INTO INSCRIPCION_CURSADO (IDALUMNO,IDCARRERA,IDMATERIA,ANIO_LECTIVO,FECHA_INSCRIPCION,FOPERACION,USUARIO,COMISION) VALUES";
	$cadena.="($idalumno,$idcarrera,".$materias[0].",2018,now(),now(),'{$_SESSION['usuario']}',".$comisiones[0].");";
}

for($i=1;$i<sizeof($materias);$i++){
	$consulta = 'select * from inscripcion_cursado where idcarrera='.$idcarrera.' and idalumno='.$idalumno.' and idmateria='.$materias[$i];
	$consulta2 = dbConsultar($base,$consulta);
	if ($fila = pg_fetch_row($consulta2)){}
	else{
		$cadena.='INSERT INTO INSCRIPCION_CURSADO (IDALUMNO,IDCARRERA,IDMATERIA,ANIO_LECTIVO,FECHA_INSCRIPCION,FOPERACION,USUARIO,COMISION) VALUES';
		$cadena.="($idalumno,$idcarrera,".$materias[$i].",2018,now(),now(),'{$_SESSION['usuario']}',".$comisiones[$i].");";
	}
}

$inscribir = dbConsultar($base,$cadena);
if($inscribir) echo 'Inscripcion realizada con éxito';

echo '<iframe style="display:none;" onload="mostrar_materias(\'Se Inscribió al alumno en las materias seleccionadas\')"></iframe>';
?>