<?php
session_start();
include('variables.php');
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
$html = '




<iframe onload="cargar()" style="display:none;"></iframe>
';

include($prof."template.php");
?>