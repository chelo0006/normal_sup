<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$base = dbConectar();

$idcarrera=$_POST['idcarrera'];
$idalumno=$_POST['idalumno'];
$idmateria=$_POST['materias_excepcion'];
$observaciones=$_POST['observaciones'];
$comisiones = $_POST['comisiones_excepcion'];
$anio_lectivo=$_POST['selanio'];
$fecha=$_POST['fecha'];

$alumno_inscripto = dbConsultar($base,"select * from inscripcion_cursado where idalumno=$idalumno and anio_lectivo=$anio_lectivo and idmateria=$idmateria");

if (dbCount($alumno_inscripto)==0){
	$cadena ="INSERT INTO INSCRIPCION_CURSADO (IDALUMNO,IDCARRERA,IDMATERIA,ANIO_LECTIVO,FECHA_INSCRIPCION,FOPERACION,USUARIO,COMISION,OBSERVACIONES) VALUES";
	$cadena.="($idalumno,$idcarrera,".$idmateria.",2018,'$fecha',now(),'{$_SESSION['usuario']}',".$comisiones.",'".$observaciones."');";
	$inscribir = dbConsultar($base,$cadena);

	if($inscribir) echo 'Inscripcion realizada con éxito';
	echo '<iframe style="display:none;" onload="mostrar_materias(\'Se inscribio al alumno con la excepción indicada exitosamente\')"></iframe>';
}
else{
	echo '<iframe style="display:none;" onload="mostrar_materias(\'No se pudo inscribir al alumno por favor informe al administrador\')"></iframe>';
};
?>