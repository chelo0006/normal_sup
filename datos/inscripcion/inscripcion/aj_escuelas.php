<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$clave = str_replace(' ','%',$_POST['clave']);

$base = dbConectar();
$escuelas = dbConsultar($base,"select * from establec where nombre ilike '%$clave%'");

echo '<table class="tabla">';
if(dbCount($escuelas)>0){
	while($fila = pg_fetch_row($escuelas)){
		echo '<tr onclick="traer_escuela(\''.utf8_decode($fila[dbcampo($escuelas,'nombre')]).'\','.$fila[dbcampo($escuelas,'cue')].','.$fila[dbcampo($escuelas,'anexo')].')"><td>'.utf8_decode($fila[dbcampo($escuelas,'nombre')]).'</td></tr>';
	}
}
else{
	echo '<tr onclick="agregar_escuela()"><td>Agregar el establecimiento ingresado</td></tr>';
}
echo '</table>';

?>