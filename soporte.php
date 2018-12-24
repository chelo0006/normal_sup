<?PHP
session_start();

$ruta = $_POST['ruta'];
echo '<br>Problema: <input type="text" id=ruta value="'.$ruta.'" style="width:400px;" disabled />
<br><br><div style="text-align:left; padding:5px;">Descripción del problema:<br>
<textarea id="descripcion" style="width:100%;" rows=15></textarea><br><hr>
</div><br>
<a class="btn" href="#" onclick="cerrar();">Cancelar</a> <a class="btn" href="#" onclick="guardar_error();">Informar</a> 
<a class="btn" href="#" onclick="exportar_error();">Exportar</a>
';

?>