<?php
session_start();
session_start();
include('sesion.php');
include($prof.'variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$base = dbConectar();

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition:  filename=\"Reportre_errores_".date("d/m/Y").".xls\";");
header('Pragma: no-cache');
header('Expires: 0');

echo "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns=\"http://www.w3.org/TR/REC-html40\">
      <html>
      <head><meta http-equiv=\"Content-type\" content=\"text/html;charset=utf-8\" /></head>
      <body>";

/* consultas van aqui  */

	$cadena ="SELECT * FROM REPORTE_ERROR";
	echo "<table border=1>
			<tr>
				<th>id_reporte_error</th>
				<th>ruta</th>
				<th>descripcion_error</th>
				<th>usuario</th>
				<th>fecha de operacion</th>
			</tr>";
			
$errores = dbConsultar($base,$cadena);
while ($fila = pg_fetch_row($errores)){
	
	     	echo "	
			<tr>
				<td align=center>".$fila[0]."</td>
				<td>".$fila[1]."</td>
				<td>".$fila[2]."</td>
				<td align=center>".$fila[3]."</td>
				<td>".$fila[4]."</td>
			</tr>";
	}


echo "</table>";



/* find de consultas */

/* Tabla va aqui  */
echo $tabla; 
/* find de tabla */


echo "</body></html>";
?>