<?php
session_start();
include('sesion.php');
include('variables.php');
$prof='../../';

include($prof.'funciones/bd.php');
$dni=$_POST['dni'];

if ($dni=='')
{
$dni=0;	
};

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
</script>';
$existe=0;
$base = dbConectar();
$persona = dbConsultar($base,"select distinct a.dni,a.apellido||' '||a.nombre as apynombre,a.idpersona,b.idalumno from personas a, alumno b where a.dni='$dni' and a.idpersona = b.idpersona");
$fila = pg_fetch_row($persona);
if ($fila>0)
{
	$_SESSION['idpersona']=$fila[2];
$html.='
		
 <tr>ALUMNO: <td><input type="text" maxlength="8" size="50" disabled id="dni" value="'.$fila[1].'" style="width:100%;" /><input type="hidden" id="idalumno" value="'.$fila[3].'"></input></td> </tr> 
';	
$existe=1;
$html.='<iframe onload="cargar_carrera(\''.$dni.'\')" style="display:none;"></iframe>';
}
else
{
$html.='
<br>		
 <tr><td> <p style="color:#FF0000";> NO EXISTE ALUMNO INGRESADO, VERIFIQUE!! </p> </td> </tr> 
';	
$existe=2;
};


echo $html;

?>
