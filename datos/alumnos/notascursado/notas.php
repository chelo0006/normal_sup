<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
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
function eligemateria(mensaje=""){
    var xcarrera = document.getElementById("carrera").value;
    var xanio = document.getElementById("anio").value;
    var xmateria = document.getElementById("materia").value; 
    var xcomision = document.getElementById("comision").value;
    var xanio_lectivo = document.getElementById("selanio").value;
    var xfecha = document.getElementById("element_1_3").value+"-"+document.getElementById("element_1_1").value+"-"+document.getElementById("element_1_2").value;
    
    if(xmateria!=0){
        document.getElementById("div_alumnos").innerHTML = "<div class=\'lds-ellipsis\'><div></div><div></div><div></div><div></div></div>";
        cadena = "carrera=" + xcarrera + "&anio=" +xanio + "&materia="+xmateria+ "&comision="+xcomision+ "&anio_lectivo="+xanio_lectivo+ "&fecha="+xfecha;
    	new ajax ("aj_alumnos_lista.php",{postBody: cadena ,update: $("div_alumnos")});
    }
    if(mensaje!=""){
        pop(0,"Atencion:",mensaje,400,150,"","","'.$prof.'");
    }
};
function guardar(fecha,fecha_fin){
     var xnotas =  document.getElementsByName("notas");
     var xestado =  document.getElementsByName("estado");
     var xinscripciones =  document.getElementsByName("inscripciones");
     var arreglo_notas = [];
     var arreglo_inscripciones = [];
     var arreglo_estados = [];
     
     todosblancos = 1;
     todosvacios = 1;
     errornota = 0;
     for(i=0;i<xnotas.length;i++){
        arreglo_notas.push(xnotas[i].value); 
        arreglo_inscripciones.push(xinscripciones[i].value); 
        arreglo_estados.push(xestado[i].value); 
        if(xnotas[i].value!="") todosblancos = 0;
        if(xestado[i].value!="-1") todosvacios = 0;
     } 
     if(todosblancos==0 || todosvacios==0){
        for(i=0;i<xestado.length;i++){
            if(xestado[i].value=="Pro"){
                if(xnotas[i].value=="") errornota = 1;
            }
        }
        if(errornota == 0){
            cadena = "notas="+arreglo_notas+"&inscripciones="+arreglo_inscripciones+"&estados="+arreglo_estados+"&fecha="+fecha+"&fecha_fin="+fecha_fin;
        	new ajax ("aj_insertar_notas.php",{postBody: cadena ,update: $("estado")});
        }
        else pop(0,"Atencion:","Faltan notas de promoción. Por favor revise e intente nuevamente.",400,150,"","","'.$prof.'");
     } 
     else{
        pop(0,"Atencion:","No se ingresó ninguna nota o estado. Por favor revise e intente nuevamente.",400,150,"","","'.$prof.'");
     }
}
function exito(){
    pop(0,"Atencion:","Estado/s agregado/s con éxito.",400,150,"","","'.$prof.'");
    cargar();
	
};
function cambia_estado(){
    var xestado =  document.getElementsByName("estado");
    var xnotas =  document.getElementsByName("notas");

    for(i=0;i<xestado.length;i++){
        if(xestado[i].value=="Pro") xnotas[i].disabled = false;
        else{
            xnotas[i].value = "";
            xnotas[i].disabled = true;
        }
    }

};
function revalida(materia,idalumno,fecha_fin){
    cadena = "materia=" + materia + "&idalumno=" +idalumno+ "&fecha_fin=" +fecha_fin;
    new ajax ("aj_revalidar.php",{postBody: cadena ,update: $("estado")});
};
</script>';
//<img src="../imagenes/cargar.gif"></img>
$html.= '<h1 style="background-color:'.$color_suave.';">Alumnos / Notas cursado</h1>';
include('../menu_alumnos.php');
$base = dbConectar();
$carreras = dbConsultar($base,"select idcarrera,carrera from carreras where carrera is not null and idcarrera not in (6,18,27,31) and idcarrera in (22,23,26,30,32) order by carrera");

$html.= '<div class="form">
<div class="triangulo" style="border-top-color:'.$color.'; margin-top:-20px; margin-left:28px; position:fixed;"></div><br>
'.nota($color,'Cargue las notas de las diferentes comisiones según el año lectivo indicado.').'<br>
<b>Año lectivo</b> ';
$html.= selanio('selanio',date('Y'),'cambia_anio()');

$ultima_fec = dbConsultar($base,"select max(fecha) as fecha from notas where tipo = 'C'");
$ultima_fecha = dbfila($ultima_fec);
if($ultima_fecha[dbcampo($ultima_fec, 'fecha')]!=""){
    $f = explode('-',$ultima_fecha[dbcampo($ultima_fec, 'fecha')]);
    $fdia = $f[2];
    $fmes = $f[1];
    $fanio= $f[0];
}
else{
    $fdia = date('d');
    $fmes = date('m');
    $fanio= date('Y');
}

$html.='<hr><br>
<table>
<tr><td>
<b>Fecha de regularidad:</b>
        <input type="text" id="element_1_2" size="1" maxlength="2" placeholder="dd" value="'.$fdia.'">
            <input type="text" id="element_1_1" size="1" maxlength="2" placeholder="mm" value="'.$fmes.'">
            <input type="text" id="element_1_3" size="2" maxlength="4" placeholder="aaaa" value="'.$fanio.'">
            <img id="cal_img_1" class="datepicker" src="'.$prof.'imagenes/calendario.png" title="Click para seleccionar una fecha"> 
        <script type="text/javascript">
            Calendar.setup({
            inputField   : "element_1_3",
            baseField    : "element_1",
            displayArea  : "calendar_1",
            button       : "cal_img_1",
            ifFormat     : "%B %e, %Y",
            onSelect     : selectDate
            });
        </script></td><td></td></tr></table><br>
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
