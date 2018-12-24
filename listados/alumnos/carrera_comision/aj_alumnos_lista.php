<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$idcarrera = $_POST['carrera'];
$anio = $_POST['anio'];
$idmateria = $_POST['materia'];
$comision = $_POST['comision'];
$anio_lectivo = $_POST['anio_lectivo'];


$base = dbConectar();

$clt_busqueda = dbConsultar($base,"select x.*,y.nota from (
    select distinct a.idcarrera,a.carrera,a.anio,a.materia,b.idalumno,nombre,apellido,id_inscripcion_cursado
    from v_materiasxcarrera a,inscripcion_cursado b, alumno c, personas d
    where a.idmateria=b.idmateria and b.idalumno = c.idalumno and c.idpersona = d.idpersona
    and a.idcarrera=$idcarrera and a.anio=$anio and a.idmateria=$idmateria and comision = $comision and anio_lectivo = $anio_lectivo
    order by b.idalumno,a.idcarrera) x
    left join notas y on y.id_inscripcion = x.id_inscripcion_cursado");

$clt_materia = dbConsultar($base,"select * from v_materiasxcarrera where idcarrera = $idcarrera and anio = $anio and idmateria = $idmateria");
$fila_materia = pg_fetch_row($clt_materia);

if(pg_num_rows($clt_busqueda)!=0){
    echo '
    <b>Alumnos inscriptos en '.$fila_materia[5].' ('.$fila_materia[3].'° año)</b><br><br>
    <div style="max-height:200px; overflow-y:scroll; width:600px; border:1px solid rgba(0,0,0,0.2);">
    <table class="tabla" style="width:100%;">
        <tr><th>Apellido</th><th>Nombre</th><th>Nota</th></tr>';

    while($fila = pg_fetch_row($clt_busqueda)){
        echo '<tr><td align=center>'.$fila[6].'</td><td align=center>'.$fila[5].'</td><td align=center><input type="text" name="notas" maxlength=3 size=3 value="'; 
        if($fila[8] !='') echo $fila[8];
        else echo '';
        echo '"  style="text-align:center;"><input type="hidden" name="inscripciones" value='.$fila[7].' /></td></tr>';
    }

    echo '</table>
    </div><br>
    <hr><br>
    <a href="#" onclick="guardar()" class="btn" style="margin-left:500px;">Guardar</a>

    ';
}
else{
    echo '<div><br><b>No hay alumnos inscriptos en '.$fila_materia[5].' ('.$fila_materia[3].'° año)</b></div>';
}
?>
