<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');
 
$idcarrera = $_POST['carrera'];
$anio = $_POST['anio'];
$idmateria = $_POST['materia'];
$anio_lectivo = $_POST['anio_lectivo'];
$fecha = $_POST['fecha'];

$base = dbConectar();

$clt_busqueda = dbConsultar($base,"select x.*,y.nota,y.libro,y.estado
                                    from ( select distinct a.idcarrera,a.carrera,a.anio,a.materia,b.idalumno,nombre,apellido,id_inscripcion_examen
                                    from v_materiasxcarrera a,inscripcion_examen b, alumno c, personas d 
                                    where a.idmateria=b.idmateria and b.idalumno = c.idalumno and c.idpersona = d.idpersona and 
                                    a.idcarrera=$idcarrera and a.anio=$anio and a.idmateria=$idmateria and anio_lectivo = $anio_lectivo and fecha_inscripcion = '$fecha'
                                    order by b.idalumno,a.idcarrera) x left join notas y on y.id_inscripcion = x.id_inscripcion_examen");
//libro
$repetir = dbConsultar($base,"select x.*,y.nota,y.libro,y.estado
                            from ( select distinct a.idcarrera,a.carrera,a.anio,a.materia,b.idalumno,nombre,apellido,id_inscripcion_examen
                            from v_materiasxcarrera a,inscripcion_examen b, alumno c, personas d 
                            where a.idmateria=b.idmateria and b.idalumno = c.idalumno and c.idpersona = d.idpersona and 
                            a.idcarrera=$idcarrera and a.anio=$anio and a.idmateria=$idmateria and anio_lectivo = $anio_lectivo and fecha_inscripcion = '$fecha'
                            order by b.idalumno,a.idcarrera) x left join notas y on y.id_inscripcion = x.id_inscripcion_examen");
$filaxx = pg_fetch_row($repetir);

$clt_materia = dbConsultar($base,"select * from v_materiasxcarrera where idcarrera = $idcarrera and anio = $anio and idmateria = $idmateria");
$fila_materia = pg_fetch_row($clt_materia);

if(pg_num_rows($clt_busqueda)!=0){
    echo '
    <b>Libro y folio de trabajo: <input type="text" id="libfol" maxlength=10 size=6 value="'.$filaxx[9].'"></b><br><br>
    <b>Alumnos inscriptos en '.$fila_materia[5].' ('.$fila_materia[3].'° año)</b><br>
    <div style="max-height:200px; overflow-y:scroll; width:700px; border:1px solid rgba(0,0,0,0.2);">
    <table class="tabla" style="width:100%;">
        <tr><th>Apellido</th><th>Nombre</th><th>Presente</th><th>Nota</th><th>Estado</th><th>Lib-Fol</th></tr>';

    while($fila = pg_fetch_row($clt_busqueda)){
        $pro = dbConsultar($base,"select nota from notas a, inscripcion_cursado b 
            where id_inscripcion = id_inscripcion_cursado and idalumno = ".$fila[4]." and idmateria=$idmateria and idcarrera = $idcarrera and a.estado = 'Pro'");
        $fila_pro = dbfila($pro);
        echo '<tr><td align=center>'.$fila[6].'</td><td align=center>'.$fila[5].'</td>
        <td align=center>';

        if($fila_pro[0] ==''){
            echo '<select name="presente"><option value="P" ';
            if($fila[10]=='Exa') echo 'selected';
            echo '>Presente</option>
            <option value="A" ';
            if($fila[10]=='Aus') echo 'selected';
            echo '>Ausente</option></select>';
        }
        else echo '<select name="presente" disabled><option value="P">Presente</option></select>';

        echo '</td>
        <td align=center>
        <input type="text" name="notas" maxlength=3 size=3 value="'; 
        if($fila[8] !=''){
            if($fila[8]!=-1) echo $fila[8];
        }
        else{
            if($fila_pro[0] !='') echo $fila_pro[0];
            else echo '';
        }
        echo '"  style="text-align:center;" ';
        if($fila_pro[0] !='') echo 'disabled';
        echo '><input type="hidden" name="inscripciones" value='.$fila[7].' /></td>
        <td align=center>';
        if($fila_pro[0] !='') echo 'Pro';
        else echo 'Reg';
        echo '</td>
        <td align=center>'.$filaxx[9].'</td>
        </tr>';
    }

    echo '</table>
    </div><br>
    <hr><br>
    <a href="#" onclick="guardar()" class="btn" style="margin-left:500px;">Guardar</a>

    ';
}
else{
    echo '<div><br>'.nota($color,"No hay alumnos inscriptos en ".$fila_materia[5]." (".$fila_materia[3]."° año) para la fecha de examen indicada").'</div>';
}
?>
