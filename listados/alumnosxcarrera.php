<?php
session_start();
include('sesion.php');
include('variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$java = '<script src="'.$prof.'scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/prototype.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/moo.ajax.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/behaviour.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function cargar(){

}
function eligecarrera(){
    var xcarrera = document.getElementById("carrera").value;
    var xanio_lectivo = document.getElementById("selanio").value;
    var xsexo = document.getElementById("sexo").value;
	
    document.getElementById("div_alumnos").innerHTML = "<div class=\'lds-ellipsis\'><div></div><div></div><div></div><div></div></div>";
    
    cadena = "carrera=" + xcarrera + "&anio_lectivo="+xanio_lectivo + "&sexo="+xsexo;
	new ajax ("aj_alumnos_lista_carrera.php",{postBody: cadena ,update: $("div_alumnos")});
};
function imprimir(){
    var xcarrera = document.getElementById("carrera").value;
    var xanio_lectivo = document.getElementById("selanio").value;
    var xsexo = document.getElementById("sexo").value;
     
    cadena = "carrera=" + xcarrera + "&anio_lectivo="+xanio_lectivo + "&sexo="+xsexo;
    window.open ("'.$prof.'listados/pdfs/cursadoxcarrera.php?"+cadena);
}
function exito(){
    pop(0,"Atencion:","Nota/s agregada/s con éxito.",400,150,"","","'.$prof.'");
    cargar();
	
};
</script>';

$html.= '<h1 style="background-color:'.$color_suave.';">Alumnos / Por carrera</h1>';
include('carrera_comision_menu.php');
$base = dbConectar();
$carreras = dbConsultar($base,"select idcarrera,carrera from carreras where carrera is not null and idcarrera not in (6,18,27,31) and idcarrera in (22,23,26,30,32) order by carrera");

$html.= '<div class="form">
<div class="triangulo" style="border-top-color:'.$color.'; margin-top:-20px; margin-left:240px; position:fixed;"></div>
'.nota($color,'Descargar listado de alumnos de las diferentes carreras según el año lectivo indicado.').'
<br><b>Año lectivo</b> ';
$html.= selanio('selanio',date('Y'),'cambia_anio()');
$html.='<hr><br>
<table><tr><td><b>Carrera:</b></td></tr>
<tr><td><select id="carrera" >
									<option value="0">Seleccionar</option>';
									while($fila = pg_fetch_row($carreras)){
										$html.='<option value="'.$fila[0].'">'.$fila[1].'</option>';
									}
									$html.='</select></td>
<td>&nbsp;&nbsp;&nbsp;      </td><td><b> Sexo:</b></td><td><select id="sexo" onchange="eligecarrera()" >
									<option value="0">Seleccionar</option>';
									
										$html.='<option value=1>MASCULINO</option>';
										$html.='<option value=2>FEMENINO</option>';										
									
									$html.='</select></td>									
       
        </tr>
        </table><br>
        <div id="div_alumnos">
        
        </div>
        ';
$html.= '<iframe onload="cargar()" style="display:none;"></iframe></div>';

include($prof."template.php");
?>
