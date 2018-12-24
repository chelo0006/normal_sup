<?php
session_start();
include('sesion.php');
include($prof.'variables.php');
include($prof.'funciones/bd.php');

$idcarrera = $_POST['carrera'];
$anio = $_POST['anio'];
$idmateria = $_POST['materia'];
$comision = $_POST['comision'];
$anio_lectivo = $_POST['anio_lectivo'];


$base = dbConectar();

$clt_busqueda = dbConsultar($base,"select apellido,nombre,dni from inscripcion_cursado a, alumno b, personas c 
        where a.idalumno = b.idalumno and b.idpersona = c.idpersona and 
        comision = $comision and idmateria = $idmateria and idcarrera = $idcarrera and anio_lectivo = $anio_lectivo");

$clt_materia = dbConsultar($base,"select * from v_materiasxcarrera where idcarrera = $idcarrera and anio = $anio and idmateria = $idmateria");
$fila_materia = pg_fetch_row($clt_materia);

$clt_comision = dbConsultar($base,"select comision,anio_lectivo from comisiones where idcomision = $comision");
$fila_comision = pg_fetch_row($clt_comision);
if(pg_num_rows($clt_busqueda)!=0){
    echo '
    <b>Alumnos inscriptos en '.$fila_materia[5].' ('.$fila_materia[3].'° año)</b><br><b>Comisión: '.$fila_comision[0].'</b><br><br>
    <div style="max-height:200px; overflow-y:scroll; width:600px; border:1px solid rgba(0,0,0,0.2);">
    <table class="tabla" style="width:100%;">
        <tr><th>Nro.</th><th>DNI</th><th align=left>Apellido</th><th align=left>Nombre</th></tr>';
    $i=1;
    while($fila = pg_fetch_row($clt_busqueda)){
        echo '<tr><td align=center>'.$i.'</td><td align=center>'.$fila[2].'</td><td align=left>'.$fila[0].'</td><td align=left>'.$fila[1].'</td></tr>';
        $i++;
    }

    echo '</table>
    </div><br>
    <hr><br>
    <a href="#" onclick="imprimir()" class="btn" style="margin-left:500px;">Imprimir</a>

    ';
}
else{
    echo '<div><br><b>No hay alumnos inscriptos en '.$fila_materia[5].' ('.$fila_materia[3].'° año)</b></div>';
}
?>
