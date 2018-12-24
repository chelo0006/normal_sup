<?php
session_start();
include('sesion.php');
include($prof.'variables.php');
include($prof.'funciones/bd.php');

$idcarrera = $_POST['carrera'];
$anio = $_POST['anio'];

$base = dbConectar();
$clt_busqueda = dbConsultar($base,"select idmateria,materia from v_materiasxcarrera where idcarrera=$idcarrera and anio=$anio");

echo '<select id="materia" onchange="eligemateria()">
								<option value="0">Seleccionar</option>';
								while($fila = pg_fetch_row($clt_busqueda)){
									echo '<option value="'.$fila[0].'" ';
									if($fila[0]==$depto) echo 'selected';
									echo '>'.$fila[1].'</option>';
								}
								echo '</select>';
echo '<iframe onload="cargar_comisiones()" style="display:none;"></iframe>';
?>
