<?php
session_start();
include('sesion.php');
include($prof.'listados/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$idcarrera = 23;
$idalumno = 75;
require($prof.'funciones/estado_academico.php');


echo '<table border=1>';
for($i=1;$i<=sizeof($arreglo_estado_academico);$i++){
	echo '<tr>';
	for($j=0;$j<sizeof($arreglo_estado_academico[$i]);$j++){
		echo '<td>'.$arreglo_estado_academico[$i][$j].'</td>';
	}
	echo '</tr>';
}
echo '</table>';
?>
