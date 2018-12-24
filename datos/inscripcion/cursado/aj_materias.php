<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$idcarrera=$_POST['carrera'];
$idalumno=$_POST['idalumno'];
$anio_lectivo=$_POST['anio_lectivo'];

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

//todas las materias de la carrera desde 2do año
$materiasxcarrera = dbConsultar($base,"select * from v_materiasxcarrera where idcarrera = $idcarrera and anio > 1 order by anio,idmateria");
$dni_clt = dbConsultar($base,"select dni from alumno a,personas b where a.idpersona = b.idpersona and idalumno = $idalumno");
$fila_dni = pg_fetch_row($dni_clt);
$dni = $fila_dni[0];
while($materias = pg_fetch_row($materiasxcarrera)){
	$correlativas = dbConsultar($base,"select a.*, est,estadocur,case notac when -1 then ''::text else notac::text end as notac,c.finscripcion,e.finscripcion as exa,notae from 
								(select idmateria,anio,materia from v_materiasxcarrera where idcarrera = $idcarrera order by anio,idmateria) a left join
								(select * from (select a.idmateria as idmat,b.estado as est,b.nota as notac,* from v_inscripcion_cursado a,notas b
								where a.id_inscripcion_cursado=b.id_inscripcion) x
								left join (select a.idmateria as idmate,b.estado as este,b.nota as notae,* from v_inscripcion_examen a,notas b
								where a.id_inscripcion_examen=b.id_inscripcion) y
								on x.dni=y.dni and x.idcarrera=y.idcarrera
								where x.dni=$dni) b on a.idmateria = b.idmat
								left join (select x.idmateria,x.finscripcion, case Cur when 1 then 'Cur'::text end as estadocur
								from (select idmateria,finscripcion,1 as Cur from v_inscripcion_cursado where dni = $dni) x) c on c.idmateria = a.idmateria
								left join (select x.idmateria,x.finscripcion,case Exa when 1 then 'Exa'::text end as estadoexa
								from (select idmateria,finscripcion,1 as Exa from v_inscripcion_examen where dni = $dni) x) e on e.idmateria = a.idmateria
								join
								(select idregular from correlatividades where idcarrera = $idcarrera and anio > 1  and idmateria = ".$materias[2]." order by anio,idmateria) as d on a.idmateria = d.idregular");
	$se_puede_inscribir = 1;
	while($fila_correlativas = pg_fetch_row($correlativas)){
		if($fila_correlativas[3] != 'Reg' and $fila_correlativas[3] != 'Pro') $se_puede_inscribir = 0;
	}
	if($se_puede_inscribir==1){
		//ver si ya esta cursando
		$ya_cursa = dbConsultar($base,"select * from inscripcion_cursado where idmateria = ".$materias[2]." and idalumno = $idalumno and idcarrera = $idcarrera and anio_lectivo = $anio_lectivo");
		if(pg_num_rows($ya_cursa)==0){
			array_push($arreglo_carreras_insc,$materias[2]);
			array_push($arreglo_materias_insc,$materias[5]);
			array_push($arreglo_anio_insc,$materias[3]);
		}	
	}
}

echo nota($color,'Si no visualiza materias para inscribir, verifique si fueron cargadas las notas para el alumno seleccionado!!!!.').'<br>';

if(sizeof($arreglo_carreras_insc)==0) echo '<b>No puede inscribirse en ninguna materia de la carrera seleccionada</b>';
else{
	echo '<table><tr><td>Materias que se puede inscribir: </td></tr> </table> <table class="tabla" border="0" style="margin: 19 auto;">
	<tr> <th align="center">Todas<br><input type="checkbox" onclick="marcar(this);" /></th><th align=left>Materia</th><th>Comisión</th></tr>';
	for($i=0;$i<sizeof($arreglo_carreras_insc);$i++){
		echo '<tr><td align="center"><input type="checkbox" name="chkmaterias" value="'.$arreglo_carreras_insc[$i].'" /></td><td>'.$arreglo_materias_insc[$i].'<strong>   ('.$arreglo_anio_insc[$i].' a&ntilde;o </strong>)</td>';
		$comisiones = dbConsultar($base,"select idcomision,idcarrera,anio,a.comision,foperacion,usuario,coalesce(alumnos,0)::numeric as alumnos,cupo from 
										(select * from comisiones where idcarrera=$idcarrera and anio=".$arreglo_anio_insc[$i]." order by comision asc) a left join 
										(select comision,count(id_inscripcion_cursado) as alumnos from inscripcion_cursado 
										where idcarrera = $idcarrera and idmateria = ".$arreglo_carreras_insc[$i]." and anio_lectivo = ".$anio_lectivo." group by idmateria,comision order by comision) b 
										on idcomision = b.comision");

		echo '<td align="center">';
		echo '<select name="comisiones">';
		$hay_lugar = 0;
		while($comisiones_fila = pg_fetch_row($comisiones)){
			if($comisiones_fila[6] < $comisiones_fila[7]){
				echo '<option value="'.$comisiones_fila[0].'">Comisión '.$comisiones_fila[3].' <span>(disp:'.($comisiones_fila[7]-$comisiones_fila[6]).')</span></option>';
				$hay_lugar=1;
			}
		}
		echo '</select>';
		echo '</td>
		</tr>';
	}
	echo '</table>
	<center><a href="#" onclick="validar_datos()" class="btn" width=100%>Inscribir</a> ';
if ($_SESSION['perfil']=='1' or $_SESSION['perfil']=='2')
{
echo   '   <a href="#" onclick="excepcion('.$idalumno.','.$idcarrera.')" class="btn" width=100%>Excepción</a>';
};	
	
	
	echo '</center>';
}

?>