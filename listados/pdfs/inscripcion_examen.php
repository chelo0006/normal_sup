<?php
require_once ('../../dompdf/dompdf_config.inc.php');
require ('../../funciones/bd_print.php');

$idalumno = $_GET['idalumno'];
$idcarrera = $_GET['idcarrera'];
$idmateria = $_GET['idmateria']; 
$fecha_examen = $_GET['fecha'];

$base = dbConectar();
$verificacion = dbConsultar($base,"select * from inscripcion_cursado a,alumno b where a.idalumno = b.idalumno and idcarrera = $idcarrera and b.idalumno = $idalumno");
$verif = pg_fetch_row($verificacion);

$materia = dbConsultar($base,"select materia,anio from v_materiasxcarrera where idmateria = $idmateria");
$fila_materia = pg_fetch_row($materia);

if($verif[1]==$idalumno){
	$datos_personales = dbConsultar($base,"select * from personas a, alumno b where b.idpersona = a.idpersona and idalumno = $idalumno");
	$datos = pg_fetch_row($datos_personales);

	$carrera = dbConsultar($base,"select * from carreras where idcarrera = $idcarrera");
	$datos_carrera = pg_fetch_row($carrera);

	$inscripcion_cursado = dbConsultar($base,"select min(foperacion) from inscripcion_cursado where idalumno = $idalumno and idcarrera = $idcarrera");
	$datos_inscripcion= pg_fetch_row($inscripcion_cursado);

	$provincia = dbConsultar($base,"select * from provincias where idprovincia = $datos[9]");
	$prov= pg_fetch_row($provincia);

	$departamento = dbConsultar($base,"select nombre from departamentos where depto = '$datos[16]'");
	$depto= pg_fetch_row($departamento);

	$localidad = dbConsultar($base,"select nombre from localidades where idlocalidad = '$datos[8]'");
	$local= pg_fetch_row($localidad);

	$x = explode(' ',$datos_inscripcion[0]);
	$xx = explode('-',$x[0]);
	$fecha = $xx[2].'/'.$xx[1].'/'.$xx[0];
	$x = explode(' ',$datos[13]);
	$xx = explode('-',$x[0]);
	$fecha_nac = $xx[2].'/'.$xx[1].'/'.$xx[0];

	switch ($datos[18]){
		case 1:	$tipo_doc = 'DNI'; break;
		case 2:	$tipo_doc = 'LE'; break;
		case 3:	$tipo_doc = 'LC'; break;
		case 4:	$tipo_doc = 'PAS'; break;
		case 5:	$tipo_doc = 'CF'; break;
		case 6:	$tipo_doc = 'CPT'; break;
	}
	switch ($datos[12]){
		case 1:	$sexo = 'Masculino'; break;
		case 2:	$sexo = 'Femenino'; break;
		default: $sexo = '-'; break;
	}
	switch ($datos[15]){
		case 1:	$nacionalidad = 'Argentin'; if($datos[12]==1) $nacionalidad.='o'; else $nacionalidad.='a'; break;
		default: $nacionalidad = '-'; break;
	}
	$radio = '5px';
	$html.= '
	<div style="border:1px solid black; padding:2px; border-radius: '.$radio.' '.$radio.' '.$radio.' '.$radio.';">
	<table border=0 style="border:1px solid black; border-radius:'.$radio.' '.$radio.' 0px 0px;" width=100%>
		<tr>
			<td style="padding:5px; width:100px;"><img src="monograma2.jpg" width=100/></td>
			<td>Esc. Normal Superior en Lenguas Vivas<br>Juan Bautista Alberdi<br>Muñecas 219 - San Miguel de Tucumán</td>
			<td valign=bottom align=right><b>Fecha de emisión </b>'.date('d/m/Y').'</td>
		</tr>
	</table>
	<div style="border:1px solid black; text-align:center; margin-top:3px;">
	<b>CONSTANCIA DE INSCRIPCIÓN A EXAMEN</b>
	</div>
	<br>
	Por medio de la presente queda constancia de que el alumno <b>'.$datos[0].', '.$datos[1].'</b> se inscribio en la mesa de examen de la fecha <b>'.$fecha_examen.'</b> Los detalles de la inscripción se describen a continuación.
	<br><br>
	<style>
	*{
		font-size: 12px;
	}
	.detalle td{
		border:1px solid rgb(200,200,200);
	}
	</style>
	Datos declarados al momento de la inscripción.
	<table class="detalle" border=1 width=100% style="border:1px;" cellspacing=2>
		<tr><th colspan=6 style="background-color:rgb(200,200,200);">Datos del alumno</th></tr>
		<tr>
			<td style=""><b>Nombre: </b></td><td style="">'.$datos[0].', '.$datos[1].'</td>
			<td style=""><b>Tipo de Doc.:</b></td><td style="">'.$tipo_doc.'</td>
			<td style=""><b>Nro:</b></td><td style="">'.$datos[2].'</td>
		</tr>
		<tr>
			<td><b>Sexo:<b> </td><td>'.$sexo.'</td><td><b>Fecha de Nac.:</b></td><td>'.$fecha_nac.'</td><td><b>Correo</b></td><td>'.$datos[17].'</td>
		</tr>
		<tr>
			<td><b>Telefono:<b> </td><td></td><td><b></b></td><td></td><td></td><td></td>
		</tr>
	</table>
	<br>
	Datos declarados al momento de la inscripción.
	<table class="detalle" border=1 width=100% style="border:1px;" cellspacing=2>
		<tr><th colspan=4 style="background-color:rgb(200,200,200);">Mesa examen</th></tr>
		<tr>
			<td><b>Carrera:<b></td><td>'.$datos_carrera[2].'</td><td><b>Materia</b></td><td>'.$fila_materia[0].'</td>
		</tr>
		<tr>
			<td><b>Mesa de examen:<b></td><td>'.$fecha_examen.'</td><td><b>Año:</b></td><td>'.$fila_materia[1].'°</td>
		</tr>
	</table>
	<br><br>
	Conserve esta constancia como documento válido para realizar consultas futuras.
	<div style="border:1px solid black; text-align:center; margin-top:3px; border-radius: 0px 0px '.$radio.' '.$radio.';">
	<b>CONSTANCIA DE INSCRIPCIÓN A EXAMEN</b>
	</div>
	</div>
	<div style="width:100%; height:45px; border-bottom: 1 px dotted black;"></div>
	';
	 
	$filename = 'constancia_inscripcion.pdf';
	$pdf = new DOMPDF();
	$pdf->set_paper("A4", "portrait");
	$pdf->load_html($html);
	$pdf->render();
	$pdf->stream($filename,array('Attachment'=>0));
}
else echo 'ERROR';

?>