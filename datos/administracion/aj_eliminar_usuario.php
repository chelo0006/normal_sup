<?php
session_start();
include('sesion.php');
include('variables.php');
//$prof='../../';
$anio_lectivo=date("Y");

include($prof.'funciones/bd.php');
$dia=$_POST['dia'];
$mes=$_POST['mes'];
$anio=$_POST['anio'];
$fecha=$anio.'-'.$mes.'-'.$dia;




$html='';
 $fecha_actual = date($fecha);
//sumo 1 día
$fecha_inicio=date("d/m/Y",strtotime($fecha_actual."- 10 days")); 





if (isset($_POST['id']))
{
$id=$_POST['id'];		
}
else
{
$id=0;	
};


$base = dbConectar();

$consulta="select * from fecha_mesa_examenes where idfecha_examenes=$id";
$consulta2 = dbConsultar($base,$consulta);



if ($fila = pg_fetch_row($consulta2))
{
	//echo 'actualiza';
		  $cadena ="DELETE FROM fecha_mesa_examenes  where idfecha_examenes=$id";

	
	}




$inscribir = dbConsultar($base,$cadena);
if($inscribir) echo 'Examenes actualizado con éxito';



echo '<iframe style="display:none;" onload="finalizar_inscripcion()"></iframe>';



?>