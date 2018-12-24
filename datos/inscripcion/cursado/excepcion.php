<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$idalumno = $_POST['idalumno'];
$idcarrera = $_POST['idcarrera'];
$base = dbConectar();


$carreras = dbConsultar($base,"select idmateria,anio,materia from v_materiasxcarrera where idcarrera=$idcarrera order by anio,materia");

$html = '<div style="margin-top:4px;"></div>Seleccione la Materia que desea inscribir al alumno/a<br><table border=0 style="margin-top:10px;">
			<tr><td>Fecha de inscripcion:</td><td><input type="text" id="dia_insc" value="31" size=1 disabled />/<input type="text" id="mes_insc" value="03" size=1 disabled />/'.selanio('anio_lectivo',date('Y'),'cambia_anio()').'</td></tr>	
			<tr><td>Inscribir en: </td><td ><select id="materias_excepcion" style="max-width:369px;" onchange=comision_excepcion('.$idcarrera.','.$idalumno.')>
										<option value="0">Seleccionar</option>';
										while($fila = pg_fetch_row($carreras)){
										$html.='<option value="'.$fila[0].'">Año de estudio:'.$fila[1].'° - '.$fila[2].'</option>';
                
										}
										$html.='</select>
										</td>
                   										
			</tr>
			<tr>	
				<td>Observaciones</td><td> <textarea id="observaciones" cols="50"></textarea></td>	
			</tr>
			<tr><td>Comision</td>
<td><div id=excepcion></div></td></tr>
<tr><td colspan=2><div id=mensaje_excepcion style="max-width:500px; color:red;"></div></td></tr>';

		$html.='</table><hr><a href="#" class="btn" onclick="cerrar()">Cerrar</a> <a href="#" class="btn" onclick="inscripcion_excepcion('.$idalumno.','.$idcarrera.')">Inscribir</a>';
echo $html;
?>
