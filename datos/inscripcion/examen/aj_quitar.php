<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$idcarrera=$_POST['idcarrera'];
$idalumno=$_POST['idalumno'];
$idmateria=$_POST['idmateria'];
$fecha=$_POST['fecha'];

$base = dbConectar();

$consulta='delete from inscripcion_examen where idcarrera = '.$idcarrera.' and idmateria = '.$idmateria.' and idalumno = '.$idalumno.' and fecha_inscripcion = \''.$fecha.'\'';

$quitar = dbConsultar($base,$consulta);
if($quitar) echo 'Se quito de la mesa al alumno exitosamente';

echo '<iframe style="display:none;" onload="mostrar_materias(\'Se quito de la mesa al alumno exitosamente\')"></iframe>';
?>