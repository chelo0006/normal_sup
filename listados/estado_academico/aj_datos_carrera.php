<?PHP
session_start();
include('sesion.php');
include($prof.'listados/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$dni = $_POST['dni'];

$base = dbConectar();


$carreras = dbConsultar($base,"select distinct(carrera),nomcarrera,b.idalumno from
(select * from alumno a, personas b where a.idpersona = b.idpersona and b.dni = $dni) a, (select b.carrera,a.idalumno,c.carrera as nomcarrera from inscripcion_cursado a, matxcarrera b, carreras c where a.idmateria = b.\"Id\" and c.idcarrera = b.carrera) b 
where a.idalumno = b. idalumno");
$verificar = pg_num_rows($carreras);

if ($verificar>0)
{

echo '<b>DATOS:</b>
<table border=0>
<tr>
		<td>Carrera </td><td><select id="carrera" style="width:100%;" onchange="mostrar_materias()">
								<option value="0">Seleccionar</option>';
								while($fila = pg_fetch_row($carreras)){
									echo '<option id="'.$fila[2].'" value="'.$fila[0].'">'.$fila[1].'</option>';
								}
								echo '</select></td>
		</tr>	
 <tr> 
 


 </tr> 
	<tr><td colspan="2"><div id="materias"></div></td></tr>

</table>';
	}
else
{
echo '<table border=0 width="100%">
<tr><td align="left"><font style="color:'.$color.';" size=5  face="Comic Sans MS,arial,verdana">El alumno no fue inscripto en la opci&oacute;n Ficha de Inscripci&oacute;n , verifique!!</font></td></tr>
</table>';

};


?>