<?php
session_start();
include('sesion.php');
include('variables.php');
include($prof.'funciones/bd.php');

$base = dbConectar();

$idcarrera=$_POST['idcarrera'];

$html.= '<INPUT TYPE="hidden" NAME="idcarrera" VALUE="'.$idcarrera.'">';

$fecha_examenes = dbConsultar($base,"select anio_lectivo,to_char (fecha,'DD/MM/YYYY') as fecha from FECHA_MESA_EXAMENES ");
$html.='<table class="tabla" border="0" style="width:40%;">
<tr> <th align="center">A&ntilde;o Lectivo</th><th align="center">Fecha</th></tr>';
while($fechas = pg_fetch_row($fecha_examenes)){
	$html.= '<tr onclick="traer_datos('.$fechas[0].')"><td align="center" >'.$fechas[1].'</td>
	</tr>';
}
$html.= '</table>
</table>
<br>
';
echo $html;
//$html.= '<iframe onload="cargar()" style="display:none;"></iframe>';


?>

