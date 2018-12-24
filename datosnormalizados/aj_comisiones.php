<?php
session_start();
include('sesion.php');
include('variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');
$base = dbConectar();

$idcarrera=$_POST['idcarrera'];

$html.= '<INPUT TYPE="hidden" NAME="idcarrera" VALUE="'.$idcarrera.'">';


$carrera = dbConsultar($base,"select distinct carrera from carreras where idcarrera = $idcarrera");
$nombrecarrera = pg_fetch_row($carrera);

$html.='
<b>Comisiones del '.$nombrecarrera[0].'</b><br><br>
<div style="max-height:400px; overflow-y:scroll; width:500px;"">';

$comisionxcarrera = dbConsultar($base,"select * from comisiones where idcarrera = $idcarrera order by anio,comision");

$html.='

<table class="tabla" border="0" style="width:100%;">
<tr> <th align="center">A&ntilde;o</th><th align="center">Comisión</th><th align="center">Año Lectivo</th><th align="center">cupo</th></tr>';
while($comisiones = pg_fetch_row($comisionxcarrera)){
	$html.= '<tr onclick="traer_datos('.$comisiones[0].')"><td align="center" >'.$comisiones[2].'</td><td align="center">'.$comisiones[3].'</td><td align="center">'.$comisiones[6].'</td><td align="center">'.$comisiones[7].'</td>
	</tr>';
}
$html.= '</table>
</table></div>
<br>
';

echo $html;
//$html.= '<iframe onload="cargar()" style="display:none;"></iframe>';
?>

