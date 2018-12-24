<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$idalumno = $_POST['idalumno'];
$idcarrera = $_POST['idcarrera'];

$idmateria = $_POST['materia'];

$base = dbConectar();

$materiasxcarrera = dbConsultar($base,"select distinct anio from v_materiasxcarrera where idmateria = $idmateria");
$anio = pg_fetch_row($materiasxcarrera);

$comisiones = dbConsultar($base,"select a.idcarrera,a.idcomision,a.anio,a.comision,a.anio_lectivo,a.cupo,coalesce(y.quedan,0) as quedan,coalesce(y.inscriptos,0) as inscriptos from comisiones a left join (
select (x.cupo-x.inscriptos) as quedan,* from (
select count(distinct a.idalumno) as inscriptos,a.idcarrera,b.idcomision,b.anio,b.comision,b.cupo,b.anio_lectivo from inscripcion_cursado a,comisiones b
where a.comision=b.idcomision
group by a.idcarrera,b.idcomision,b.anio,b.comision,b.cupo,b.anio_lectivo) x) y
on a.idcomision=y.idcomision where a.idcarrera=$idcarrera and a.anio=".$anio[0]." order by a.anio,a.comision ");

		$html = '<tr><td align="center">';
		$html.= '<select id="comisiones_excepcion">';
		$hay_lugar = 0;
		while($comisiones_fila = pg_fetch_row($comisiones)){
			if($comisiones_fila[5] > $comisiones_fila[6]){
				$html.= '<option value="'.$comisiones_fila[1].'">Comisión '.$comisiones_fila[3].' <span>(disp:'.($comisiones_fila[5]-$comisiones_fila[7]).')</span></option>';
				$hay_lugar=1;
			}
		}
		$html.= '</select>';
		$html.= '</td>

			</tr>';

echo $html;
?>