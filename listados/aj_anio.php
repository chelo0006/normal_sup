<?php
session_start();
include('sesion.php');
include($prof.'/variables.php');
include($prof.'funciones/bd.php');

$idcarrera = $_POST['idcarrera'];

$base = dbConectar();
$clt_busqueda = dbConsultar($base,"select distinct(anio) from v_materiasxcarrera where idcarrera=$idcarrera order by anio");

echo '<select id="anio" onchange="eligeanio()">
								<option value"0">Seleccionar</option>';
								while($fila = pg_fetch_row($clt_busqueda)){
									echo '<option value="'.$fila[0].'" ';
									if($fila[0]==$depto) echo 'selected';
									echo '>'.$fila[0].'</option>';
								}
								echo '</select>';

?>
