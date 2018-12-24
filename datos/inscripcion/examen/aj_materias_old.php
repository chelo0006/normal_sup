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

$arreglo_carreras_insc = array();
$arreglo_materias_insc = array();
$arreglo_anio_insc = array(); 
$arreglo_borrar = array();

$materiasxcarrera = dbConsultar($base,"select * from v_materiasxcarrera where idcarrera = $idcarrera order by anio,idmateria");

while($materias = dbfila($materiasxcarrera)){
	$correlativas = dbConsultar($base,"select * from correlatividades where idcarrera = $idcarrera and idmateria =".$materias[2]);
	$regular = 1;
	$aprobada = 1;
	while($fila_correlativas = dbfila($correlativas)){
		$regulares = dbConsultar($base,"select * from inscripcion_cursado a, notas b where idcarrera = $idcarrera and idmateria = ".$fila_correlativas[4]." and idalumno = $idalumno and id_inscripcion_cursado = id_inscripcion and b.estado in ('Reg','Pro') and tipo = 'C'");
		if(dbfila($regulares)==""){
			$regulares2 = dbConsultar($base,"select * from inscripcion_cursado a, notas b where idcarrera = $idcarrera and idmateria = ".$fila_correlativas[2]." and idalumno = $idalumno and id_inscripcion_cursado = id_inscripcion and b.estado in ('Reg','Pro') and tipo = 'C'");
			if(dbfila($regulares2)=="") $regular = 0;
		}
		if($fila_correlativas[7]!=""){
			$aprobadas = dbConsultar($base,"select * from inscripcion_cursado a, notas b where idcarrera = $idcarrera and idmateria = ".$fila_correlativas[6]." and idalumno = $idalumno and id_inscripcion_cursado = id_inscripcion and b.estado = 'Apr' and tipo = 'E'");
			if(dbfila($aprobadas)==0){
				$aprobada = 0;
			}
		}
	}
	$yaaprobo = dbConsultar($base,"select * from (
				select idmateria,b.estado from inscripcion_cursado a, notas b where idcarrera = $idcarrera and idalumno = $idalumno and id_inscripcion_cursado = id_inscripcion and ((b.estado = 'Apr' and tipo = 'E') or (b.estado='Pro' and tipo = 'C'))
				union
				select idmateria,b.estado from inscripcion_examen a, notas b where idcarrera = $idcarrera and idalumno = $idalumno and id_inscripcion_examen = id_inscripcion and (b.estado = 'Exa' and tipo = 'E') and nota >= 4
				) x where idmateria = ".$materias[2]);
	
	$yainscrito = dbConsultar($base,"select * from inscripcion_examen where idcarrera = $idcarrera and idmateria = ".$materias[2]." and idalumno = $idalumno");

	$yarindio_mesa = dbConsultar($base,"select * from inscripcion_examen where idcarrera = $idcarrera and idmateria = ".$materias[2]." and idalumno = $idalumno and anio_lectivo = ".date('Y')." and now() < fecha_inscripcion");
	if(dbCount($yarindio_mesa)>0){
		$puede = 0;
	}
	else{
		$puede = 1;
		$puederendir = dbConsultar($base,"select fecha from
					(select * from fecha_mesa_examenes a where anio_lectivo = ".date('Y')."  and fecha_inicio <= now() and now() < fecha) b 
					left join
					(select * from inscripcion_examen where idcarrera = $idcarrera and idmateria = ".$materias[2]." and idalumno = $idalumno and anio_lectivo = ".date('Y').") a
					on a.fecha_inscripcion = b.fecha
					where fecha_inscripcion is null");

		if(dbCount($puederendir)>0) $puede = 1; else $puede=0;
	}
	if(dbCount($yainscrito)>0) $inscrito = 1; else $inscrito=0;

	if(dbCount($yaaprobo)>0) $aprobada = 0;

	if($regular and $aprobada){
		array_push($arreglo_carreras_insc,$materias[2]);
		array_push($arreglo_materias_insc,$materias[5]);
		array_push($arreglo_anio_insc,$materias[3]);
        if($puede==0) array_push($arreglo_borrar,$inscrito);
        else array_push($arreglo_borrar,0);
	}
}

$hay_fechas = dbConsultar($base,"select to_char(fecha, 'DD/MM/YYYY') as fecha,* from fecha_mesa_examenes a 
							where anio_lectivo = ".date('Y')."  and fecha_inicio <= now() and now() < fecha 
							order by a.fecha desc");
if(sizeof($arreglo_carreras_insc)!=0){
if(dbCount($hay_fechas)>0){
	echo '<br><table><tr><td><b>Inscripciones en mesas de examenes: </b></td></tr> </table> <table class="tabla" border="0" style="width:750px;">
	<tr> <th align="center">Todas<br><input type="checkbox" onclick="marcar(this);" /></th><th align=left>Materia</th><th align=center>Fecha examen</th><th align=center>Opciones</th></tr>';

	for($i=0;$i<sizeof($arreglo_carreras_insc);$i++){
		echo '<tr><td align="center">';
		if ($arreglo_borrar[$i]!=1) echo '<input type="checkbox" name="chkmaterias" value="'.$arreglo_carreras_insc[$i].'" />';
		echo '</td><td>'.$arreglo_materias_insc[$i].'<strong>   ('.$arreglo_anio_insc[$i].' a&ntilde;o </strong>)';
		if ($arreglo_borrar[$i]==1){	
			$fecha_inscripcion = dbConsultar($base,"select to_char(fecha_inscripcion, 'DD/MM/YYYY') as fecha,* from inscripcion_examen a where idmateria = ".$arreglo_carreras_insc[$i]." and idcarrera = ".$idcarrera." and idalumno = ".$idalumno ." order by fecha_inscripcion desc");
			$fila_fecha_inscripcion = dbfila($fecha_inscripcion);
			echo '
			<td align=center>'.$fila_fecha_inscripcion[0].'</td>
			<td align=center>
				<table width=100%><tr>';
			//verifica si la fecha ya paso para ver si esta a tiempo de borrarse de la mesa
			$fecha_paso = dbConsultar($base,"select * from fecha_mesa_examenes where fecha = '".$fila_fecha_inscripcion[0]."' and now() < fecha");
			//verificar si ya tiene la nota para esa materia
			$ya_rindio = dbConsultar($base,"select * from notas a, inscripcion_examen b where id_inscripcion = id_inscripcion_examen and fecha = '".$fila_fecha_inscripcion[0]."' and idmateria = ".$arreglo_carreras_insc[$i]." and idalumno = $idalumno");

			if(dbCount($fecha_paso) != 0 and dbCount($ya_rindio) == 0) echo '<td align=center><a href="#" class = "btn" onclick = "quitar('.$arreglo_carreras_insc[$i].','.$idcarrera.','.$idalumno.',\''.$fila_fecha_inscripcion[0].'\')">Quitar Inscripción</a></td>';
					echo '<td align=center><a href="#" class = "btn" onclick = "constancia_examen('.$arreglo_carreras_insc[$i].','.$idcarrera.','.$idalumno.',\''.$fila_fecha_inscripcion[0].'\')">Constancia</a></td>';
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
	}
	echo '</table><br>
	<center><a href="#" onclick="validar_datos()" class="btn" width=100%>Inscribir</a>';
}
else echo '<br>'.nota($color,'No hay fecha de examen disponible');
}
else echo '<br>'.nota($color,'El alumno no se puede inscribir en ninguna materia');

echo '</center>';
?>
