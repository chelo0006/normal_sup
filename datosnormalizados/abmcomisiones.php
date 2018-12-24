<?php
session_start();
include('sesion.php');
include('variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php'); 

$base = dbConectar();
//   document.getElementById("comisiones").innerHTML="<img src="cargando.gif">;

$java = '<script src="'.$prof.'scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/prototype.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/moo.ajax.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/behaviour.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript"> 
function cargar(){

}
function agregar(idcarrera){
	var comision = document.getElementById("comision").value;
	var anio = document.getElementById("anio").value;
	var idcarrera = document.getElementById("idcarrera").value;
	var id = document.getElementById("id").value;
	var selanio = document.getElementById("selanio").value;
	var cupo = document.getElementById("cupo").value;
	new ajax ("aj_insertar_comisiones.php",{postBody: "&idcarrera="+idcarrera+"&anio="+anio+"&comision="+comision+"&id="+id+"&selanio="+selanio+"&cupo="+cupo ,update: $("estado")});
}

function modificar(idcarrera){
	var comision = document.getElementById("comision").value;
	var cupo = document.getElementById("cupo").value;
	var anio = document.getElementById("anio").value;
	var idcarrera = document.getElementById("idcarrera").value;
	var id = document.getElementById("id").value;
	var selanio = document.getElementById("selanio").value;
	new ajax ("aj_modificar_comisiones.php",{postBody: "&idcarrera="+idcarrera+"&anio="+anio+"&comision="+comision+"&id="+id+"&selanio="+selanio+"&cupo="+cupo ,update: $("estado")});
}

function eliminar(idcarrera){
	var id = document.getElementById("id").value;
	new ajax ("aj_eliminar_comisiones.php",{postBody: "&id="+id ,update: $("comisiones")});
}
function trae_comision(mensaje=""){
	document.getElementById("comisiones").innerHTML="<div class=\'lds-ellipsis\'><div></div><div></div><div></div><div></div></div>";
    var idcarrera = document.getElementById("idcarrera").value;
    new ajax ("aj_comisiones.php",{postBody: "&idcarrera="+idcarrera ,update: $("comisiones")});
    if(mensaje!=""){
    	pop(0,"Atencion: No se encuentra el alumno",mensaje,400,150,"","","'.$prof.'");
    }
	traer_datos(-1);
}
function traer_datos(idcomision){
	document.getElementById("datos_comision").innerHTML="<div class=\'lds-ellipsis\'><div></div><div></div><div></div><div></div></div>";
    var idcarrera = document.getElementById("idcarrera").value;
    new ajax ("aj_datos_comisiones.php",{postBody: "idcomision="+idcomision+"&idcarrera="+idcarrera ,update: $("datos_comision")});
}
function finalizar_inscripcion(){ 
	alert (\'Comision actualizada con exito!!\');	
	location.reload(true);
}


</script>';
$html.= '<h1 style="background-color:'.$color_suave.';">Comisiones / Alta de comisiones</h1>';

include('menu_normalizados.php');

$html.='
<div class="form">
<div class="triangulo" style="border-top-color:'.$color.'; margin-top:-20px; margin-left:35px; position:fixed;"></div><br>
'.nota($color,'Administre las comisiones segun la carrera seleccionada.').'<br>';

$html.='
<table border=0 style="width:500px;">
<tr><td>A&ntilde;o</td><td>';
$html.= selanio('selanio',date('Y'),'cambia_anio()');

$html.='</b></td></tr>
';



$html.='	<tr><td>Carrera:</td><td>';
	$carrera = dbConsultar($base,"select idcarrera,carrera from carreras where idcarrera in (22,23,30,32,26) order by carrera");

			$html.='<select id="idcarrera" style="width:500px;" onchange="trae_comision()">
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
<div id="datos_comision"></div>
';

include($prof."template.php");
?>

