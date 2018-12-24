<?php
session_start();
include('sesion.php');
include('variables.php');
//$prof='../../';
$anio_lectivo=date("Y");

include($prof.'funciones/bd.php');



$nombreusuario=$_POST['nombreusuario'];
$clave=$_POST['clave'];

$idperfil=$_POST['idperfil'];





$html='';


if (isset($_POST['idusuario']))
{
$id=$_POST['idusuario'];		
}
else
{
$id=0;	
};


$base = dbConectar();

$consulta="select * from usuarios where idusuario=$id";
$consulta2 = dbConsultar($base,$consulta);



if ($fila = pg_fetch_row($consulta2))
{
	//echo 'actualiza';
		$cadena ="UPDATE usuarios SET idperfil='$idperfil',pass=md5('$clave'),nombre='$nombreusuario' where idusuario=$id";

	
	}
else{
	//echo 'inserta';
	$cadena ="INSERT INTO USUARIOS (USUARIO,PASS,ID_PERFIL) VALUES";
	$cadena.="('$nombreusuario',md5('".$clave."'),'$idperfil');";
}




$inscribir = dbConsultar($base,$cadena);
if($inscribir) echo 'Usuario actualizado con éxito';



//echo '<iframe style="display:none;" onload="finalizar_inscripcion()"></iframe>';



?>