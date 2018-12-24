<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$idcarrera=$_POST['carrera'];
$idalumno=$_POST['idalumno'];

require($prof.'funciones/estado_academico.php');

$java = '<script src="'.$prof.'scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/prototype.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/moo.ajax.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/behaviour.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function cargar(){
	
}
</script>'; 
$base = dbConectar();

$arreglo_nombres = array();
$arreglo_materias = array();		
$arreglo_anio_insc = array(); 		
$arreglo_borrar = array();			

//idmateria ; año ; materia ; estado ; nota ; fecha_reg ; fecha_insc ; libro
for($i=1;$i<=sizeof($arreglo_estado_academico);$i++){
	if($arreglo_estado_academico[$i][3] == 'Reg'){
		array_push($arreglo_materias,$arreglo_estado_academico[$i][0]);
		array_push($arreglo_anio_insc,$arreglo_estado_academico[$i][1]);
		array_push($arreglo_nombres,$arreglo_estado_academico[$i][2]);

		$yainscrito = dbConsultar($base,"select * from inscripcion_examen where idcarrera = $idcarrera and idmateria = ".$arreglo_estado_academico[$i][0]." and idalumno = $idalumno and now() < fecha_inscripcion");
		if(dbCount($yainscrito)>0) $puedeborrarse = 1;
		else $puedeborrarse = 0;

		$tienemesas = dbConsultar($base,"select fecha from
					(select * from fecha_mesa_examenes a where anio_lectivo = ".date('Y')."  and fecha_inicio <= now() and now() < fecha) b 
					left join
					(select * from inscripcion_examen where idcarrera = $idcarrera and idmateria = ".$arreglo_estado_academico[$i][0]." and idalumno = $idalumno and anio_lectivo = ".date('Y').") a
					on a.fecha_inscripcion = b.fecha
					where fecha_inscripcion is null");
		if($puedeborrarse and dbCount($tienemesas)>0) $puedeborrarse = 0;
		array_push($arreglo_borrar,$puedeborrarse);
	}
}

$hay_fechas = dbConsultar($base,"select to_char(fecha, 'DD/MM/YYYY') as fecha,* from fecha_mesa_examenes a 
							where anio_lectivo = ".date('Y')."  and fecha_inicio <= now() and now() < fecha 
							order by a.fecha desc");
if(sizeof($arreglo_materias)>0){
if(dbCount($hay_fechas)>0){
	echo '<br><table><tr><td><b>Inscripciones en mesas de examenes: </b></td></tr> </table> <table class="tabla" border="0" style="width:750px;">
	<tr> <th align="center">Todas<br><input type="checkbox" onclick="marcar(this);" /></th><th align=left>Materia</th><th align=center>Fecha examen</th><th align=center>Opciones</th></tr>';

	for($i=0;$i<sizeof($arreglo_materias);$i++){
		//if ($arreglo_borrar[$i]!=1){
			echo '<tr><td align="center">';
			if ($arreglo_borrar[$i]!=1) echo '<input type="checkbox" name="chkmaterias" value="'.$arreglo_materias[$i].'" />';
			echo '</td><td>'.$arreglo_nombres[$i].'<strong>   ('.$arreglo_anio_insc[$i].' a&ntilde;o </strong>)';
			if ($arreglo_borrar[$i]==1){	
				$fecha_inscripcion = dbConsultar($base,"select to_char(fecha_inscripcion, 'DD/MM/YYYY') as fecha,* from inscripcion_examen a where idmateria = ".$arreglo_materias[$i]." and idcarrera = ".$idcarrera." and idalumno = ".$idalumno ." order by fecha_inscripcion desc");
				$fila_fecha_inscripcion = dbfila($fecha_inscripcion);
				echo '
				<td align=center>'.$fila_fecha_inscripcion[0].'</td>
				<td align=center>
					<table width=100%><tr>';
				//verifica si la fecha ya paso para ver si esta a tiempo de borrarse de la mesa
				$fecha_paso = dbConsultar($base,"select * from fecha_mesa_examenes where fecha = '".$fila_fecha_inscripcion[0]."' and now() < fecha");
				//verificar si ya tiene la nota para esa materia
				$ya_rindio = dbConsultar($base,"select * from notas a, inscripcion_examen b where id_inscripcion = id_inscripcion_examen and fecha = '".$fila_fecha_inscripcion[0]."' and idmateria = ".$arreglo_materias[$i]." and idalumno = $idalumno");

				if(dbCount($fecha_paso) != 0 and dbCount($ya_rindio) == 0) echo '<td align=center><a href="#" class = "btn" onclick = "quitar('.$arreglo_materias[$i].','.$idcarrera.','.$idalumno.',\''.$fila_fecha_inscripcion[0].'\')">Quitar Inscripción</a></td>';
				echo '<td align=center><a href="#" class = "btn" onclick = "constancia_examen('.$arreglo_materias[$i].','.$idcarrera.','.$idalumno.',\''.$fila_fecha_inscripcion[0].'\')">Constancia</a></td>';
				echo '</tr></table>
				</td>';
			}
			else{ 
				$fechas = dbConsultar($base,"select to_char(fecha, 'DD/MM/YYYY') as fecha,* from fecha_mesa_examenes a 
									where anio_lectivo = ".date('Y')."  and fecha_inicio <= now() and now() < fecha 
									order by a.fecha desc");

				echo '<td align=center>';
				echo '<select mame="fechas">';
			                    while($fila = dbfila($fechas)){
			                        echo '<option value="'.$fila[2].'">'.$fila[0].'</option>';
			                    }
			        echo '</select>';
				echo '</td><td></td>';
			}
			echo '</td></tr>';
		//}
	}
	echo '</table><br>
	<center><a href="#" onclick="validar_datos()" class="btn" width=100%>Inscribir</a>';
}
else echo '<br>'.nota($color,'No hay fecha de examen disponible');
}
else echo '<br>'.nota($color,'El alumno no se puede inscribir en ninguna materia');

echo '</center>';
?>
