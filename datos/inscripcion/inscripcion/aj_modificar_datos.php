<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$tipo = $_POST['tipo'];
$apellido = $_POST['apellido'];
$nombre = $_POST['nombre'];
$sexo = $_POST['sexo'];
$tipodni = $_POST['tipodni'];
$dni = $_POST['dni'];
$pais = $_POST['pais'];
$domicilio = $_POST['domicilio'];
$numero = $_POST['numero'];
$piso = $_POST['piso'];
$dia = $_POST['dia'];
$mes = $_POST['mes'];
$anio = $_POST['anio'];
$provincia = $_POST['provincia'];
$diredepto = $_POST['diredepto'];
$departamento = $_POST['departamento'];
$localidad = $_POST['localidad'];
$carrera = $_POST['carrera'];
$correo = $_POST['correo']; 
$arreglo_docu = explode(',',$_POST['arreglo_docu']); 
$telefono = $_POST['telefono'];

$base = dbConectar();

//verifica que la persona exista
$verifia_persona = dbConsultar($base,"select * from personas where dni = $dni");
if($fila = pg_fetch_row($verifia_persona)){
    $nva_persona = dbConsultar($base,"update personas set
                                        apellido = '$apellido'
                                        ,nombre = '$nombre'
                                        ,dni = $dni 
                                        ,domicilio = '$domicilio'
                                        ,numero = $numero
                                        ,piso = '$piso'
                                        ,depto = '$diredepto'
                                        ,idlocalidad = $localidad 
                                        ,idprovincia = $provincia 
                                        ,\"Sexo\" = $sexo 
                                        ,fnac = '$dia-$mes-$anio'
                                        ,nacionalidad = $pais 
                                        ,iddepartamento = $departamento 
                                        ,correo = '$correo'
                                        ,telefono = '$telefono' 
                                        ,tipodoc = $tipodni where dni = $dni");

    dbConsultar($base,"delete from documentacion where dni = $dni");

    if($arreglo_docu[0]!=""){
        for($i=0;$i<sizeof($arreglo_docu);$i++) $nva_documentacion = dbConsultar($base,"insert into documentacion(iddocumentacion,foperacion,dni)
                                                                                        values(".$arreglo_docu[$i].",now(),".$dni.")");
    }
if(!isset($_POST['mensaje'])) echo '<iframe onload="buscar(\'Datos modificados con éxito\')" style="display:none;">';
}
else{
   if(!isset($_POST['mensaje'])) echo '<iframe onload="buscar(\'No se pudieron modificar los datos de la persona, por favor revise\')" style="display:none;">';
}   
if(isset($_POST['mensaje'])) echo '<iframe onload="buscar(\''.$_POST['mensaje'].'\')" style="display:none;">';

?>