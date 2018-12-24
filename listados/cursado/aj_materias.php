<?php
session_start();
include('sesion.php');
include('variables.php');
//include('../../cerrar_sesion.php');
$prof='../../';

include($prof.'funciones/bd.php');

$idcarrera=$_POST['carrera'];
$idalumno=$_POST['idalumno'];



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

$materiasxcarrera = dbConsultar($base,"select * from v_materiasxcarrera where idcarrera = $idcarrera and anio>1");

while($materias = pg_fetch_row($materiasxcarrera)){
	$yacursa = dbConsultar($base,"select * from inscripcion_cursado a, notas b where idalumno = $idalumno and 
									id_inscripcion_cursado = id_inscripcion and anio_lectivo = 2018 and nota is not null and idmateria=".$materias[2]);
	$sarasa = pg_fetch_row($yacursa);
	if($sarasa[0]==''){
		$noregular = 1;
		$correlatividades = dbConsultar($base,"select * from correlatividades where idcarrera = $idcarrera and anio>1 and idmateria = ".$materias[2]);
		while($correl = pg_fetch_row($correlatividades)){	
			$regular = dbConsultar($base,"select idmateria,b.nota from inscripcion_cursado a, notas b where a.id_inscripcion_cursado = b.id_inscripcion and idcarrera = $idcarrera and idmateria in 
											(select idregular from correlatividades where idcarrera = $idcarrera and anio>1 and idmateria = ".$materias[2].") and idalumno = $idalumno");
			$regular = pg_fetch_row($regular);
			if($regular[1] <= 4){
				$noregular = 0;
				break;
			}
		}
		if($noregular==1){
			array_push($arreglo_carreras_insc,$materias[2]);
			array_push($arreglo_materias_insc,$materias[5]);
			array_push($arreglo_anio_insc,$materias[3]);
		}
	}
}
$edi = dbConsultar($base,"select distinct idmateria,anio,idcarrera,materias from correlatividades where regular is null and idcarrera = $idcarrera and anio > 1 order by anio");

while($edis = pg_fetch_row($edi)){	
	$noregular = 1;
	$regular = dbConsultar($base,"select idmateria,b.nota from inscripcion_cursado a, notas b where a.id_inscripcion_cursado = b.id_inscripcion and idcarrera = $idcarrera and idmateria in 
									(select idmateria from correlatividades where idcarrera = $idcarrera and anio>1 and idmateria = ".$edis[0].") and idalumno = $idalumno");
	
	$regular2 = pg_fetch_row($regular);
	
	if($regular2[1] >= 4 and $regular2[1]!=''){
		$noregular = 0;
	}
	if($noregular==1){
		array_push($arreglo_carreras_insc,$edis[0]);
		array_push($arreglo_materias_insc,$edis[3]);
		array_push($arreglo_anio_insc,$edis[1]);
	}
}
echo '<div class="nota">
	Si no visualiza materias para inscribir, verifique si fueron cargadas las notas para el alumno seleccionado!!!!.
	</div><br>	';
echo '<table><tr><td>Materias que se puede inscribir: </td></tr> </table> <table class="tabla" border="0" style="margin: 19 auto;">
<tr> <th align="center">Todas<br><input type="checkbox" onclick="marcar(this);" /></th><th align=left>Materia</th><th>Comisión</th></tr>';
for($i=0;$i<sizeof($arreglo_carreras_insc);$i++){
	echo '<tr><td align="center"><input type="checkbox" name="chkmaterias" value="'.$arreglo_carreras_insc[$i].'" /></td><td>'.$arreglo_materias_insc[$i].'<strong>   ('.$arreglo_anio_insc[$i].' a&ntilde;o </strong>)</td>

	<td align="center">
	<select id="com_'.$i.'">
		<option value="1">Comisión 1</option>
		<option value="2">Comisión 2</option>
	</select>
	</td>
	</tr>';
}
echo '</table>
<center><a href="#" onclick="validar_datos()" class="btn" width=100%>Inscribir</a> </center>';
?>
