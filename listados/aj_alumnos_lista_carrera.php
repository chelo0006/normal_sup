<?php
session_start();
include('sesion.php');
include($prof.'variables.php');
include($prof.'funciones/bd.php');

$idcarrera = $_POST['carrera'];
$anio_lectivo = $_POST['anio_lectivo'];
$sexo = $_POST['sexo'];


$base = dbConectar();

$clt_busqueda = dbConsultar($base,"select distinct dni,apellido,nombre,
							       CASE \"Sexo\"
							       WHEN 1 THEN 'MASCULINO'::text
							       WHEN 2 THEN 'FEMENINO'::text								   
								   ELSE NULL
								   END AS SEXO
								   from inscripcion_cursado a, alumno b, personas c 
                                    where a.idalumno = b.idalumno and c.idpersona = b.idpersona and
                                    idcarrera = $idcarrera and anio_lectivo = $anio_lectivo and c.\"Sexo\"='$sexo'");

$carrera = dbConsultar($base,"select carrera from carreras where idcarrera = $idcarrera");
$fila_carrera = pg_fetch_row($carrera);
/*
$clt_comision = dbConsultar($base,"select comision,anio_lectivo from comisiones where idcomision = $comision");
$fila_comision = pg_fetch_row($clt_comision);*/
if(pg_num_rows($clt_busqueda)!=0){
    echo '
    <b>Alumnos inscriptos en '.$fila_carrera[0].' (año lectivo '.$anio_lectivo.')</b><br><br>
    <div style="max-height:200px; overflow-y:scroll; width:600px; border:1px solid rgba(0,0,0,0.2);">
    <table class="tabla" style="width:100%;">
        <tr><th>Nro.</th><th>DNI</th><th align=left>Apellido</th><th align=left>Nombre</th><th align=left>Sexo</th></tr>';
    $i=1;
    while($fila = pg_fetch_row($clt_busqueda)){
        echo '<tr><td align=center>'.$i.'</td><td align=center>'.$fila[0].'</td><td align=left>'.$fila[1].'</td><td align=left>'.$fila[2].'</td><td align=left>'.$fila[3].'</td></tr>';
        $i++;
    }

    echo '</table>
    </div><br>
    <hr><br>
    <a href="#" onclick="imprimir()" class="btn" style="margin-left:500px;">Imprimir</a>

    ';
}
else{
    echo '<div><br><b>No hay alumnos inscriptos en '.$fila_carrera[0].' (año lectivo '.$anio_lectivo.') </b></div>';
}
?>
