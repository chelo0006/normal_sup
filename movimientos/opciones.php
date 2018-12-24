<?php
session_start();
include('sesion.php');
include('variables.php');
include($prof.'funciones/bd.php');

$java = '<script src="'.$prof.'scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/prototype.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/moo.ajax.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/behaviour.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function cargar(){
	
}
</script>';

$html.='<table style="width:100%; height:90%; border:1px solid rgba(0,0,0,.2); text-align:center;"><tr><td>
    Seleccione una opcion para continuar
</td></tr></table>';
$html.= '<iframe onload="cargar()" style="display:none;"></iframe>';

include($prof."template.php");
?>