<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');
$base = dbConectar();
$fecha_hoy_dia = date('d');
$fecha_hoy_mes = date('m');
$fecha_hoy_anio = date('Y');

if(isset($_POST['idpais'])) $idpais = $_POST['idpais'];
else $idpais = '0';
if(isset($_POST['idprovincia'])) $idprovincia = $_POST['idprovincia'];
else $idprovincia = '0';
if(isset($_POST['departamento'])) $departamento = $_POST['departamento'];
else $departamento = '0';
if(isset($_POST['iddepto'])) $iddepto = $_POST['iddepto'];
else $iddepto = '0';
if(isset($_POST['idlocalidad'])) $idlocalidad = $_POST['idlocalidad'];
else $idlocalidad = '0';
if(isset($_POST['idalumno'])) $idalumno = $_POST['idalumno'];
else $idalumno = '0';
if(isset($_POST['domicilio'])) $domicilio = $_POST['domicilio'];
else $domicilio = '';   
if(isset($_POST['numero'])) $numero = $_POST['numero'];
else $numero = '';
if(isset($_POST['piso'])) $piso = $_POST['piso'];
else $piso = '';
if(isset($_POST['depto'])) $depto = $_POST['depto'];
else $depto = '';
if(isset($_POST['dia'])) $dia = $_POST['dia'];
else $dia = $fecha_hoy_dia;
if(isset($_POST['mes'])) $mes = $_POST['mes'];
else $mes =$fecha_hoy_mes;
if(isset($_POST['anio'])) $anio = $_POST['anio'];
else $anio = $fecha_hoy_anio;
if(isset($_POST['correo'])) $correo = $_POST['correo'];
else $correo = '';
if(isset($_POST['telefono'])) $telefono = $_POST['telefono'];
else $telefono = '';
if(isset($_POST['dni'])) $dni = $_POST['dni'];
else $dni = 0;

echo '
<div class="recuadro" style="margin-right:10px; margin-bottom:20px;">
<b>Datos Adicionales:</b>
<table border=0>
	<tr><td>Correo: </td><td>
			<input type="text" id="correo" value="'.$correo.'"></td><td style="width:30px;"></td><td> Teléfono: </td><td colspan=5><input type="text" id="telefono" size=10 maxlength="10" value="'.$telefono.'" />
		</td>
	</tr>
	<tr><td>País: </td><td><select id="pais" style="width:100%;" onchange="eligepais()">
								<option value="0" '; if ($idpais == 0) echo 'selected'; echo '>Seleccionar</option>
								<option value="1" '; if ($idpais == 1) echo 'selected'; echo '>Argentina</option>
								<option value="2" '; if ($idpais == 2) echo 'selected'; echo '>Chile</option>
							   </select></td><td></td>
        <td> Domicilio: </td><td colspan=5><input type="text" id="direccion" size=40 value="'.$domicilio.'" />                
                               
		
	</tr>
	<tr>
		<td>Provincia </td><td><div id="div_provincia">';
		if ($idpais==1){
			$provincias = dbConsultar($base,"select * from provincias order by provincia");

			echo '<select id="provincia" style="width:100%;" onchange="eligeprovincia()">
											<option value="0">Seleccionar</option>';
											while($fila = pg_fetch_row($provincias)){
												echo '<option value="'.$fila[0].'" ';
												if($fila[0]==$idprovincia) echo 'selected';
												echo '>'.$fila[1].'</option>';
											}
											echo '</select>';
			}
			else echo '<input type="text" id="provincia" style="width:100%;" placeholder="escriba la provincia">';
		echo '</div></td>
        <td style="width:30px;"></td><td>Nro: </td><td><input type="text" id="direnum" value="'.$numero.'" size=4/></td>
		
		</tr>
		<tr>
		<td>Departamento: </td><td><div id="div_depto">';
		if ($idprovincia==1){

		$departamentos = dbConsultar($base,"select * from departamentos order by nombre");
            
		echo '<select id="departamento" style="width:100%;" onchange="eligedepto()">
										<option value"0">Seleccionar</option>';
										while($fila = pg_fetch_row($departamentos)){
											echo '<option value="'.$fila[3].'" ';
											if($fila[3]==$iddepto) echo 'selected';
											echo '>'.$fila[2].'</option>';
										}
										echo '</select>';
		}
		else{
			echo '<input type="text" id="departamento" style="width:100%;" placeholder="escriba un departamento">';
			echo '<iframe style="display:none;" onload="blanco()"></iframe>';
		}
		echo '</div></td>
        <td style="width:30px;"></td><td>Piso: </td><td><input type="text" id="direpiso" value="'.$piso.'" size=4/></td>
		
	</tr>
	<tr><td>Localidad: </td><td><div id="div_localidad">';

	$localidad = dbConsultar($base,"select * from localidades where depto='$iddepto' order by nombre");

	echo '<select id="localidad" style="width:100%;">
									<option value"0">Seleccionar</option>';
									while($fila = pg_fetch_row($localidad)){
										echo '<option value="'.$fila[6].'" ';
										if($fila[6]==$idlocalidad) echo 'selected';
										echo '>'.$fila[4].'</option>';
									}
									echo '</select>';
	echo '</div></td>
		<td style="width:30px;"></td><td>Depto: </td><td>
            <table width=100% cellspaccing=0 cellpadding=0><tr>
                <td><input type="text" id="diredepto" value="'.$depto.'" size=4/></td>
                <td align=right></td>
            </tr></table>
        </td>
	</tr>
</table>
</div><hr><br>
<div class="recuadro" style="margin-right:10px;">
<b>Documentacion Presentada:</b>

