<?php
session_start(); 
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');
if(isset($_GET['anio'])) $anio_lectivo = $_GET['anio'];
else $anio_lectivo = date('Y');

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
function eligemateria(mensaje=""){
    var xcarrera = document.getElementById("carrera").value;
    var xanio = document.getElementById("anio").value;
    var xmateria = document.getElementById("materia").value;
    var xanio_lectivo = document.getElementById("selanio").value;
    var xfecha = document.getElementById("fecha").value;
    
    if(xmateria!=0){
        document.getElementById("div_alumnos").innerHTML = "<div class=\'lds-ellipsis\'><div></div><div></div><div></div><div></div></div>";
        cadena = "carrera=" + xcarrera + "&anio=" +xanio + "&materia=" + xmateria + "&anio_lectivo=" + xanio_lectivo + "&fecha=" + xfecha;
    	new ajax ("aj_alumnos_lista.php",{postBody: cadena ,update: $("div_alumnos")});
    }
    if(mensaje!=""){
        pop(0,"Atencion:",mensaje,400,150,"","","'.$prof.'");
    }
};
function guardar(){
     var xnotas = document.getElementsByName("notas");
     var xinscripciones = document.getElementsByName("inscripciones");
     var xpresentes = document.getElementsByTagName("select");
     var xlibfol = document.getElementById("libfol").value;
     var xfecha = document.getElementById("fecha").value;
     var arreglo_notas = [];
     var arreglo_presentes = [];
     var arreglo_inscripciones = [];

     todosblancos = 1;
     for(i=0;i<xnotas.length;i++){
        arreglo_notas.push(xnotas[i].value); 
        arreglo_inscripciones.push(xinscripciones[i].value); 
        arreglo_presentes.push(xpresentes[i+5].value); 
        if(xnotas[i].value!="") todosblancos = 0;
     } 
     if(todosblancos==0){
        if(xlibfol != ""){
            cadena = "notas="+arreglo_notas+"&inscripciones="+arreglo_inscripciones+"&presentes="+arreglo_presentes+"&libfol="+xlibfol+"&fecha="+xfecha;
        	new ajax ("aj_insertar_notas.php",{postBody: cadena ,update: $("estado")});
        }
        else pop(0,"Atencion:","No se ingresó Libro y folio. Por favor revise e intente nuevamente.",400,150,"","","'.$prof.'");
     } 
     else{
        pop(0,"Atencion:","No se ingresó ninguna nota. Por favor revise e intente nuevamente.",400,150,"","","'.$prof.'");
     }
}
function exito(){
    pop(0,"Atencion:","Nota/s agregada/s con éxito.",400,150,"","","'.$prof.'");
    cargar();
	
};
function cambia_anio(){ 
    var xanio = document.getElementById("selanio").value;
    window.location.href ="notas.php?anio="+xanio;
};
</script>';

$html.= '<h1 style="background-color:'.$color_suave.';">Alumnos / Notas de examen</h1>';
include('../menu_alumnos.php');

$base = dbConectar();
$carreras = dbConsultar($base,"select idcarrera,carrera from carreras where carrera is not null and idcarrera not in (6,18,27,31) and idcarrera in (22,23,26,30,32) order by carrera");
$fechas = dbConsultar($base,"select to_char(fecha, 'DD/MM/YYYY') as fecha,* from fecha_mesa_examenes a where  anio_lectivo = $anio_lectivo order by a.fecha desc");

$html.= '<div class="form">
<div class="triangulo" style="border-top-color:'.$color.'; margin-top:-20px; margin-left:140px; position:fixed;"></div><br>
'.nota($color,'Cargue las notas según la fecha de la mesa indicada.').'<br>
<b>Notas</b>';
$html.= selanio('selanio',$anio_lectivo,'cambia_anio()');
$html.='<br><br>
<table><tr><td><b>Carrera:</b></td><td><b>Año:</b></td><td><b>Materia:</b></td><td><b>Fecha examen:</b></td></tr>
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
        <td><div id="div_fecha">
            <select id="fecha" onchange="eligemateria()">';
        $fila = pg_fetch_row($fechas);
          $html.='<option value="'.$fila[2].'">'.$fila[0].'</option>';
                    while($fila = pg_fetch_row($fechas)){
                        $html.='<option value="'.$fila[2].'">'.$fila[0].'</option>';
                    }
        $html.='</select></td></div>
        </td>
        </tr>
        </table><br>
        <div id="div_alumnos">
        
        </div>
        ';
$html.= '<iframe onload="cargar()" style="display:none;"></iframe></div>';

include($prof."template.php");
?>
