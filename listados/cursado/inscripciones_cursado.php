<?php
session_start();
include('sesion.php');
include('variables.php');
$prof='../../';
include($prof.'funciones/bd.php');
//Prototipo Funcion java con ajax
/*function fcion(){
    var val=document.getElementById("id").value;
    document.getElementById("div").innerHTML = "Cargando";
    cadena = "dato1=" + val + "&dato2=0";
	new ajax ("busqueda.php",{postBody: cadena ,update: $("div")});
};*/
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

function mostrar_materias ()
{
var carrera = document.getElementById("carrera").value;
var idalumno =  document.getElementById("idalumno").value;

new ajax ("aj_materias.php", {postBody:  "carrera="+carrera+"&idalumno="+idalumno,update: $("materias")});

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

function validar_datos(){
	var idcarrera =  document.getElementById("carrera").value;
	var idalumno =  document.getElementById("idalumno").value;
	var xmaterias = document.getElementsByName("chkmaterias");
	var mat_inscr = [];

	for(i=0;i<xmaterias.length;i++){
		if(xmaterias[i].checked) mat_inscr.push(xmaterias[i].value);
	}

	cadena = "materias=" + mat_inscr + "&idalumno=" + idalumno + "&idcarrera=" + idcarrera;
	new ajax ("aj_insertar.php",{postBody: cadena ,update: $("estado")});
};

function blanco(){
	 document.getElementById("materias").innerHTML ="";
	 document.getElementById("idalumno").value = document.getElementById("carrera").options[document.getElementById("carrera").selectedIndex].id;
}

function marcar(source) 
	{
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
$base = dbConectar();
$provincias = dbConsultar($base,"select * from provincias order by provincia");
$localidades = dbConsultar($base,"select * from localidades order by localidad");
$carreras = dbConsultar($base,"select idcarrera,carrera from carreras where idcarrera in (22,23,26,30,32) order by carrera");


//$materias = dbConsultar($base,"select * from v_inscripcion_cursado b where idalumno=$idalumno");


include('../menu_inscripciones.php');
$html.='
<div class="form">

<table border=0 width="100%">
<tr><td><b>Inscripción a Cursado</b></td></tr>
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
