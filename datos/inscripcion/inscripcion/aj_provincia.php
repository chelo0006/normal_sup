<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
$idpais = $_POST['idpais'];
$idprovincia = $_POST['idprovincia'];

if ($idpais==1){
$base = dbConectar();
$provincias = dbConsultar($base,"select * from provincias order by provincia");

echo '<select id="provincia" style="width:100%;" onchange="eligeprovincia()">
								<option value="0">Seleccionar</option>';
								while($fila = pg_fetch_row($provincias)){
									echo '<option value="'.$fila[0].'" ';
									if($fila[0]==$idprovincia) echo 'selected';
									echo '>'.$fila[1].'</option>';
								}
								echo '</select>';
}
else echo '<input type="text" id="provincia" style="width:100%;" placeholder="escriba la provincia">';

?>