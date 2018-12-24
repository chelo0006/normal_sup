<style> 
body{
    margin:0;
}
</style>
<?php 
session_start();

$consulta = $_POST['consulta'];
$parametro = $_POST['parametro'];
$funcion = $_POST['funcion'];
$campo = $_POST['campo'];
$porf = $_POST['prof'];

$cadena = "\"".$consulta.$parametro.$funcion.$campo.$porf."\"";

echo '
<table border=0 width=100% style="height:420px;" cellpadding=0 cellspacing=0>
<tr style="height:30px;">
<td style="padding:10px;">'.ucwords($parametro).':</td><td><input type="text" id="clave" onkeypress="validar_enter(event,buscar,'.$cadena.')" style="border:1px solid rgba(0,0,0,.2);
	height: 26px;
	color: rgba(0,0,0,.7);
	font-size: 15px;
	padding-left: 5px;
	-webkit-border-radius: 4px 4px 4px 4px;
	border-radius: 4px 4px 4px 4px;	
	-webkit-box-shadow: 1px 1px 2px 1px rgba(0,0,0,0.1);
	box-shadow: 1px 1px 2px 1px rgba(0,0,0,0.1);
	-webkit-transition: background-color 2s;
	transition: background-color 2s;
	transition-timing-function: ease;
	-webkit-transition-timing-function: ease;" ></td>
<td align=left><a href="#" class="btn" onclick="busqueda_grilla(\''.$consulta.'\',\''.$parametro.'\',\''.$funcion.'\','.$campo.',\''.$porf.'\')">Buscar</a>
</td>
</tr>
<tr>
<td colspan=3 style="background-color:rgba(100,100,100,1);">
<div id="div_grilla">

</div>
</td>
</tr>
</table><br>
<a href="#" class="btn" onclick="cerrar()" style="margin-top:-5px;">cerrar</a>

';
?>
