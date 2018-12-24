<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$notas = explode(',',$_POST['notas']);
$inscripciones = explode(',',$_POST['inscripciones']);
$presentes = explode(',',$_POST['presentes']);
$libfol = $_POST['libfol'];
$fecha = $_POST['fecha'];

$base = dbConectar();

for($i=0;$i<sizeof($notas);$i++){
	if($notas[$i]!=''){
	    $consulta = dbConsultar($base,"select * from notas where id_inscripcion = ".$inscripciones[$i]);
		if($fila = pg_fetch_row($consulta)){
			if($presentes[$i]=='P') $cadena.= 'update notas set nota = '.$notas[$i].',estado = \'Exa\' where id_inscripcion = '.$inscripciones[$i].';';
			else $cadena.= 'update notas set nota = -1,estado = \'Aus\' where id_inscripcion = '.$inscripciones[$i].';';
		}
		else{
			if($presentes[$i]=='P') $cadena.= "insert into notas(id_inscripcion,nota,foperacion,usuario,tipo,libro,estado,fecha) values(".$inscripciones[$i].",".$notas[$i].",now(),'".$_SESSION['usuario']."','E','".$libfol."','Exa','".$fecha."');";
			else $cadena.= "insert into notas(id_inscripcion,nota,foperacion,usuario,tipo,libro,estado,fecha) values(".$inscripciones[$i].",-1,now(),'".$_SESSION['usuario']."','E','".$libfol."','Aus','".$fecha."');";
		}
	}	
}

$insertar = dbConsultar($base,$cadena);

if($insertar){
    echo 'Notas cargadas con éxito
    <iframe onload="eligemateria(\'Notas cargadas con éxito\')" style="display:none;"></frame>';  
}
?>