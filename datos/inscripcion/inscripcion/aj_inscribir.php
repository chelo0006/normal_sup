<?php
session_start(); 
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');

$materias_falta_comision = array();
function inscribir($idalumo_insert,$carrera_insert,$dia,$mes,$anio_lectivo){
    $base = dbConectar();
    $cadena = 'insert into inscripcion_cursado(idalumno,idcarrera,idmateria,anio_lectivo,fecha_inscripcion,foperacion,usuario,comision) values';
    global $materias_falta_comision;
    $materias_de_primero = dbConsultar($base,"select * from v_materiasxcarrera where idcarrera = ".$carrera_insert." and anio = 1");
    $primera = 1;
    $error = 0;
    while($materias_de_primero_fila = pg_fetch_row($materias_de_primero)){
        $estado = 0;
        $comisiones = dbConsultar($base,"select * from comisiones where idcarrera=$carrera_insert and anio=1 order by comision asc");
        $error_comision = 0;
        while($comisiones_fila = pg_fetch_row($comisiones)){
            $cantidad = dbConsultar($base,"select count(id_inscripcion_cursado) from inscripcion_cursado where idcarrera = 23 and idmateria = ".$materias_de_primero_fila[2]." and comision = ".$comisiones_fila[0]);
            $cantidad_fila = pg_fetch_row($cantidad);
            if($cantidad_fila[0]<$comisiones_fila[dbCampo($comisiones,'cupo')]){
                if($primera!=1){
                    $cadena.=',';
                } 
                else $primera = 0;

                $cadena.='('.$idalumo_insert.','.$carrera_insert.','.$materias_de_primero_fila[2].','.$anio_lectivo.',\''.$anio_lectivo.'-'.$mes.'-'.$dia.'\',now(),\''.$_SESSION['usuario'].'\','.$comisiones_fila[0].')';
                $estado = 1;
                break;
            }
        }
        if($estado == 0) array_push($materias_falta_comision, $materias_de_primero_fila[5]);
    }
    if(sizeof($materias_falta_comision)==0) return dbConsultar($base,$cadena);
    else return -1;
} 

$tipo = $_POST['tipo'];
if($tipo == 0){
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
    $telefono = $_POST['telefono'];
    $aniolectivo = $_POST['aniolectivo'];

    if(isset($_POST['cue'])){
        $cue = $_POST['cue'];
        $anexo = $_POST['anexo'];
        $zanio = $_POST['zanio'];
    }

    $dia_insc = $_POST['dia_insc'];
    $mes_insc = $_POST['mes_insc'];

    $base = dbConectar();

    //verifica que la persona exista
    $verifia_persona = dbConsultar($base,"select * from personas where dni = $dni");
    if($fila = pg_fetch_row($verifia_persona)){
        //verifica que el alumno exista
        $verifia_alumno = dbConsultar($base,"select * from alumno a join personas b on a.idpersona = b.idpersona where dni = $dni");
        if($fila2 = pg_fetch_row($verifia_alumno)){
                //realiza la inscripcion
                $nva_inscripcion = inscribir($fila2[0],$carrera,$dia_insc,$mes_insc,$aniolectivo);
                if($nva_inscripcion != -1) echo 'Se inscribió a el alumno ('.$dni.') con éxito';
                else echo 'No se pudo insccribir al alumno porque faltan comisiones';
        }
        //si no exiaste el alumno
        else{
            //crea el alumno
            $nvo_alumno = dbConsultar($base,"insert into alumno(idpersona,aniolectivo)
                                             values(".$fila[14].",".date('Y').") RETURNING idalumno");
            $fila3 = pg_fetch_row($nvo_alumno);
            $idalumno = $fila3[0];
            //realiza la inscripcion
            $nva_inscripcion = inscribir($idalumno,$carrera,$dia_insc,$mes_insc,$aniolectivo);
            if($nvo_alumno) if($nva_inscripcion != -1) echo 'Se agrego como alumno y se inscribió a la persona ('.$dni.') con éxito';
            else echo 'No se pudo insccribir al alumno porque faltan comisiones';
        }
    }
    //si la persona no existe
    else{
        //crea la persona
        $nva_persona = dbConsultar($base,"insert into personas(apellido,nombre,dni,domicilio,numero,piso,depto,idlocalidad,idprovincia,\"Sexo\",fnac,nacionalidad,iddepartamento,correo,telefono,tipodoc)
        values('$apellido','$nombre',$dni,'$domicilio',$numero,'$piso','$diredepto',$localidad,$provincia,$sexo,'$dia-$mes-$anio',$pais,$departamento,'$correo','$telefono',$tipodni)
        RETURNING idpersona");
        $fila4 = pg_fetch_row($nva_persona);
        //crea el alumno
        $nvo_alumno = dbConsultar($base,"insert into alumno(idpersona,aniolectivo)
                                         values(".$fila4[0].",".date('Y').")
                                         RETURNING idalumno");
        $fila5 = pg_fetch_row($nvo_alumno);
        $idalumno = $fila5[0];
        //realiza la inscripcion
        $nva_inscripcion = inscribir($idalumno,$carrera,$dia_insc,$mes_insc,$aniolectivo);
        if($nva_persona) if($nvo_alumno) if($nva_inscripcion != -1) echo 'Se inserto como persona, se agrego como alumno y se inscribió a la persona ('.$dni.') con éxito';
        else echo 'No se pudo insccribir al alumno porque faltan comisiones';
    }
}
else{
    $dni = $_POST['dni'];
    $carrera = $_POST['carrera'];
    $aniolectivo = $_POST['aniolectivo'];

    $dia_insc = $_POST['dia_insc'];
    $mes_insc = $_POST['mes_insc'];
    
    $base = dbConectar();
    $verifia_alumno = dbConsultar($base,"select * from alumno a join personas b on a.idpersona = b.idpersona where dni = $dni");
    $fila = pg_fetch_row($verifia_alumno);
    $nva_inscripcion = inscribir($fila[0],$carrera,$dia_insc,$mes_insc,$aniolectivo);
    if($nva_inscripcion != -1) echo 'Se agrego como alumno y se inscribió a la persona ('.$dni.') con éxito';
    else echo 'No se pudo insccribir al alumno porque faltan comisiones';
}

if($nva_inscripcion != -1){
    if(isset($_POST['cue'])){
        $consultar_pase = dbConsultar($base,"select b.cue,b.anexo,nombre,anio from pase a,establec b 
                                            where a.idalumno = $idalumno and a.cue = b.cue and a.anexo = b.anexo)");
        if(dbCount($consultar_pase)==0){
            $insertar_pase = dbConsultar($base,"insert into pase(idalumno,idcarrera,cue,anexo,foperacion,usuario,anio)
                                            values($idalumno,$carrera,$cue,$anexo,now(),'{$_SESSION['usuario']}',$zanio)");
        }
        else{
            $actualizar = dbConsultar($base,"update pase set cue=$cue, anexo=$anexo, usuario={$_SESSION['usuario']} where idalumno = $idalumno");
        }
    }
    echo '<iframe onload="validar_modifica2(\'La inscripción fue realizada con éxito\')" style="display:none;">';
}
else echo '<iframe onload="validar_modifica2(\'No se pudo inscribir al alumno por favor reporte el error al administrador\')" style="display:none;">';

?>