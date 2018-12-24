<?php
session_start();

$base = dbConectar(); 

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

$arreglo_estado_academico = array(array());

$estado = dbConsultar($base,$cadena);

while ($fila_estado = pg_fetch_row($estado)){
	$fila_estado_academico = array();
	array_push($fila_estado_academico, $fila_estado[dbcampo($estado,'idmateria')]);
	array_push($fila_estado_academico, $fila_estado[dbcampo($estado,'anio')]);
	array_push($fila_estado_academico, $fila_estado[dbcampo($estado,'materia')]);

	if($fila_estado[dbcampo($estado,'estado_exa')]=="Exa"){
		if($fila_estado[dbcampo($estado,'estado_pro')]=="Pro"){
			array_push($fila_estado_academico, 'Pro');
			array_push($fila_estado_academico, $fila_estado[dbcampo($estado,'notac')]);
			array_push($fila_estado_academico, convertir_fecha($fila_estado[dbcampo($estado,'fecha')]));
			array_push($fila_estado_academico, convertir_fecha($fila_estado[dbcampo($estado,'fecha_ins')]));
			array_push($fila_estado_academico, $fila_estado[dbcampo($estado,'libro')]);
		}
		else{
			if($fila_estado[dbcampo($estado,'notac')]>=4){
				array_push($fila_estado_academico, 'Exa');
				array_push($fila_estado_academico, $fila_estado[dbcampo($estado,'notac')]);
				array_push($fila_estado_academico, convertir_fecha($fila_estado[dbcampo($estado,'fecha')]));
				array_push($fila_estado_academico, convertir_fecha($fila_estado[dbcampo($estado,'fecha_ins')]));
				array_push($fila_estado_academico, $fila_estado[dbcampo($estado,'libro')]);
			}
			else{
				array_push($fila_estado_academico, 'Reg');
				array_push($fila_estado_academico, ' - ');
				array_push($fila_estado_academico, convertir_fecha($fila_estado[dbcampo($estado,'fecha_reg')]));
				array_push($fila_estado_academico, convertir_fecha($fila_estado[dbcampo($estado,'fecha_ins')]));
				array_push($fila_estado_academico, '');
			}
		}
	}
	else if($fila_estado[dbcampo($estado,'estado_pro')]=="Pro"){
		array_push($fila_estado_academico, 'Reg');
		array_push($fila_estado_academico, ' - ');
		array_push($fila_estado_academico, convertir_fecha($fila_estado[dbcampo($estado,'fecha_fin_pro')]));
		array_push($fila_estado_academico, convertir_fecha($fila_estado[dbcampo($estado,'fecha_ins')]));
		array_push($fila_estado_academico, $fila_estado[dbcampo($estado,'libro')]);
		}
		else if($fila_estado[dbcampo($estado,'estado_reg')]=="Reg"){
				array_push($fila_estado_academico, 'Reg');
				array_push($fila_estado_academico, ' - ');
				array_push($fila_estado_academico, convertir_fecha($fila_estado[dbcampo($estado,'fecha_reg')]));
				array_push($fila_estado_academico, convertir_fecha($fila_estado[dbcampo($estado,'fecha_ins')]));
				array_push($fila_estado_academico, $fila_estado[dbcampo($estado,'libro')]);
			}
		 else if($fila_estado[dbcampo($estado,'estado_cur')]=="Cur"){
		 		array_push($fila_estado_academico, 'Cur');
				array_push($fila_estado_academico, ' - ');
				array_push($fila_estado_academico, '');
		 		array_push($fila_estado_academico, convertir_fecha($fila_estado[dbcampo($estado,'fecha_ins')]));
		 		array_push($fila_estado_academico, $fila_estado[dbcampo($estado,'libro')]);
		 		}
			  else{
			  	array_push($fila_estado_academico, '');
			  	array_push($fila_estado_academico, '');
			  	array_push($fila_estado_academico, '');
			  	array_push($fila_estado_academico, '');
			  	array_push($fila_estado_academico, '');
			  	}
	array_push($arreglo_estado_academico, $fila_estado_academico);
	unset($fila_estado_academico);
}
?>
