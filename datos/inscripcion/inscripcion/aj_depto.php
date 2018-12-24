<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
$idprovincia = $_POST['idprovincia'];
$depto = $_POST['departamento'];

if ($idprovincia==1){
$base = dbConectar();
$departamentos = dbConsultar($base,"select * from departamentos order by nombre");

echo '<select id="departamento" style="width:100%;" onchange="eligedepto()">
								<option value"0">Seleccionar</option>';
								while($fila = pg_fetch_row($departamentos)){
									echo '<option value="'.$fila[3].'" ';
									if($fila[3]==$depto) echo 'selected';
									echo '>'.$fila[2].'</option>';
								}
								echo '</select>';
}
else{
	echo '<input type="text" id="departamento" style="width:100%;" placeholder="escriba un departamento">';
	echo '<iframe style="display:none;" onload="blanco()"></iframe>';
}

?>