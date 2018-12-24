<?php
session_start();
include('sesion.php');
include('variables.php');
include($prof.'funciones/bd.php');

$base = dbConectar();

$idcarrera=$_POST['idcarrera'];




/*$java = '<script src="'.$prof.'scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/prototype.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/moo.ajax.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/behaviour.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function cargar(){

}
function trae_comision(){
    var idcarrera = document.getElementById("idcarrera").value;
    new ajax ("aj_comisiones.php",{postBody: idcarrera ,update: $("listado")});

}
</script>';*/

$html.='
<table border=0 width=50%>
	<tr><td>A&ntilde;o:</td><td>';
	$comisiones = dbConsultar($base,"select a.idcomision,(a.anio||' '||a.comision||' ('||b.carrera||')') as comision 
														from comisiones a,carreras b
														where a.idcarrera=b.idcarrera and a.idcarrera=".$idcarrera." order by a.anio,a.comision");

			$html.='<select id="idcomision" style="width:70%;" onchange="trae_listado()">
											<option value="0">Seleccionar</option>';
											while($fila = pg_fetch_row($comisiones)){
												$html.= '<option value="'.$fila[0].'" ';
												if($fila[0]==$idcomision) $html.= 'selected';
												$html.= '>'.$fila[1].'</option>';
											}
											$html.= '</select>';
	
	
	
	
	$html.='</td>
</tr>
<input type="hidden" id="idcomision">

</table>

';
echo $html;
//$html.= '<iframe onload="cargar()" style="display:none;"></iframe>';


?>

