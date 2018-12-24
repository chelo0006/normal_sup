<?php
session_start();
include('sesion.php');
include('variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$base = dbConectar();

$idcarrera=$_POST['idcarrera'];
$idcomision=$_POST['idcomision'];

if ($idcomision==-1){
	$nuevo=1;
}
else{
	$nuevo=0;	
};

$id=0;

$comisionxcarrera = dbConsultar($base,"select * from comisiones where idcomision = $idcomision");
$comisiones = pg_fetch_row($comisionxcarrera);
if ($comisiones[0]==''){
	$id=0;	
}
else{
	$id=$comisiones[0];
};

$html.='
<table border=0 width=50%>
	<tr>
	<td style="width:14%;">A&ntilde;o:</td><td align="left">';
	$html.='<select id="anio" style="width:70%;" >
		<option value="0">Seleccionar</option>';
		$html.= '<option value="1"';
		if ($comisiones[2]==1) $html.=' selected ';
		$html.='>1&deg;</option>';
		$html.= '<option value="2"';
		if ($comisiones[2]==2) $html.=' selected ';
		$html.='>2&deg;</option>';
		$html.= '<option value="3"';
		if ($comisiones[2]==3) $html.=' selected ';
		$html.='>3&deg;</option>';
		$html.= '<option value="4"';
		if ($comisiones[2]==4) $html.=' selected ';
		$html.='>4&deg;</option>';
		$html.= '</select>';
	$html.='</td>
</tr>
<tr>
  <td>Nombre: </td>
  <td>
	<input type="text" id="comision" name="comision" size="10" maxlength="10"  value="'.$comisiones[3].'">
  </td>
  </tr>
<tr>
  <td>Cupo: </td>
  <td>
	<input type="text" id="cupo" name="cupo" size="2" maxlength="2"  value="'.$comisiones[7].'">
	<input type="hidden" id="id" name="id" size="10" maxlength="10"  value="'.$id.'">
  </td>
  </tr>';  
$html.='<tr><td></td><td>';

if ($nuevo==1){
	$html.='<a href="#" class="btn" onclick=agregar('.$idcarrera.')>Agregar comisi&oacute;n</a>';	
}
else{
	$html.='
	<a href="#" class="btn" onclick=modificar('.$idcarrera.')>Modificar comisi&oacute;n</a>
	<a href="#" class="btn" onclick=eliminar('.$idcarrera.')>Eliminar comisi&oacute;n</a>';	
};

$html.='</td></tr></table>';

echo $html;
//$html.= '<iframe onload="cargar()" style="display:none;"></iframe>';
?>

