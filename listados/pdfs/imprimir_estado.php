<?php
require_once ('../../dompdf/dompdf_config.inc.php');
require ('../../funciones/bd_print.php'); 
require('../../funciones/funciones.php');
$idcarrera = $_GET['carrera'];
$idalumno = $_GET['idalumno'];

$base = dbConectar(); 

$datos_alumno = dbConsultar($base,"select dni,apellido,nombre from alumno a, personas b where a.idpersona = b.idpersona and idalumno = $idalumno");
$fila_datos_alumno = pg_fetch_row($datos_alumno);
$dni = $fila_datos_alumno[0];

$listado_alumnos = dbConsultar($base,"select * from 
(select idmateria,anio,materia from v_materiasxcarrera where idcarrera = $idcarrera order by idmateria) a
left join
(select *,'Exa' as estado_exa from v_notas where idalumno = $idalumno and idcarrera = $idcarrera and estado = 'Exa') b on a.idmateria = b.idmateria
left join
(select *,'Pro' as estado_pro from v_notas where idalumno = $idalumno and idcarrera = $idcarrera and estado = 'Pro') c on a.idmateria = c.idmateria
left join
(select *,'Reg' as estado_reg,fecha_fin as fecha_reg from v_notas where idalumno = $idalumno and idcarrera = $idcarrera and estado = 'Reg') d on a.idmateria = d.idmateria
left join
(select id_inscripcion_cursado,idalumno,idcarrera,idmateria,anio_lectivo,fecha_inscripcion,'Cur' as estado_cur, foperacion,usuario,comision,observaciones,fecha_inscripcion as fecha_ins
from inscripcion_cursado where idalumno = $idalumno and idcarrera = $idcarrera and fecha_inscripcion < now() and now()< (fecha_inscripcion + CAST('1 year' AS INTERVAL))) e on a.idmateria = e.idmateria");
 
//$fila_listado_alumnos = pg_fetch_row($listado_alumnos);
$datos_alumno = dbConsultar($base,"select apellido,nombre,dni from personas a,alumno b
							where a.idpersona=b.idpersona and b.idalumno=$idalumno");
$fila_alumno = pg_fetch_row($datos_alumno);

$datos_carrera = dbConsultar($base,"select carrera,materia,anio from v_materiasxcarrera where idcarrera = $idcarrera");
$fila_datos_carrera = pg_fetch_row($datos_carrera);
$radio = '5px';
$titulo_listado ='ESTADO ACADEMICO <br>';
$membrete ='--------------------------Quien suscribe, de la ESCUELA NORMAL SUPERIOR EN LENGUAS VIVAS  "JUAN BAUTISTA ALBERDI" hace constar que '.$fila_alumno[0].' DNI N° '.$fila_alumno[2].' es alumno/a de este Establecimiento en el '.$fila_datos_carrera[0].'. Resol N°XXXXXXX siendo su situaci&oacute;n siguiente
';
$titulos = $membrete.'<br>';
	 
$html.= '<table class=tabla border=0>
		<tr>
			<th align=center>ID</th>
			<th align=center>AÑO</th>
			<th>MATERIA</th>
			<th align=center>ESTADO</th>
			<th align=center>NOTA</th>
			<th align=center>FECHA</th>
			<th align=center>LIB-FOL</th>						
		</tr>';
$i=1;
$pagina = 2;
$anio = 2;

$html.= '<tr style="background-color:rgb(240,240,240);">
			<td align=center>-</td>
			<td align=center>1</td>
			<td>1° Año</td>
			<td align=center>-</td>
			<td align=center>-</td>
			<td align=center>-</td>
			<td align=center>-</td>
		</tr>';

while($fila_estado = pg_fetch_row($listado_alumnos)){
	if($i==28){
		$html.= '</table>
		<br>
		El listado esta sujeto a modificaciones futuras.
		<div style="border:1px solid black; text-align:center; margin-top:3px; border-radius: 0px 0px '.$radio.' '.$radio.';">
			 <b>'.strtoupper($titulo_listado).'</b> 
		</div>
	</div>
		<div style="page-break-after: always;"></div>
		<div style="border:1px solid black; padding:2px; border-radius: '.$radio.' '.$radio.' '.$radio.' '.$radio.';">
	<table border=0 style="border:1px solid black; border-radius:'.$radio.' '.$radio.' 0px 0px;" width=100%>
		<tr>
			<td rowspan=2 style="padding:5px; width:100px;"><img src="monograma2.jpg" width=100/></td>
			<td rowspan=2>Esc. Normal Superior en Lenguas Vivas<br>Juan Bautista Alberdi<br>Muñecas 219 - San Miguel de Tucumán</td>
			<td valign=top align=right>Pagina '.$pagina.'</td>
		</tr>
		<tr>
			<td align=right valign=bottom><b>Fecha de emisión </b>'.date('d/m/Y').'</td>
		</tr>

	</table>
	
	<div style="border:1px solid black; text-align:center; margin-top:3px;">
	<b>'.strtoupper($titulo_listado).'</b>
	</div>'.'
		<table class=tabla border=0>
		<tr>
			<th align=center>ID</th>
			<th align=center>AÑO</th>
			<th>MATERIA</th>
			<th align=center>ESTADO</th>
			<th align=center>NOTA</th>
			<th align=center>FECHA</th>
			<th align=center>LIB-FOL</th>						
		</tr>';
	}

	if($anio == $fila_estado[dbcampo($listado_alumnos,'anio')]){
		$html.= '<tr style="background-color:rgb(240,240,240);">
			<td align=center>-</td>
			<td align=center>'.$fila_estado[dbcampo($listado_alumnos,'anio')].'</td>
			<td>'.$fila_estado[dbcampo($listado_alumnos,'anio')].'° Año</td>
			<td align=center>-</td>
			<td align=center>-</td>
			<td align=center>-</td>
			<td align=center>-</td>
		</tr>';
		$anio++;
	}
	else{
		$html.='		
			<tr>
				<td align=center>'.$fila_estado[dbcampo($listado_alumnos,'idmateria')].'</td>
				<td align=center>'.$fila_estado[dbcampo($listado_alumnos,'anio')].'</td>
				<td><div style=font-size:10px; font-family:Arial, Helvetica, sans-serif; color:black; line-height:25px;">'.$fila_estado[dbcampo($listado_alumnos,'materia')].'</div></td>';

			if($fila_estado[dbcampo($listado_alumnos,'estado_exa')]=="Exa"){
				if($fila_estado[dbcampo($listado_alumnos,'estado_pro')]=="Pro"){
					$html.= '<td align=center>Pro</td><td align=center>'.$fila_estado[dbcampo($listado_alumnos,'notac')].'</td><td align=center>'.convertir_fecha($fila_estado[dbcampo($listado_alumnos,'fecha')]).'</td><td align=center>'.$fila_estado[dbcampo($listado_alumnos,'libro')].'</td>';
				}
				else $html.= '<td align=center>Exa</td><td align=center>'.$fila_estado[dbcampo($listado_alumnos,'notac')].'</td><td align=center>'.convertir_fecha($fila_estado[dbcampo($listado_alumnos,'fecha')]).'</td><td align=center>'.$fila_estado[dbcampo($listado_alumnos,'libro')].'</td>';
			}
			else if($fila_estado[dbcampo($listado_alumnos,'estado_reg')]=="Reg")	$html.= '<td align=center>Reg</td><td align=center> Debe Rendir Exam. Final </td><td align=center>'.convertir_fecha($fila_estado[dbcampo($listado_alumnos,'fecha_reg')]).'</td><td align=center>'.$fila_estado[dbcampo($listado_alumnos,'libro')].'</td>';
				 else if($fila_estado[dbcampo($listado_alumnos,'estado_cur')]=="Cur") $html.= '<td align=center>Cur</td><td align=center> Debe Regularizar </td><td align=center></td><td align=center>'.$fila_estado[dbcampo($listado_alumnos,'libro')].'</td>';
					  else $html.= '<td align=center></td><td align=center>Falta Cursar</td><td align=center></td><td align=center></td>';
			$html.= '</tr>';
		$i++;
	}
}
$html.='</table>';

include('cuerpo.php');

$filename = 'estado_academico.pdf';
$pdf = new DOMPDF();
$pdf->set_paper("A4", "portrait");
$pdf->load_html($cuerpo);
$pdf->render();
$pdf->stream($filename,array('Attachment'=>0));

?>