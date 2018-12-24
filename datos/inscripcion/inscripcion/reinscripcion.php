<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$idalumno = $_POST['idalumno'];
$base = dbConectar();

$carreras = dbConsultar($base,"select idcarrera,carrera from carreras where carrera is not null and idcarrera not in (6,18,27,31) and idcarrera in (22,23,26,30,32) order by carrera");

$html = 'Carreras en la que se puede inscribir el alumno/a<br><table border=0 style="margin-top:10px;">
			<tr><td>Nivel: </td><td><select id="nivel">
										<option value"4" selected>Terciario</option>
									   </select></td>
			</tr>
			<tr>
				<td>Año</td><td><input type="text" id="dia_insc" value="31" size=1 disabled />/<input type="text" id="mes_insc" value="03" size=1 disabled />/'.selanio('anio_lectivo',date('Y'),'cambia_anio()').'</td>
			</tr>
			<tr><td>Inscribir en: </td><td ><select id="inscarreras" style="width:100%;">
										<option value"0">Seleccionar</option>';
										while($fila = pg_fetch_row($carreras)){
											$html.='<option value="'.$fila[0].'">'.$fila[1].'</option>';
										}
										$html.='</select></td>
			</tr>
		</table><br><hr style="margin-top:-10px;"><a href="#" class="btn" onclick="cerrar()">Cerrar</a> <a href="#" class="btn" onclick="validar(1)">Inscribir</a>';
echo $html;
?>
