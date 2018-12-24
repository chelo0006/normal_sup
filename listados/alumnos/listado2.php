<?php
session_start();
include('sesion.php');
include('variables.php');
include($prof.'funciones/bd.php');

$base = dbConectar();


$java = '<script src="'.$prof.'scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/prototype.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/moo.ajax.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/behaviour.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function cargar(){

}
function trae_comision(){
    var idcarrera = document.getElementById("idcarrera").value;
    new ajax ("aj_comisiones.php",{postBody: "&idcarrera="+idcarrera ,update: $("comisiones")});

}

function trae_listado(){
    var idcarrera = document.getElementById("idcarrera").value;
    var idcomision = document.getElementById("idcomision").value;
	
    new ajax ("aj_listado_inscripcion.php",{postBody: "&idcarrera="+idcarrera+"&idcomision="+idcomision ,update: $("comisiones")});


}

</script>';
$html.='<table ><tr><td><strong>LISTADO DE ALUMNOS POR CARRERA Y POR COMISION</strong></td></tr></table>';
$html.='
<div class="form">
<table border=0 width=50%>
	<tr><td>Carrera:</td><td>';
	$carrera = dbConsultar($base,"select idcarrera,carrera from carreras where idcarrera in (22,23,30,32,26) order by carrera");

			$html.='<select id="idcarrera" style="width:70%;" onchange="trae_comision()">
											<option value="0">Seleccionar</option>';
											while($fila = pg_fetch_row($carrera)){
												$html.= '<option value="'.$fila[0].'" ';
												if($fila[0]==$idcarrera) $html.= 'selected';
												$html.= '>'.$fila[1].'</option>';
											}
											$html.= '</select>';
	
	
	
	
	$html.='</td>
</tr>
</table><hr><br>

<div id="comisiones"></div>
<div id="listado"></div>


';

include($prof."template.php");
?>

