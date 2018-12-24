<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
$iddepto = $_POST['iddepto'];
$idlocalidad = $_POST['idlocalidad'];

$base = dbConectar();
$localidad = dbConsultar($base,"select * from localidades where depto='$iddepto' order by nombre");

echo '<select id="localidad" style="width:100%;">
								<option value"0">Seleccionar</option>';
								while($fila = pg_fetch_row($localidad)){
									echo '<option value="'.$fila[6].'" ';
									if($fila[6]==$idlocalidad) echo 'selected';
									echo '>'.$fila[4].'</option>';
								}
								echo '</select>';

?>