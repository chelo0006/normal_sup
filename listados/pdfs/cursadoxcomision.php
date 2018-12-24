<?php
require_once ('../../dompdf/dompdf_config.inc.php');
require ('../../funciones/bd_print.php'); 

$idcarrera = $_GET['carrera'];
$anio = $_GET['anio'];
$idmateria = $_GET['materia'];
$comision = $_GET['comision'];
$anio_lectivo = $_GET['anio_lectivo'];

$base = dbConectar();

$listado_alumnos = dbConsultar($base,"select apellido,nombre,dni from inscripcion_cursado a, alumno b, personas c 
        where a.idalumno = b.idalumno and b.idpersona = c.idpersona and 
        comision = $comision and idmateria = $idmateria and idcarrera = $idcarrera and anio_lectivo = $anio_lectivo");

$datos_materia = dbConsultar($base,"select carrera,materia,anio from v_materiasxcarrera where anio = $anio and idcarrera = $idcarrera and idmateria = $idmateria");
$fila_datos_materia = pg_fetch_row($datos_materia);
$comision = dbConsultar($base,"select * from comisiones where idcomision = $comision");
$fila_comision = pg_fetch_row($comision);

$titulo_listado ='LISTADO DE ALUMNOS POR COMISIÓN';
$titulos = '
	 Carrera: '.$fila_datos_materia[0].'<br>
	 Materia: '.$fila_datos_materia[1].'<br>
	 Año: '.$fila_datos_materia[2].'°<br>
	 Comisión: '.$fila_comision[3];
	 
$html.='<table class="tabla">';
$html.='<tr>
			<th style="width:20px;">Nro.</th>
			<th style="width:100px;">DNI</th>
			<th align=left>Apellido</th>
			<th align=left>Nombre</th>
		</tr>';
$i=1;
$pagina = 2;
while($fila_listado_alumnos = pg_fetch_row($listado_alumnos)){
	if($i==27){
		$html.=$nueva_hoja.'
		<table class="tabla">
		<tr>
			<th style="width:20px;">Nro.</th>
			<th style="width:100px;">DNI</th>
			<th align=left>Apellido</th>
			<th align=left>Nombre</th>
		</tr>
		';
	}
	$html.='<tr><td align=center>'.$i.'</td><td align=center>'.$fila_listado_alumnos[2].'</td><td>'.$fila_listado_alumnos[0].'</td><td>'.$fila_listado_alumnos[1].'</td></tr>';
	$i++;
}
$html.='</table>';

include('cuerpo.php');

$filename = 'inscripcion_cursado_comision.pdf';
$pdf = new DOMPDF();
$pdf->set_paper("A4", "portrait");
$pdf->load_html($cuerpo);
$pdf->render();
$pdf->stream($filename,array('Attachment'=>0));

?>