<table border=0 style="width:800px;"><tr><td>
<table border=0>';

$docu = dbConsultar($base,"select * from tipodocumentacion");
if($idalumno!=0){
	$documentacion_cargada = dbConsultar($base,"select * from documentacion a join personas b on a.dni = b.dni join alumno c on b.idpersona = c.idpersona where c.idalumno = $idalumno");
}
while($fila_docu = pg_fetch_row($docu)){
	$documentacion_cargada = dbConsultar($base,"select * from documentacion a join personas b on a.dni = b.dni where iddocumentacion = ".$fila_docu[0]." and b.dni = $dni");
	echo '<tr style="height:28px;"><td>'.$fila_docu[1].'</td><td><input type="checkbox" name="docu" id="'.$fila_docu[0].'" onclick="chek_pase('.$fila_docu[0].')" ';
	if($dni!=0){
		if(dbCount($documentacion_cargada)>0) echo 'checked';
	}
	echo '></input>';
	if(dbCount($documentacion_cargada)>0){
		$datos_pase = dbConsultar($base,"select b.cue,b.anexo,nombre,anio from pase a,establec b 
									where a.idalumno = $idalumno and a.cue = b.cue and a.anexo = b.anexo");
		$fpase = pg_fetch_row($datos_pase);
		echo '<iframe onload="activar('.$fpase[dbCampo($datos_pase,'cue')].',
									  '.$fpase[dbCampo($datos_pase,'anexo')].',
									\''.$fpase[dbCampo($datos_pase,'nombre')].'\',
									  '.$fpase[dbCampo($datos_pase,'anio')].')" style="display:none;"></iframe>';
	}
	echo '</td></tr>';
}

echo '</table></td><td align=left valign=bottom>
<a href="#" onclick="validar_modifica()" title="Modificar los datos del alumno." class="btn">Modificar Datos del alumno</a>
</td></tr></table>

</div>
<hr><br>
<table border=0><tr><td valign=top>
<div id="div_pase" style="opacity:0.3;">
<b>Datos del Pase:</b>
<table>
	<tr><td>Año de ingreso:</td><td>
									<select id="anio_pase" disabled>
										<option value="1">1°</option>
										<option value="2">2°</option>
										<option value="3">3°</option>
										<option value="4">4°</option>
									</select></td></tr>
	<tr><td>Establec. de origen:</td><td>
									<input type="text" id="bus_escuela" onkeyup="buscar_escuela()" onblur="buscar_escuela_off()" disabled/>
									<input type="hidden" id="vcue" /><input type="hidden" id="vanexo" />
									<div id="div_buscar" style="max-height:100px; overflow-y:scroll; border:1px solid '.$color.'; display:none;"></div></td></tr>
</table>
</div>
<div id="carreras"></div><br>';
if($idalumno!='0'){
	if ($idalumno!=''){
		$carreras = dbConsultar($base,"select distinct(carrera) as carrera, a.idcarrera from  inscripcion_cursado a 
										join carreras b on a.idcarrera = b.idcarrera
										where idalumno = $idalumno");
		
		$html.='<div class="recuadro" style="display:block;">*Carreras en las que cursa el/la alumno/a<br><div style="width:100%;"><table class="tabla">';
		$html.='<tr><th align=left>Carreras en que esta inscripto/a</th><th>Ultima inscripcion</th><th>Opciones</th></tr>';
		while($fila = pg_fetch_row($carreras)){
			$ultima_inscripcion = dbConsultar($base,"select max(anio_lectivo) from  inscripcion_cursado a 
											where idalumno = $idalumno and idcarrera = ".$fila[1]."
											group by anio_lectivo");
			$ultima = pg_fetch_row($ultima_inscripcion);
			$html.='<tr><td>'.$fila[0].'</td><td align=center>'.$ultima[0].'</td><td><a href="#" onclick="constancia('.$idalumno.','.$fila[1].')" class="btn">Constancia</a></td></tr>';
		}
		$html.='</table></div></div>
        </td>
        <td valign=bottom>

        	<a href="#" class="btn" onclick="inscripcion(\''.$idalumno.'\')"> Inscribir en otra carrera</a>
        </td></tr></table>';
	}
	else{
    $carreras = dbConsultar($base,"select idcarrera,carrera from carreras where carrera is not null and idcarrera not in
                                    (6,18,27,31) and idcarrera in (22,23,26,30,32) order by carrera");
		echo '<div class="recuadro" style="float:bottom;">'.nota($color,'Por favor complete los datos solicitados del/la alumno/a, seleccione una carrera y presione inscribir.').'<br>	
		<b>Carrera en la que se va a inscribir al alumno/a</b>
		
		<table border=0>
			<tr><td>Nivel: </td><td><select id="nivel">
										<option value"4" selected>Terciario</option>
									   </select></td>
			</tr>
			<tr>
				<td>Año</td><td><input type="text" id="dia_insc" value="31" size=1 disabled />/<input type="text" id="mes_insc" value="03" size=1 disabled />/'.selanio('anio_lectivo',date('Y'),'cambia_anio()').'</td> 
			</tr>
			<tr><td>Inscribir en: </td><td ><select id="carrera" style="width:100%;">
										<option value"0">Seleccionar</option>';
										while($fila = pg_fetch_row($carreras)){
											$html.='<option value="'.$fila[0].'">'.$fila[1].'</option>';
										}
										$html.='</select></td>
			</tr>
		</table><br><hr><center></div><a href="#" onclick="validar(0)" class="btn">Inscribir</a> </center>';

	}
	echo $html.'<iframe onload="document.getElementById(\'cargando\').innerHTML=\'\'" style="display:none;">';
}
echo '</div>';

?>