<?php
session_start();
include('sesion.php');
include($prof.'listados/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

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

$mat = 0;
$exa = 0;
$apr = 0;
$prom = 0;

$cadena ="select * from 
(select idmateria,anio,materia from v_materiasxcarrera where idcarrera = $idcarrera order by idmateria) a
left join
(select *,'Exa' as estado_exa from v_notas where idalumno = $idalumno and idcarrera = $idcarrera and estado = 'Exa' and notac::numeric >= 4) b on a.idmateria = b.idmateria
left join
(select *,'Pro' as estado_pro,fecha_fin as fecha_fin_pro from v_notas where idalumno = $idalumno and idcarrera = $idcarrera and estado = 'Pro') c on a.idmateria = c.idmateria
left join
(select *,'Reg' as estado_reg,fecha_fin as fecha_reg from v_notas where idalumno = $idalumno and idcarrera = $idcarrera and estado = 'Reg') d on a.idmateria = d.idmateria
left join
(select id_inscripcion_cursado,idalumno,idcarrera,idmateria,anio_lectivo,fecha_inscripcion,'Cur' as estado_cur, foperacion,usuario,comision,observaciones,fecha_inscripcion as fecha_ins
from inscripcion_cursado where idalumno = $idalumno and idcarrera = $idcarrera and fecha_inscripcion < now() and now()< (fecha_inscripcion + CAST('1 year' AS INTERVAL))) e on a.idmateria = e.idmateria";

echo '<table class=tabla border=0>
		<tr>
			<th align=center>ID</th>
			<th align=center>AÑO</th>
			<th>MATERIA</th>
			<th align=center>ESTADO</th>
			<th align=center>NOTA</th>
			<th align=center>FECHA</th>
			<th align=center>LIB-FOL</th>						
		</tr>';
			
$estado = dbConsultar($base,$cadena);
$anio = 0;

echo '<tr style="background-color:rgba(0,0,0,.2);">
			<td align=center>-</td>
			<td align=center>1</td>
			<td>1° Año</td>
			<td align=center>-</td>
			<td align=center>-</td>
			<td align=center>-</td>
			<td align=center>-</td>
		</tr>';

$anio = 2;
while ($fila_estado = pg_fetch_row($estado)){
	if($anio == $fila_estado[1]){
		echo '<tr style="background-color:rgba(0,0,0,.2);">
			<td align=center>-</td>
			<td align=center>'.$fila_estado[1].'</td>
			<td>'.$fila_estado[1].'° Año</td>
			<td align=center>-</td>
			<td align=center>-</td>
			<td align=center>-</td>
			<td align=center>-</td>
		</tr>';
		$anio++;
	}
	else{
	 	echo '	
		<tr>
			<td align=center>'.$fila_estado[dbcampo($estado,'idmateria')].'</td>
			<td align=center>'.$fila_estado[dbcampo($estado,'anio')].'</td>
			<td><div style="max-width:400px; font-size:14px; font-family:Arial, Helvetica, sans-serif; color:black; line-height:25px;">'.$fila_estado[dbcampo($estado,'materia')].'</div></td>';

		if($fila_estado[dbcampo($estado,'estado_exa')]=="Exa"){
			if($fila_estado[dbcampo($estado,'estado_pro')]=="Pro"){
				echo '<td align=center>Pro</td><td align=center>'.$fila_estado[dbcampo($estado,'notac')].'</td><td align=center>'.convertir_fecha($fila_estado[dbcampo($estado,'fecha')]).'</td><td align=center>'.$fila_estado[dbcampo($estado,'libro')].'</td>';
			}
			else{
				if($fila_estado[dbcampo($estado,'notac')]>=4){
					echo '<td align=center>Exa</td><td align=center>'.$fila_estado[dbcampo($estado,'notac')].'</td><td align=center>'.convertir_fecha($fila_estado[dbcampo($estado,'fecha')]).'</td><td align=center>'.$fila_estado[dbcampo($estado,'libro')].'</td>';
				}
				else echo '<td align=center>Reg</td><td align=center> - </td><td align=center>'.convertir_fecha($fila_estado[dbcampo($estado,'fecha_reg')]).'</td><td align=center></td>';
				$exa++;
			}
			$apr++;
			$prom+= $fila_estado[dbcampo($estado,'notac')];
		}
		else if($fila_estado[dbcampo($estado,'estado_pro')]=="Pro") echo '<td align=center>Reg</td><td align=center> - </td><td align=center>'.convertir_fecha($fila_estado[dbcampo($estado,'fecha_fin_pro')]).'</td><td align=center>'.$fila_estado[dbcampo($estado,'libro')].'</td>';
			else if($fila_estado[dbcampo($estado,'estado_reg')]=="Reg")	echo '<td align=center>Reg</td><td align=center>Debe Rendir Exam. Final</td><td align=center>'.convertir_fecha($fila_estado[dbcampo($estado,'fecha_reg')]).'</td><td align=center>'.$fila_estado[dbcampo($estado,'libro')].'</td>';
			 else if($fila_estado[dbcampo($estado,'estado_cur')]=="Cur") echo '<td align=center>Cur</td><td align=center>Debe Regularizar </td><td align=center></td><td align=center>'.$fila_estado[dbcampo($estado,'libro')].'</td>';
				  else echo '<td align=center></td><td align=center>Debe Cursar y Rendir Exam. Final</td><td align=center></td><td align=center></td>';
		echo '</tr>';
		$mat++;
	}
}
echo "</table><br>";

$primera_inscripcion = dbConsultar($base,"select min(fecha_inscripcion) as fecha from inscripcion_cursado where idalumno = $idalumno and idcarrera = $idcarrera");
$fprimera = dbfila($primera_inscripcion);
$ultima_inscripcion = dbConsultar($base,"select max(fecha_inscripcion) as fecha from inscripcion_cursado where idalumno = $idalumno and idcarrera = $idcarrera");
$fila = dbfila($ultima_inscripcion);
$f = explode('-',$fila[0]);

$fecha1 = new datetime($fprimera[0]);
$fecha2 = new datetime(date('Y-m-d'));
$diferencia = $fecha1->diff($fecha2);

$anios = $diferencia->format('%y');

echo '
<table class="tabla">
	<tr>
		<th>Mat.</th>
		<th>Exa</th>
		<th>Apr</th>
		<th>Rep</th>
		<th>Promedio</th>
		<th>Años</th>
		<th>Ult. inscrip.</th>
		<th>Avance</th>
	</tr>
	<tr>
		<td align=center>'.$mat.'</td>
		<td align=center>'.$exa.'</td>
		<td align=center>'.$apr.'</td>
		<td align=center></td>
		<td align=center>'.($prom/$apr).'</td>
		<td align=center>'.$anios.'</td>
		<td align=center>'.$f[0].'</td>
		<td align=center>'.round((($apr*100)/$mat),2).'%</td>
	</tr>
</table>
';

echo '<br><center><a href="#" onclick="imprimir()" class="btn" width=100%>Imprimir</a> </center>';

?>
