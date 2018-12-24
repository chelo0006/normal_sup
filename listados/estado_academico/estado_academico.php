<?php
session_start(); 
include('sesion.php');
include($prof.'listados/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$java = '<script src="'.$prof.'scripts/AC_RunActiveContent.js" type="text/javascript"></script> 
<script src="'.$prof.'scripts/prototype.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/moo.ajax.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/behaviour.js" type="text/javascript"></script> 
<script language="JavaScript" type="text/JavaScript">
function cargar(){
	
}
function buscar_dni(){
var dni = document.getElementById("dni").value;
 
if (dni!="")
{
  document.getElementById("persona").innerHTML = "<div class=\'lds-ellipsis\'><div></div><div></div><div></div><div></div></div>";
  new ajax ("aj_personas.php", {postBody:  "dni="+dni,update: $("persona")});
  document.getElementById("datos_carrera").innerHTML="";
}
else
{
alert ("DEBE INGRESAR EL NUMERO DE DOCUMENTO");	
};

};
  
function cargar_carrera(dni){
	  new ajax ("aj_datos_carrera.php",{postBody:"dni="+dni,update: $("datos_carrera")});
};

function mostrar_materias (){
	var carrera = document.getElementById("carrera").value;
	var idalumno =  document.getElementById("idalumno").value;
	if(carrera != 0){
		if(idalumno!=0){
			document.getElementById("materias").innerHTML = "<div class=\'lds-ellipsis\'><div></div><div></div><div></div><div></div></div>";
			new ajax ("aj_listado_estado.php", {postBody:  "carrera="+carrera+"&idalumno="+idalumno,update: $("materias")});
		}
	}
};

function valida(e){
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla==8){
        return true;
    }
        
    // Patron de entrada, en este caso solo acepta numeros
    patron =/[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

function traedni(dni){
	document.getElementById("dni").value = dni;
	buscar_dni();
	cerrar();
}


function finalizar_inscripcion(){

alert (\'Inscripcion realizada con exito!!\');	
location.reload(true);

} 

function imprimir(){

var carrera = document.getElementById("carrera").value;
	var idalumno =  document.getElementById("idalumno").value;
		window.open("'.$prof.'listados/pdfs/imprimir_estado.php?carrera="+carrera+"&idalumno="+idalumno);


} 


function validar_datos(){
	var idcarrera =  document.getElementById("carrera").value;
	var idalumno =  document.getElementById("idalumno").value;
	var xmaterias = document.getElementsByName("chkmaterias");
	var xcomisiones = document.getElementsByTagName("select");
	var mat_inscr = [];
	var comisiones = [];

	cantidad = 0;
	for(i=0;i<xmaterias.length;i++){
		if(xmaterias[i].checked){
			mat_inscr.push(xmaterias[i].value);
			comisiones.push(xcomisiones[i+2].value);
			cantidad = cantidad + 1;
		}
	}
	if(cantidad!=0){
		cadena = "materias=" + mat_inscr + "&idalumno=" + idalumno + "&idcarrera=" + idcarrera + "&comisiones=" + comisiones;
		new ajax ("aj_insertar.php",{postBody: cadena ,update: $("estado")});
	}
	else pop(0,"Atencion:","Debe seleccionar las materias antes de inscribir",400,150,"","","'.$prof.'");
};

function blanco(){
	 document.getElementById("materias").innerHTML ="";
	 document.getElementById("idalumno").value = document.getElementById("carrera").options[document.getElementById("carrera").selectedIndex].id;
}

function marcar(source){
	checkboxes=document.getElementsByTagName("input"); //obtenemos todos los controles del tipo Input
	for(i=0;i<checkboxes.length;i++) //recoremos todos los controles
	{
		if(checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
		{
			checkboxes[i].checked=source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
		}
	}
}


</script>';

$html.= '<h1 style="background-color:'.$color_suave.';">Estado Académico</h1>';

include('../carrera_comision_menu.php');

$html.='
<div class="form">
<div class="triangulo" style="border-top-color:'.$color.'; margin-top:-20px; margin-left:370px; position:fixed;"></div><br>
'.nota($color,'Estado Académico de un alumno a buscar.').'<br>
<table border=0 width="100%">
';
$html.='</b></td></tr>
</table>

<table border=0>

<tr><td></td></tr>

<tr><td>DNI Nro: </td><td><table border=0 width=100%><tr><td><input type="text" onkeypress="return valida(event)" maxlength="8" value="28223817" size="8" id="dni" style="width:100%;" / ></td><td align=right><a onclick="buscar_dni()" class="btn">Buscar</a></td><td><a href="#" 
		onclick="cuadro_busqueda(\'Buscar alumno por apellido\',\'select dni,apellido,nombre from personas\',\'apellido\',\'traedni\',0,\''.$prof.'\')" class="btn">Buscar por apellido</a></td></tr></table></td>
		<td></td>
	</tr>
		<tr><td colspan="2"><div id="persona"></div></td></tr>

</table><hr><br>

<div id="datos_carrera"></div>

<hr><br>
</div>



';
$html.= '<iframe onload="cargar()" style="display:none;"></iframe>';

include($prof."template.php");
?>
