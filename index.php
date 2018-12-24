<?php
session_start();
include('variables.php');
//Prototipo Funcion java con ajax
/*function fcion(){
    var val=document.getElementById("id").value;
    document.getElementById("div").innerHTML = "Cargando";
    cadena = "dato1=" + val + "&dato2=0";
	new ajax ("busqueda.php",{postBody: cadena ,update: $("div")});new ajax ("chklogin.php",{postBody: "usuario="+user+"&clave="+pass});
};*/
if(isset($_GET['e'])) $error = '?e=1';
else $error = '';

$java = '<script src="'.$prof.'scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/prototype.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/moo.ajax.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/behaviour.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function cargar(){
    setTimeout(otro,10);
}
function enviar(){
	var user = document.getElementById("usuario").value;
	var pass = document.getElementById("pass").value;
	window.location.href = "chklogin.php?usuario="+user+"&clave="+pass;
}
function pulsar(e) {
    if (e.keyCode === 13 && !e.shiftKey) {
        enviar();
    }
}
function otro(){
    pop(1,"Login","",300,350,"login.php'.$error.'","datos=2","'.$prof.'");
}
</script>';

$html = '

<iframe onload="cargar()" style="display:none;"></iframe>
';

include($prof."template.php");
?>
