<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$base = dbConectar();

$java = '<script src="'.$prof.'scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/prototype.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/moo.ajax.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/behaviour.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function cargar(){

}
function agregar(){
   var nombreusuario = document.getElementById("nombreusuario").value;
   var clave = document.getElementById("clave").value;
   var idperfil = document.getElementById("idperfil").value;

   new ajax ("aj_inserta_usuario.php",{postBody: "nombreusuario="+nombreusuario+"&idperfil="+idperfil+"&clave="+clave ,update: $("estado")});
}
function eliminar(id){
	new ajax ("aj_eliminar_mesa.php",{postBody: "id="+id,update: $("estado")});
}

function modificar(id){
	 dia=document.getElementById("element_1_2").value;
     mes=document.getElementById("element_1_1").value;
	 anio=document.getElementById("element_1_3").value;  
	new ajax ("aj_modifica_mesa.php",{postBody: "dia="+dia+"&mes="+mes+"&anio="+anio+"&id="+id ,update: $("estado")});
}

function traer_datos(idusuario){

  	 document.getElementById("divboton").innerHTML=" <a href=\"#\" class = \"btn\" onclick = \"modificar("+idusuario+")\">Modificar</a> <a href=\"#\" class = \"btn\" onclick = \"eliminar("+idusuario+")\">Eliminar</a>  <a href=\"#\" class = \"btn\" onclick = \"location.reload(true)\">Nuevo</a>   ";  
	 ';
	 
$java.='}
function finalizar_inscripcion(){
	alert (\'Usuario actualizado con exito!!\');	
	location.reload(true);
}


</script>';

$html.= '<h1 style="background-color:'.$color_suave.';">Usuarios / ABM Usuarios</h1>';
include('menu_normalizados.php');
$html.='
<div class="form">
<div class="triangulo" style="border-top-color:'.$color.'; margin-top:-20px; margin-left:20px; position:fixed;"></div><br>';

$usuarios_perfil = dbConsultar($base,"select * from usuarios a,perfil_usuario b where  a.id_perfil=b.id_perfil");
$html.='
'.nota($color,'Administre los usuarios, Alta, baja y modificación.').'<br>
<div style="max-height:400px; overflow-y:scroll; width:500px; border:0px solid rgba(0,0,0,.2);">
<table class="tabla" border="0" style="width:100%;">
<tr><th align="center">Usuario</th><th align="center">Perfil</th></tr>';
while($usuarios = pg_fetch_row($usuarios_perfil)){
	$html.= '<tr onclick="traer_datos('.$usuarios[0].')"><td align="center">'.$usuarios[1].'</td><td align="center" >'.$usuarios[5].'</td>
	</tr>';
}

$idusuario=-1;

if ($idusuario==-1){
	$nuevo=1;
}
else{
	$nuevo=0;	
};


$html.= '</table>
</div>';


$html.='<table border=0>';


$html.='	
<tr>
  <td>Nombre Usuario: </td>
  <td>
	<input type="text" id="nombreusuario" name="nombreusuario" size="20" maxlength="20"  value="">
  </td>
  </tr>
<tr>
  <td>Contraseña: </td>
  <td>
	<input type="text" id="clave" name="clave" size="20" maxlength="20"  value="">
	<input type="hidden" id="idusuario" name="idusuario" size="30" maxlength="30"  value="'.$idusuario.'">
  </td>
  </tr>
<br>


<tr><td>Perfil:</td><td>';
	$perfil = dbConsultar($base,"select * from perfil_usuario ");

			$html.='<select id="idperfil" style="width:150px;" ">
					<option value="0">Seleccionar</option>';
					while($fila = pg_fetch_row($perfil)){
						$html.= '<option value="'.$fila[0].'" ';
						if($fila[0]==$idperfil) $html.= 'selected';
						$html.= '>'.$fila[1].'</option>';
					}
					$html.= '</select>

</td>
</tr>';





	$html.='</table>
<hr><br>';
if ($nuevo==1){
	$html.='<a href="#" class="btn" onclick=agregar('.$idcarrera.')>Agregar usuario</a>';	
}
else{
	$html.='
	<a href="#" class="btn" onclick=modificar('.$idcarrera.')>Modificar usuario</a>
	<a href="#" class="btn" onclick=eliminar('.$idcarrera.')>Eliminar usuario</a>';	
};

$html.='<div id="mesas"></div>
';

include($prof."template.php");
?>

