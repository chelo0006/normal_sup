<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$notas = explode(',',$_POST['notas']);
$inscripciones = explode(',',$_POST['inscripciones']);
$base = dbConectar();

for($i=0;$i<sizeof($notas);$i++){
	if($notas[$i]!=''){
	    $consulta = dbConsultar($base,"select * from notas where id_inscripcion = ".$inscripciones[$i]);
		if($fila = pg_fetch_row($consulta)) $cadena.= 'update notas set nota = '.$notas[$i].' where id_inscripcion = '.$inscripciones[$i].';';
		else $cadena.= "insert into notas(id_inscripcion,nota,foperacion,usuario,tipo) values(".$inscripciones[$i].",".$notas[$i].",now(),'".$_SESSION['usuario']."','C');";
	}
}

$insertar = dbConsultar($base,$cadena);

if($insertar){
    echo 'Notas cargadas con éxito<iframe onload="exito()" style="display:none;"></frame>';  
}
?>