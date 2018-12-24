<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$idcarrera = $_POST['carrera'];
$anio = $_POST['anio'];

$base = dbConectar();
$clt_busqueda = dbConsultar($base,"select * from comisiones where idcarrera=$idcarrera and anio=$anio order by comision asc");

echo '<select id="comision" onchange="eligemateria()">';
								while($fila = pg_fetch_row($clt_busqueda)){
									echo '<option value="'.$fila[0].'" ';
									echo '>Comision '.$fila[3].'</option>';
								}
								echo '</select>';

?>
