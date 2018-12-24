<?php
session_start();
include('sesion.php');
include('variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$base = dbConectar();
if(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje'];
else $mensaje = "";

$java = '<script src="'.$prof.'scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/prototype.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/moo.ajax.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/behaviour.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function cargar(){
	if("'.$mensaje.'" !="") pop(0,"Atencion:","'.$mensaje.'",400,150,"","","'.$prof.'");
	history.pushState(null, "", "abmmesaexamenes.php");
}
function agregar(){
	var dia = document.getElementById("element_1_2").value;
	var mes = document.getElementById("element_1_1").value;
	var anio = document.getElementById("element_1_3").value;
    new ajax ("aj_inserta_mesa.php",{postBody: "dia="+dia+"&mes="+mes+"&anio="+anio ,update: $("estado")});
}
function eliminar(id){
	new ajax ("aj_eliminar_mesa.php",{postBody: "id="+id,update: $("estado")});
}

function modificar(id){
	dia=document.getElementById("element_1_2").value;
    mes=document.getElementById("element_1_1").value;
	anio=document.getElementById("element_1_3").value;  
	new ajax ("aj_modifica_mesa.php",{postBody: "dia="+dia+"&mes="+mes+"&anio="+anio+"&id="+id ,update: $("estado")});
}

function traer_datos(id,fecha){
	 anio=fecha.substring(6,10);
	 mes=fecha.substring(3,5);
	 dia=fecha.substring(0,2);
	 document.getElementById("element_1_2").value=dia;
     document.getElementById("element_1_1").value=mes;
	 document.getElementById("element_1_3").value=anio;  
 	 document.getElementById("idfecha").value=id;  
  	 document.getElementById("divboton").innerHTML=" <a href=\"#\" class = \"btn\" onclick = \"modificar("+id+")\">Modificar</a> <a href=\"#\" class = \"btn\" onclick = \"eliminar("+id+")\">Eliminar</a>  <a href=\"#\" class = \"btn\" onclick = \"location.reload(true)\">Nuevo</a>   ";  
	 ';
	 
$java.='}
function finalizar_inscripcion(){
	alert (\'Examen actualizado con exito!!\');	
	location.reload(true);
}


</script>';

$html.= '<h1 style="background-color:'.$color_suave.';">Mesa de Examenes / ABM Mesa de examenes</h1>';
include('menu_normalizados.php');
$html.='
<div class="form">
<div class="triangulo" style="border-top-color:'.$color.'; margin-top:-20px; margin-left:190px; position:fixed;"></div><br>';

$fecha_examenes = dbConsultar($base,"select idfecha_examenes as id,anio_lectivo,to_char (fecha,'DD/MM/YYYY') as fecha from FECHA_MESA_EXAMENES ");
$html.='
'.nota($color,'Administre las mesas de examenes, Alta, baja y modificación.').'<br>
<div style="max-height:400px; overflow-y:scroll; width:500px; border:0px solid rgba(0,0,0,.2);">
<table class="tabla" border="0" style="width:100%;">
<tr> <th align="center">A&ntilde;o Lectivo</th><th align="center">Fecha</th></tr>';
while($fechas = pg_fetch_row($fecha_examenes)){
	$html.= '<tr onclick="traer_datos('.$fechas[0].',\''.$fechas[2].'\')"><td align="center" >'.$fechas[1].'</td><td align="center" >'.$fechas[2].'</td>
	</tr>';
}
$html.= '</table>
</div>';
$html.='<br><hr><br><table border=0 style="width:500px;">
	<tr>
		<td>FECHA DE LA MESA DE EXAMEN: </td>
		<td align=right>
			<input type="text" id="element_1_2" size="1" maxlength="2" placeholder="dd" value="'.$dia.'">
			<input type="text" id="element_1_1" size="1" maxlength="2" placeholder="mm" value="'.$mes.'">
			<input type="text" id="element_1_3" size="2" maxlength="4" placeholder="aaaa" value="'.$anio.'">
			<img id="cal_img_1" class="datepicker" src="../imagenes/calendario.png" title="Click para seleccionar una fecha">	
			<script type="text/javascript">
				Calendar.setup({
				inputField	 : "element_1_3",
				baseField    : "element_1",
				displayArea  : "calendar_1",
				button		 : "cal_img_1",
				ifFormat	 : "%B %e, %Y",
				onSelect	 : selectDate
				});
			</script>
		</td>
	</tr>
	<tr>
  		<td valign=bottom align=right colspan=2><br><div id="divboton"><a href="#" class="btn" onclick="agregar()">Agregar</a></div></td> 
  	</tr>
<input type="hidden" id="idfecha" />
</table>
<br>
<div id="mesas"></div>

<iframe style="display:none;" onload="trae_comision(\'Comision Modificada con éxito\')"></iframe>
';

include($prof."template.php");
?>

