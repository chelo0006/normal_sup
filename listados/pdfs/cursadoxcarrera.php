<?php
require_once ('../../dompdf/dompdf_config.inc.php');
require ('../../funciones/bd_print.php'); 

$idcarrera = $_GET['carrera'];
$anio_lectivo = $_GET['anio_lectivo'];
$sexo = $_GET['sexo'];

if ($sexo=='1')
{
$nombre_sexo='MASCULINO';	
};

if ($sexo=='2')
{
$nombre_sexo='FEMENINO';		
};

$base = dbConectar();

$listado_alumnos = dbConsultar($base,"select distinct dni,apellido,nombre from inscripcion_cursado a, alumno b, personas c 
                                    where a.idalumno = b.idalumno and c.idpersona = b.idpersona and
                                    idcarrera = $idcarrera and anio_lectivo = $anio_lectivo and c.\"Sexo\"='$sexo'");

$carrera = dbConsultar($base,"select carrera from carreras where idcarrera = $idcarrera");
$fila_carrera = pg_fetch_row($carrera);

$titulo_listado ='LISTADO DE ALUMNOS POR CARRERA - SEXO '.$nombre_sexo.'';
$titulos = 'Carrera: '.$fila_carrera[0].'<br>	
			Año lectivo: '.$anio_lectivo;

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
		$pagina++;
	}
	$html.='<tr><td align=center>'.$i.'</td><td align=center>'.$fila_listado_alumnos[0].'</td><td>'.$fila_listado_alumnos[1].'</td><td>'.$fila_listado_alumnos[2].'</td></tr>';
	$i++;
}
$html.='</table>';

include('cuerpo.php');

$filename = 'inscripcion_cursado_carrera.pdf';
$pdf = new DOMPDF();
$pdf->set_paper("A4", "portrait");
$pdf->load_html($cuerpo);
$pdf->render();
$pdf->stream($filename,array('Attachment'=>0));

?>