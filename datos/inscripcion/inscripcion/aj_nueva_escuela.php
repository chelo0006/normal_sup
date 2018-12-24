<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$clave = $_POST['clave'];

echo '

<div style="height:6px;"></div>
<b>Ingrese algunos datos minimos del nuevo establecimiento</b>
<div style="height:10px;"></div>

<hr>

<table width=80%>
	<tr>	<td><b>Nombre: </b>	</td><td>	<input style="width:100%" type="text" id="nnombre" value="'.$clave.'" />	</td></tr>
	<tr>	<td><b>CUE: </b>	</td><td>	<input style="width:40%" type="text" id="ncue"/>
											<b>Anexo: </b><input style="width:20%" type="text" id="nanexo"/>	</td></tr>
</table>
<br>
<hr>
<div id="div_proc_esc"></div>
<a href="#" class="btn" onclick="cerrar()">Cerrar</a> <a href="#" class="btn" onclick="agregar_nva_esc()">Agregar</a>

';
?>