<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$idcarrera = $_POST['carrera'];
$anio = $_POST['anio'];
$idmateria = $_POST['materia'];
$comision = $_POST['comision'];
$anio_lectivo = $_POST['anio_lectivo'];
$fecha = $_POST['fecha'];

$fecha_fin=date("d/m/Y",strtotime($_POST['fecha']."+ 24 month")); 

$base = dbConectar();

$clt_busqueda = dbConsultar($base,"select x.*,y.nota,y.estado,y.foperacion,y.fecha,y.fecha_fin,y.idnotas from (
    select distinct a.idmateria,a.carrera,a.anio,a.materia,b.idalumno,nombre,apellido,id_inscripcion_cursado
    from v_materiasxcarrera a,inscripcion_cursado b, alumno c, personas d
    where a.idmateria=b.idmateria and b.idalumno = c.idalumno and c.idpersona = d.idpersona
    and a.idcarrera=$idcarrera and a.anio=$anio and a.idmateria=$idmateria and comision = $comision and anio_lectivo = $anio_lectivo
    order by b.idalumno) x
    left join notas y on y.id_inscripcion = x.id_inscripcion_cursado");

$clt_materia = dbConsultar($base,"select * from v_materiasxcarrera where idcarrera = $idcarrera and anio = $anio and idmateria = $idmateria");
$fila_materia = pg_fetch_row($clt_materia);

if(pg_num_rows($clt_busqueda)!=0){
    echo '
    <b>Alumnos inscriptos en '.$fila_materia[5].' ('.$fila_materia[3].'° año)</b><br><br>
    <div style="max-height:200px; overflow-y:scroll; width:800px; border:1px solid rgba(0,0,0,0.2);">
    <table class="tabla" style="width:100%;">
        <tr><th>Num</th><th>Apellido</th><th>Nombre</th><th>Estado</th><th>Nota Promoción</th><th>F.Estado</th><th>Fecha</th><th></th></tr>';
    $i=1;
    while($fila = pg_fetch_row($clt_busqueda)){
        $x = explode(' ',$fila[10]);
        $y = explode('-',$fila[12]);
        $z = explode('-',$fila[11]);
        $fecha_modif = explode('-',$x[0]);
        echo '<tr><td align=center>'.$i.'</td><td align=center>'.$fila[6].'</td><td align=center>'.$fila[5].'</td><td align=center>
        <select name="estado" onchange="cambia_estado()">
            <option value="-1">Estado</option>
            <option value="Lib" '; if($fila[9]=="Lib") echo 'selected'; echo '>Libre</option>
            <option value="Reg" '; if($fila[9]=="Reg") echo 'selected'; echo '>Regular</option>
            <option value="Pro" '; if($fila[9]=="Pro") echo 'selected'; echo '>Promocionado</option>
        </select>
        <input type="hidden" name="inscripciones" value='.$fila[7].' /></td>
        <td align=center><input type="text" name="notas" maxlength=3 size=3 value="'; if($fila[9]=="Pro") echo $fila[8]; echo '" style="text-align:center;" disabled></td>
        <td align=center>';

        if($z[2]!="") echo $z[2].'/'.$z[1].'/'.$z[0];

        echo '</td>
        <td align=center>';

        if($fila[9]=="Reg" or $fila[9]=="Pro")
            if($y[2]!="") echo $y[2].'/'.$y[1].'/'.$y[0];

        echo '</td><td align=center>';

		if (($_SESSION['perfil']==1 or $_SESSION['perfil']==2) and $fila[9]=="Reg"){
            $clt_revalida = dbConsultar($base,"select * from registro_sucesos where idcontrol = ".$fila[13]);
            if(dbCount($clt_revalida) < 2){
                if($fila[12]!='') echo '<a href="#" onclick="revalida(\''.$fila[0].'\',\''.$fila[4].'\',\''.$fila[12].'\')" class="btn" >Revalidar</a>';
            }
            else echo '<font style="color:red;">No puede revalidar</font>';
		};
    echo '</td></tr>';
    $i++;
    }

    echo '</table>
    </div><br>
    <hr><br>
    <div style="width:800px;"><center><a href="#" onclick="guardar(\''.$fecha.'\',\''.$fecha_fin.'\')" class="btn">Guardar</a></center></div>
    ';
}
else{
    echo '<div><br>'.nota($color,'No hay alumnos inscriptos en '.$fila_materia[5].' ('.$fila_materia[3].'° año)').'</div>';
}
?>
