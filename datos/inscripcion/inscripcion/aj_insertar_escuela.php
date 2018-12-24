<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$nombre = $_POST['nombre'];
$cue = $_POST['cue'];
$anexo = $_POST['anexo'];

$base = dbConectar();
$existe = dbConsultar($base,"select * from establec where cue = $cue and anexo = $anexo");

if(dbCount($existe)>0) echo '<iframe onload="yaexiste()" style="display:none;"></iframe>';
else{
	$insertar = dbConsultar($base,"insert into establec(cue,anexo,nombre)
									values($cue,$anexo,'$nombre')");
	if($insertar) echo '<iframe onload="esc_insertada()" style="display:none;"></iframe>';
}

echo '
';

?>