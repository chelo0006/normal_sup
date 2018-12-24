<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$notas = explode(',',$_POST['notas']);
$inscripciones = explode(',',$_POST['inscripciones']);
$estados = explode(',',$_POST['estados']);
$fecha = $_POST['fecha'];
$fecha_fin = $_POST['fecha_fin'];
$base = dbConectar();

for($i=0;$i<sizeof($notas);$i++){
	if($notas[$i]=="") $nota = -1;
	else $nota = $notas[$i];
    $consulta = dbConsultar($base,"select * from notas where id_inscripcion = ".$inscripciones[$i]);
    if($estados[$i]!=-1){
		if($fila = pg_fetch_row($consulta)){
			if($nota==-1) $cadena.= 'update notas set nota = '.$nota.', estado = \''.$estados[$i].'\',foperacion=now(), fecha=\''.$fecha.'\', fecha_fin=\''.$fecha_fin.'\' where id_inscripcion = '.$inscripciones[$i].';';
			else $cadena.= 'update notas set nota = '.$nota.', estado = \''.$estados[$i].'\',foperacion=now(), fecha=\''.$fecha.'\' where id_inscripcion = '.$inscripciones[$i].';';
		}
		else{
			if($nota==-1) $cadena.= "insert into notas(id_inscripcion,nota,estado,foperacion,usuario,tipo,fecha,fecha_fin) values(".$inscripciones[$i].",".$nota.",'".$estados[$i]."',now(),'".$_SESSION['usuario']."','C','".$fecha."','".$fecha_fin."');";
			else $cadena.= "insert into notas(id_inscripcion,nota,estado,foperacion,fecha_fin,usuario,tipo) values(".$inscripciones[$i].",".$nota.",'".$estados[$i]."',now(),'".$fecha_fin."','".$_SESSION['usuario']."','C');";
		}
	}
	else{
		$consulta = dbConsultar($base,"delete from notas where id_inscripcion = ".$inscripciones[$i]);
	}
}


$insertar = dbConsultar($base,$cadena);

if($insertar){
    echo 'Estados cargados con éxito
    <iframe onload="eligemateria(\'Estados agregados con éxito\')" style="display:none;"></frame>';  
}
?>