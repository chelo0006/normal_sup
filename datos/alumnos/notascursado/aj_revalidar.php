<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');
$base = dbConectar();

$materia = $_POST['materia'];
$idalumno = $_POST['idalumno'];
$fecha_fin = $_POST['fecha_fin'];

$fecha = date("d/m/Y",strtotime($fecha_fin."+ 6 month")); 

$clta = dbConsultar($base,"select idnotas from notas a, inscripcion_cursado b 
	where id_inscripcion = id_inscripcion_cursado and idalumno = $idalumno and idmateria = $materia and fecha_fin = '$fecha_fin'");
$fila_nota = dbfila($clta);
$idnota = $fila_nota[dbcampo($clta, 'idnotas')];
$clta = dbConsultar($base,"update notas set fecha_fin = '".$fecha."' where idnotas = $idnota");

$clta = dbConsultar($base,"insert into registro_sucesos(tipo,foperacion,usuario,idcontrol,control)
values ('ravalida',now(),'".$_SESSION['usuario']."',$idnota,'$fecha_fin')");

if($clta) echo 'Se Extendió la regularidad del alumno 6 meses';
echo '<iframe onload="eligemateria(\'Se agregaron 6 meses a la regularidad del alumno\')" style="display:none;"></iframe>';
?>