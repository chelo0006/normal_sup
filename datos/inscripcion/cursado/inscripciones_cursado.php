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
function buscar_dni(){
var dni = document.getElementById("dni").value;
 
if (dni!=""){
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

function mostrar_materias(mensaje=""){
	var carrera = document.getElementById("carrera").value;
	var idalumno =  document.getElementById("idalumno").value;
	var anio_lectivo =  document.getElementById("selanio").value;
	if(carrera != 0){
		if(idalumno!=0){
			document.getElementById("materias").innerHTML = "<div class=\'lds-ellipsis\'><div></div><div></div><div></div><div></div></div>";
			new ajax ("aj_materias.php", {postBody:  "carrera="+carrera+"&idalumno="+idalumno+"&anio_lectivo="+anio_lectivo,update: $("materias")});
		}
		if(mensaje!=""){
	        pop(0,"Atencion:",mensaje,400,150,"","","'.$prof.'");
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
};

function traedni(dni){
	document.getElementById("dni").value = dni;
	buscar_dni();
	cerrar();
};

function finalizar_inscripcion(){
	pop(0,"Atencion:","Inscripción realizada con éxito",400,150,"","","'.$prof.'");
	location.reload(true);
};

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
};

function marcar(source){
	checkboxes=document.getElementsByTagName("input"); //obtenemos todos los controles del tipo Input
	for(i=0;i<checkboxes.length;i++) //recoremos todos los controles
	{
		if(checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
		{
			checkboxes[i].checked=source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
		}
	}
};

function excepcion(idalumno,idcarrera){ 
	pop(1,"Incribir en nueva materia","",550,235,"excepcion.php","idalumno="+idalumno+"&idcarrera="+idcarrera,"'.$prof.'");
};

function inscripcion_excepcion(idalumno,idcarrera){
	var materias_excepcion =  document.getElementById("materias_excepcion").value;
	var observaciones =  document.getElementById("observaciones").value;
    var selanio= document.getElementById("selanio").value;
    var anio_lectivo= document.getElementById("anio_lectivo").value;
    var fecha = anio_lectivo+"-03-31";

	if (document.getElementById("comisiones_excepcion")){
	    var comisiones_excepcion =  document.getElementById("comisiones_excepcion").value;
	}

	if (observaciones=="" || materias_excepcion==0) {
		document.getElementById("mensaje_excepcion").innerHTML="<div class=\"notita\" style=\"border:2px solid '.$color.';\">Faltan datos, verifique!!</div>";
	}
	else{
		new ajax ("aj_inserta_excepcion.php", {postBody:  "idcarrera="+idcarrera+"&idalumno="+idalumno+"&comisiones_excepcion="+comisiones_excepcion+"&observaciones="+observaciones+"&materias_excepcion="+materias_excepcion+"&selanio="+selanio+"&fecha="+fecha,update: $("estado")});
	}
};

function comision_excepcion(idcarrera,idalumno){
	var materia =  document.getElementById("materias_excepcion").value;
	new ajax ("aj_excepcion_comision.php", {postBody:  "idcarrera="+idcarrera+"&idalumno="+idalumno+"&materia="+materia,update: $("excepcion")});
};

function mensaje_error_excepcion(){
	document.getElementById("mensaje_excepcion").innerHTML="<div class=\"notita\" style=\"border:2px solid '.$color.';\">El alumno ya se encuentra inscripto en la materia selecciona, verifique!!</div>";
};
</script>';
$base = dbConectar();
$provincias = dbConsultar($base,"select * from provincias order by provincia");
$localidades = dbConsultar($base,"select * from localidades order by localidad");
$carreras = dbConsultar($base,"select idcarrera,carrera from carreras where idcarrera in (22,23,26,30,32) order by carrera");

$html.= '<h1 style="background-color:'.$color_suave.';">Inscripción / Cursado</h1>';

include('../menu_inscripciones.php');

$html.='
<div class="form">
<div class="triangulo" style="border-top-color:'.$color.'; margin-top:-20px; margin-left:135px; position:fixed;"></div><br>
'.nota($color,'Inscribir a los alumnos para cursar una materia de la carrera correspondiente.').'<br>
<table border=0 width="100%">
<tr><td><b>Inscripción a Cursado';
$html.= selanio('selanio',date('Y'),'cambia_anio()');

$html.='</b></td></tr>
</table>

<table border=0>

<tr><td></td></tr>

<tr><td>DNI Nro: </td><td><table border=0 width=100%><tr><td><input type="text" onkeypress="validar_enter(event,buscar_dni)" maxlength="8" value="28223817" size="8" id="dni" style="width:100%;" / ></td><td align=right><a onclick="buscar_dni()" class="btn">Buscar</a></td><td><a href="#" 
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
