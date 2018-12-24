<?PHP
include('bd.php');

$clave = $_POST['clave'];
$consulta = $_POST['consulta'];
$parametro = $_POST['parametro'];
$funcion = $_POST['funcion'];
$campo = $_POST['campo'];

$sql = $consulta." where ".$parametro." ilike '%".$clave."%'";

$base = dbConectar();
$provincias = dbConsultar($base,$sql);

echo '<div style="height:378px; width:100% padding:0px; overflow-y:scroll; background-color:white;"><table class="tabla" style="width:100%;">
	<tr><th>dni</th><th>apellido</th><th>nombre</th></tr>';
while($fila = pg_fetch_row($provincias)){
	echo '<tr onclick="'.$funcion.'('.$fila[$campo].')"><td>'.$fila[0].'</td><td>'.$fila[1].'</td><td>'.$fila[2].'</td></tr>';
}
echo '</table></div>';
?>