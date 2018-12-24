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
    document.getElementById("div_alumnos").innerHTML = "";
    document.getElementById("div_anio").innerHTML = "Cargando...";
    cadena = "idcarrera=" + xcarrera;
	new ajax ("aj_anio.php",{postBody: cadena ,update: $("div_anio")});
};
function eligeanio(){
    var xcarrera = document.getElementById("carrera").value;
    var xanio = document.getElementById("anio").value;
    document.getElementById("div_alumnos").innerHTML = "";
    document.getElementById("div_materia").innerHTML = "Cargando...";
    cadena = "carrera=" + xcarrera + "&anio=" +xanio;
	new ajax ("aj_materias_lista.php",{postBody: cadena ,update: $("div_materia")});
};
function cargar_comisiones(){
    var xcarrera = document.getElementById("carrera").value;
    var xanio = document.getElementById("anio").value;

    document.getElementById("div_comision").innerHTML = "Cargando...";
    cadena = "carrera=" + xcarrera + "&anio=" +xanio;
    new ajax ("aj_materias_comisiones.php",{postBody: cadena ,update: $("div_comision")});
};
function eligemateria(){
    var xcarrera = document.getElementById("carrera").value;
    var xanio = document.getElementById("anio").value;
    var xmateria = document.getElementById("materia").value; 
    var xcomision = document.getElementById("comision").value;
    var xanio_lectivo = document.getElementById("selanio").value;
    
    if(xmateria!=0){
        document.getElementById("div_alumnos").innerHTML = "Cargando...";
        cadena = "carrera=" + xcarrera + "&anio=" +xanio + "&materia="+xmateria+ "&comision="+xcomision+ "&anio_lectivo="+xanio_lectivo;
    	new ajax ("aj_alumnos_lista.php",{postBody: cadena ,update: $("div_alumnos")});
    }
};
function imprimir(){
    var xcarrera = document.getElementById("carrera").value;
    var xanio = document.getElementById("anio").value;
    var xmateria = document.getElementById("materia").value; 
    var xcomision = document.getElementById("comision").value;
    var xanio_lectivo = document.getElementById("selanio").value;
     
    cadena = "carrera=" + xcarrera + "&anio=" +xanio + "&materia="+xmateria+ "&comision="+xcomision+ "&anio_lectivo="+xanio_lectivo;
    window.open ("'.$prof.'listados/pdfs/cursadoxcomision.php?"+cadena);
}
function exito(){
    pop(0,"Atencion:","Nota/s agregada/s con éxito.",400,150,"","","'.$prof.'");
    cargar();
	
};
</script>';

$html.= '<h1 style="background-color:'.$color_suave.';">Alumnos / Por carrera y comisión</h1>';
include('carrera_comision_menu.php');
$base = dbConectar();
$carreras = dbConsultar($base,"select idcarrera,carrera from carreras where carrera is not null and idcarrera not in (6,18,27,31) and idcarrera in (22,23,26,30,32) order by carrera");

$html.= '<div class="form">
<div class="triangulo" style="border-top-color:'.$color_suave.'; margin-top:-20px; margin-left:28px;"></div>
'.nota($color,'Descargar listado de alumnos de las diferentes comisiones según el año lectivo indicado.').'
<b>Año lectivo</b> ';
$html.= selanio('selanio',date('Y'),'cambia_anio()');
$html.='<hr><br>
<table><tr><td><b>Carrera:</b></td><td><b>Año:</b></td><td><b>Materia:</b></td><td><b>Comisión:</b></td></tr>
<tr><td><select id="carrera" onchange="eligecarrera()" >
									<option value="0">Seleccionar</option>';
									while($fila = pg_fetch_row($carreras)){
										$html.='<option value="'.$fila[0].'">'.$fila[1].'</option>';
									}
									$html.='</select></td>
        <td><div id="div_anio"><select id="anio">
            <option value="0">Seleccionar</option>
        </select></div></td>
        
        <td><div id="div_materia">
            <select id="materia">
            <option value="0">Seleccionar</option>
        </select></div>
        </td>
        <td><div id="div_comision">
            <select id="comision">
            <option value="0">Seleccionar</option>
        </select></div>
        </td>
        </tr>
        </table><br>
        <div id="div_alumnos">
        
        </div>
        ';
$html.= '<iframe onload="cargar()" style="display:none;"></iframe></div>';

include($prof."template.php");
?>
