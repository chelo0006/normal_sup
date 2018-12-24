<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$idalumno = $_POST['idalumno'];
$base = dbConectar();

if ($idalumno!=''){
	$carreras = dbConsultar($base,"select distinct(carrera) as carrera, a.idcarrera from  inscripcion_carrera a 
									join carreras b on a.idcarrera = b.idcarrera
									where idalumno = $idalumno");
	
	$html.='*Carreras en las que se puede reinscribir el/la alumno/a<br><div style="width:50%;"><table class="tabla">';
	$html.='<tr><th align=left>Carreras en que esta inscripto/a</th><th>Ultima inscripcion</th><th>Opciones</th></tr>';
	while($fila = pg_fetch_row($carreras)){
		$ultima_inscripcion = dbConsultar($base,"select max(ciclo_lectivo) from  inscripcion_carrera a 
										where idalumno = $idalumno and idcarrera = ".$fila[1]."
										group by ciclo_lectivo");
		$ultima = pg_fetch_row($ultima_inscripcion);
		$html.='<tr onclick="inscripcion('.$idalumno.','.$fila[1].','.$ultima[0].')"><td>'.$fila[0].'</td><td align=center>'.$ultima[0].'</td><td><a href="#" onclick="constancia()" class="btn">Constancia</a></td></tr>';
	}
	$html.='</table></div>';
}
else{
	$carreras = dbConsultar($base,"select idcarrera,carrera from carreras where carrera is not null and idcarrera not in (6,18,27,31) and idcarrera in (22,23,26,30,32) order by carrera");
	echo '<div class="nota">
	Por favor complete los datos solicitados del/la alumno/a, seleccione una carrera y presione inscribir.
	</div><br>	
	*Carrera en la que se va a aincribir al alumno/a
	<b>Carrera</b>
	<table border=0>
		<tr><td>Nivel: </td><td><select id="nivel">
									<option value"4" selected>Terciario</option>
								   </select></td>
		</tr>
		<tr><td>Inscribir en: </td><td ><select id="carrera" style="width:100%;">
									<option value"0">Seleccionar</option>';
									while($fila = pg_fetch_row($carreras)){
										$html.='<option value="'.$fila[0].'">'.$fila[1].'</option>';
									}
									$html.='</select></td>
		</tr>
	</table><br><hr><center><a href="#" onclick="validar()" class="btn">Inscribir</a> </center>';

}
echo $html.'<iframe onload="document.getElementById(\'cargando\').innerHTML=\'\'" style="display:none;">';
//if (pg_num_rows($carreras)>0)
?>
