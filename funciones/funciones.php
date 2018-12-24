<?php
function selanio($nombre,$anio,$funcion){
	$base = dbConectar();
	$anio_actual = date('Y');

	$clt_anios = dbConsultar($base,"select distinct anio_lectivo from inscripcion_cursado order by anio_lectivo desc");
	$fila_anios = pg_fetch_row($clt_anios);

	$control = '<select id="'.$nombre.'" onchange="'.$funcion.'">';
	if($fila_anios[0] == $anio_actual) $control.= '<option value="'.$fila_anios[0].'">'.$fila_anios[0].'</option>';
	else $control.= '<option value="'.$anio_actual.'">'.$anio_actual.'</option>';

	while($fila_anios = pg_fetch_row($clt_anios)){
        $control.= '<option value="'.$fila_anios[0].'"';
        if ($anio == $fila_anios[0]) $control.=' selected';
        $control.='>'.$fila_anios[0].'</option>';
    }
	$control.= '</select>';
	return $control;
}
function nota($color,$nota){
	return '<div class="nota" style="border:2px solid '.$color.'; ">
				<table border=0>
					<tr>
						<td><div class="exclama" style="background-color:'.$color.';">!</div></td>
						<td style="font-weight:bold;">'.$nota.'</td>
					</tr>
				</table>
			</div>';
}
function convertir_fecha($fecha){
	$arreglo_fecha = explode('-',$fecha);
	return $arreglo_fecha[2].'/'.$arreglo_fecha[1].'/'.$arreglo_fecha[0];
}
?>