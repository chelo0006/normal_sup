
<?php
session_start();
include('sesion.php');
include($prof.'datos/variables.php');
include($prof.'funciones/bd.php');
include($prof.'funciones/funciones.php');

$java = '<script src="'.$prof.'scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/prototype.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/moo.ajax.js" type="text/javascript"></script>
<script src="'.$prof.'scripts/behaviour.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function cargar(){  
    cadena = "idpais=0";
    new ajax ("aj_datos.php",{postBody: cadena ,update: $("div_datos")});
};
function cargar2(){

}
function constancia(idalumno,idcarrera){
    window.open ("'.$prof.'listados/pdfs/inscripcion.php?idalumno="+idalumno+"&idcarrera="+idcarrera);
}
function validar_enter(e,funcion,argumentos="") {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
     funcion(argumentos);
   }
};
function eligepais(){
	var idpais = document.getElementById("pais").value;
	document.getElementById("div_depto").innerHTML = "";
	document.getElementById("div_localidad").innerHTML = "";
	cadena = "idpais=" + idpais;
	new ajax ("aj_provincia.php",{postBody: cadena ,update: $("div_provincia")});
};
function eligeprovincia(){
	var idprovincia = document.getElementById("provincia").value;
	document.getElementById("div_depto").innerHTML = "";
	document.getElementById("div_localidad").innerHTML = "";
	cadena = "idprovincia=" + idprovincia;
	new ajax ("aj_depto.php",{postBody: cadena ,update: $("div_depto")});
};
function eligedepto(){
	var iddepto = document.getElementById("departamento").value;
	cadena = "iddepto=" + iddepto;
	new ajax ("aj_localidad.php",{postBody: cadena ,update: $("div_localidad")});
};
function blanco(){
	document.getElementById("div_localidad").innerHTML = "<input type=\"text\" id=\"localidad\" style=\"width:100%;\" placeholder=\"escriba una localidad\">";
};
function buscar(mensaje=""){
	var xdni = document.getElementById("dni").value;
	document.getElementById("cargando").innerHTML = "Cargando...";
	if(xdni!=""){
		cadena = "dni=" + xdni;
		new ajax ("aj_busqueda.php",{postBody: cadena ,update: $("proceso_buscar")});
        if(mensaje!=""){
            pop(0,"Atencion:",mensaje,400,150,"","","'.$prof.'");
        }
	}
	else{
		pop(0,"Atencion: Campo faltante","El campo DNI no puede estar en blanco. Por favor ingrese un DNI valido e intente nuevamente.",400,150,"","","'.$prof.'");
	}
};
function traedni(dni){
	document.getElementById("dni").value = dni;
	buscar();
	cerrar();
};
function error_busqueda(){
	pop(0,"Atencion: No se encuentra el alumno","El alumno no pertenece al establecimiento y sera tratado como un alumno nuevo.",400,150,"","","'.$prof.'");
	datos("","","","","","","","","","","","");
};  

function hecho(){
    pop(0,"Atencion:"," Inscripción realizada con éxito.",400,150,"","","'.$prof.'");
    cargar();
};
function hecho2(){
    pop(0,"Atencion:"," Se agregaron los datos del alumno pero no se puedo completar la inscripcion por falta de comisiones.",400,150,"","","'.$prof.'");
    cargar();
};
function modificado(){
    pop(0,"Atencion:","Se actualizaron los datos con éxito.",400,150,"","","'.$prof.'");
    cargar2();
};
function mal_selec(){
    pop(0,"Atencion:","Debe seleccionar una persona existente para realizar la odificación.",400,150,"","","'.$prof.'");
    cargar();
};

function datos(id,idalumno,apellido,nombre,dni,domicilio,numero,piso,depto,idlocalidad,idprovincia,sexo,dia=\'\',mes=\'\',anio=\'\',nacionalidad,departamento,correo=\'\',telefono=\'\',tipodoc=1){
	document.getElementById("apellido").value = apellido;
	document.getElementById("nombre").value = nombre;
	document.getElementById("sexo").selectedIndex = sexo;
    document.getElementById("element_1_2").value = dia ;
    document.getElementById("element_1_1").value = mes ;
    document.getElementById("element_1_3").value = anio ;
    document.getElementById("tipodni").selectedIndex = tipodoc;
	cadena = "idpais=" + nacionalidad + 
			 "&idprovincia=" + idprovincia + 
			 "&departamento=" + departamento + 
			 "&iddepto=" + departamento + 
			 "&idlocalidad=" + idlocalidad + 
			 "&idalumno=" + idalumno +
			 "&domicilio=" + domicilio +
			 "&numero=" + numero +
			 "&piso=" + piso +
			 "&depto=" + depto +
       "&correo=" + correo +
			 "&telefono=" + telefono +
       "&dni=" + dni +
			 "&nacionalidad=" + nacionalidad;
	new ajax ("aj_datos.php",{postBody: cadena ,update: $("div_datos")});
};

function inscripcion(idalumno,idcarrera,ultima){ 
	pop(1,"Incribir en nueva carrera","",420,170,"reinscripcion.php","idalumno="+idalumno+"&idcarrera="+idcarrera+"&ultima="+ultima,"'.$prof.'");
}
function validar(tipo){
    if(tipo==0){
        error = 0;
        limpiar();
        var xapellido = document.getElementById("apellido").value;
        var xnombre = document.getElementById("nombre").value;
        var xsexo = document.getElementById("sexo").selectedIndex;
        var xtipodni = document.getElementById("tipodni").selectedIndex;
        var xdni = document.getElementById("dni").value;
        var xpais = document.getElementById("pais").selectedIndex;
        var xdomicilio = document.getElementById("direccion").value;
        var xnumero = document.getElementById("direnum").value;
        var xdiredepto = document.getElementById("diredepto").value;
        var xdia = document.getElementById("element_1_2").value;
        var xmes = document.getElementById("element_1_1").value;
        var xanio = document.getElementById("element_1_3").value;
        var xcorreo = document.getElementById("correo").value;
        var xtelefono = document.getElementById("telefono").value;
        var xdirepiso = document.getElementById("direpiso").value;

        var xdia_insc = document.getElementById("dia_insc").value;
        var xmes_insc = document.getElementById("mes_insc").value;

        var xaniolectivo = document.getElementById("anio_lectivo").value;
        

        if(document.getElementById("provincia")){ 
            if(document.getElementById("provincia").selectedIndex==0){
                document.getElementById("provincia").style.border = "1px solid red";
                error=1;
            } 
            xprovincia = document.getElementById("provincia").value;
            if(document.getElementById("departamento")){ 
                if(document.getElementById("departamento").selectedIndex==0){
                    document.getElementById("departamento").style.border = "1px solid red";
                    error=1;
                } 
                xdepartamento = document.getElementById("departamento").value;
                if(document.getElementById("localidad")){ 
                    if(document.getElementById("localidad").selectedIndex==0){
                        document.getElementById("localidad").style.border = "1px solid red";
                        error=1;
                    } 
                    xlocalidad = document.getElementById("localidad").value;
                }
            }
        }
        if(document.getElementById("carrera")){ 
            if(document.getElementById("carrera").selectedIndex==0){
                document.getElementById("carrera").style.border = "1px solid red";
                error=1;
            } 
            xcarrera = document.getElementById("carrera").value;
        }

        if(xapellido==""){ document.getElementById("apellido").style.border = "1px solid red"; error=1; }
        if(xnombre==""){ document.getElementById("nombre").style.border = "1px solid red"; error=1; }
        if(xsexo==0){ document.getElementById("sexo").style.border = "1px solid red"; error=1; }
        if(xtipodni==0){ document.getElementById("tipodni").style.border = "1px solid red"; error=1; }	
        if(xdni==""){ document.getElementById("dni").style.border = "1px solid red"; error=1; }
        if(xpais==0){ document.getElementById("pais").style.border = "1px solid red"; error=1; }
        if(xdomicilio==""){ document.getElementById("direccion").style.border = "1px solid red"; error=1; }
        if(xnumero==""){ document.getElementById("direnum").style.border = "1px solid red"; error=1; }
        if(xdia==""){ document.getElementById("element_1_2").style.border = "1px solid red"; error=1; }
        if(xmes==""){ document.getElementById("element_1_1").style.border = "1px solid red"; error=1; }
        if(xanio==""){ document.getElementById("element_1_3").style.border = "1px solid red"; error=1; }

        if(document.getElementById("9").checked){
          var xcue = document.getElementById("vcue").value;
          var xanexo = document.getElementById("vanexo").value;
          var zanio = document.getElementById("anio_pase").value;

          if (xcue == "" || xanexo =="" || zanio == ""){
            document.getElementById("bus_escuela").style.border = "1px solid red";
            error = 1;
          }
          bpase = 1;
        }
        else bpase = 0;

        if(error==1){
            pop(0,"Atencion: Campos faltantes","Algunos campos son requeridos y no se proporcionaron para realizar la inscripcion. Por favor revise los campos en rojo e intente nuevamente.",400,150,"","","'.$prof.'");
        }
        else{
            cadena = "apellido="+xapellido+
                     "&nombre="+xnombre+
                     "&sexo="+xsexo+
                     "&tipodni="+xtipodni+
                     "&dni="+xdni+
                     "&pais="+xpais+
                     "&domicilio="+xdomicilio+
                     "&numero="+xnumero+
                     "&piso="+xdirepiso+
                     "&dia="+xdia+
                     "&mes="+xmes+
                     "&anio="+xanio+
                     "&provincia="+xprovincia+
                     "&departamento="+xdepartamento+
                     "&localidad="+xlocalidad+
                     "&carrera="+xcarrera+
                     "&diredepto="+xdiredepto+
                     "&correo="+xcorreo+
                     "&telefono="+xtelefono+
                     "&aniolectivo="+xaniolectivo+
                     "&dia_insc="+xdia_insc+
                     "&mes_insc="+xmes_insc+
                     "&tipo="+tipo;

            if(bpase) cadena = cadena +"&cue="+xcue+"&anexo="+xanexo+"&zanio="+zanio;

            new ajax ("aj_inscribir.php",{postBody: cadena ,update: $("estado")});
        }
    }
    else{
        var xdni = document.getElementById("dni").value;
        var xcarrera = document.getElementById("inscarreras").value;
        var xdia_insc = document.getElementById("dia_insc").value;
        var xmes_insc = document.getElementById("mes_insc").value;

        var xaniolectivo = document.getElementById("anio_lectivo").value;
        cadena = "dni="+xdni+
                      "&carrera="+xcarrera+
                      "&aniolectivo="+xaniolectivo+
                      "&dia_insc="+xdia_insc+
                      "&mes_insc="+xmes_insc+
                      "&tipo="+tipo;
            new ajax ("aj_inscribir.php",{postBody: cadena ,update: $("estado")});
            cerrar();
    }
};
function validar_modifica(){
	error = 0;
    limpiar();
    var xapellido = document.getElementById("apellido").value;
    var xnombre = document.getElementById("nombre").value;
    var xsexo = document.getElementById("sexo").selectedIndex;
    var xtipodni = document.getElementById("tipodni").selectedIndex;
    var xdni = document.getElementById("dni").value;
    var xpais = document.getElementById("pais").selectedIndex;
    var xdomicilio = document.getElementById("direccion").value;
    var xnumero = document.getElementById("direnum").value;
    var xdiredepto = document.getElementById("diredepto").value;
    var xdia = document.getElementById("element_1_2").value;
    var xmes = document.getElementById("element_1_1").value;
    var xanio = document.getElementById("element_1_3").value;
    var xcorreo = document.getElementById("correo").value;
    var xtelefono = document.getElementById("telefono").value;
    var xdirepiso = document.getElementById("direpiso").value;

    var xdocu = document.getElementsByName("docu");
    var arreglo_docu = [];

    for(i=0;i<xdocu.length;i++){
        if(xdocu[i].checked) arreglo_docu.push(xdocu[i].id);
    }
   
    if(document.getElementById("provincia")){ 
        if(document.getElementById("provincia").selectedIndex==0){
            document.getElementById("provincia").style.border = "1px solid red";
            error=1;
        } 
        xprovincia = document.getElementById("provincia").value;
        if(document.getElementById("departamento")){ 
            if(document.getElementById("departamento").selectedIndex==0){
                document.getElementById("departamento").style.border = "1px solid red";
                error=1;
            } 
            xdepartamento = document.getElementById("departamento").value;
            if(document.getElementById("localidad")){ 
                if(document.getElementById("localidad").selectedIndex==0){
                    document.getElementById("localidad").style.border = "1px solid red";
                    error=1;
                } 
                xlocalidad = document.getElementById("localidad").value;
            }
        }
    }

    if(xapellido==""){ document.getElementById("apellido").style.border = "1px solid red"; error=1; }
    if(xnombre==""){ document.getElementById("nombre").style.border = "1px solid red"; error=1; }
    if(xsexo==0){ document.getElementById("sexo").style.border = "1px solid red"; error=1; }
    if(xtipodni==0){ document.getElementById("tipodni").style.border = "1px solid red"; error=1; }	
    if(xdni==""){ document.getElementById("dni").style.border = "1px solid red"; error=1; }
    if(xpais==0){ document.getElementById("pais").style.border = "1px solid red"; error=1; }
    if(xdomicilio==""){ document.getElementById("direccion").style.border = "1px solid red"; error=1; }
    if(xnumero==""){ document.getElementById("direnum").style.border = "1px solid red"; error=1; }
    if(xdia==""){ document.getElementById("element_1_2").style.border = "1px solid red"; error=1; }
    if(xmes==""){ document.getElementById("element_1_1").style.border = "1px solid red"; error=1; }
    if(xanio==""){ document.getElementById("element_1_3").style.border = "1px solid red"; error=1; }

    if(error==1){
        pop(0,"Atencion: Campos faltantes","Algunos campos son requeridos y no se proporcionaron para realizar la inscripcion. Por favor revise los campos en rojo e intente nuevamente.",400,150,"","","'.$prof.'");
    }
    else{
        cadena = "apellido="+xapellido+
                 "&nombre="+xnombre+
                 "&sexo="+xsexo+
                 "&tipodni="+xtipodni+
                 "&dni="+xdni+
                 "&pais="+xpais+
                 "&domicilio="+xdomicilio+
                 "&numero="+xnumero+
                 "&piso="+xdirepiso+
                 "&dia="+xdia+
                 "&mes="+xmes+
                 "&anio="+xanio+
                 "&provincia="+xprovincia+
                 "&departamento="+xdepartamento+
                 "&localidad="+xlocalidad+
                 "&diredepto="+xdiredepto+
                 "&correo="+xcorreo+
                 "&arreglo_docu="+arreglo_docu+
                 "&telefono="+xtelefono
        new ajax ("aj_modificar_datos.php",{postBody: cadena ,update: $("estado")});
    }
}
function validar_modifica2(mensaje){
    error = 0;
    limpiar();
    var xapellido = document.getElementById("apellido").value;
    var xnombre = document.getElementById("nombre").value;
    var xsexo = document.getElementById("sexo").selectedIndex;
    var xtipodni = document.getElementById("tipodni").selectedIndex;
    var xdni = document.getElementById("dni").value;
    var xpais = document.getElementById("pais").selectedIndex;
    var xdomicilio = document.getElementById("direccion").value;
    var xnumero = document.getElementById("direnum").value;
    var xdiredepto = document.getElementById("diredepto").value;
    var xdia = document.getElementById("element_1_2").value;
    var xmes = document.getElementById("element_1_1").value;
    var xanio = document.getElementById("element_1_3").value;
    var xcorreo = document.getElementById("correo").value;
    var xtelefono = document.getElementById("telefono").value;
    var xdirepiso = document.getElementById("direpiso").value;

    var xdocu = document.getElementsByName("docu");
    var arreglo_docu = [];

    for(i=0;i<xdocu.length;i++){
        if(xdocu[i].checked) arreglo_docu.push(xdocu[i].id);
    }
   
    if(document.getElementById("provincia")){ 
        if(document.getElementById("provincia").selectedIndex==0){
            document.getElementById("provincia").style.border = "1px solid red";
            error=1;
        } 
        xprovincia = document.getElementById("provincia").value;
        if(document.getElementById("departamento")){ 
            if(document.getElementById("departamento").selectedIndex==0){
                document.getElementById("departamento").style.border = "1px solid red";
                error=1;
            } 
            xdepartamento = document.getElementById("departamento").value;
            if(document.getElementById("localidad")){ 
                if(document.getElementById("localidad").selectedIndex==0){
                    document.getElementById("localidad").style.border = "1px solid red";
                    error=1;
                } 
                xlocalidad = document.getElementById("localidad").value;
            }
        }
    }

    if(xapellido==""){ document.getElementById("apellido").style.border = "1px solid red"; error=1; }
    if(xnombre==""){ document.getElementById("nombre").style.border = "1px solid red"; error=1; }
    if(xsexo==0){ document.getElementById("sexo").style.border = "1px solid red"; error=1; }
    if(xtipodni==0){ document.getElementById("tipodni").style.border = "1px solid red"; error=1; }  
    if(xdni==""){ document.getElementById("dni").style.border = "1px solid red"; error=1; }
    if(xpais==0){ document.getElementById("pais").style.border = "1px solid red"; error=1; }
    if(xdomicilio==""){ document.getElementById("direccion").style.border = "1px solid red"; error=1; }
    if(xnumero==""){ document.getElementById("direnum").style.border = "1px solid red"; error=1; }
    if(xdia==""){ document.getElementById("element_1_2").style.border = "1px solid red"; error=1; }
    if(xmes==""){ document.getElementById("element_1_1").style.border = "1px solid red"; error=1; }
    if(xanio==""){ document.getElementById("element_1_3").style.border = "1px solid red"; error=1; }

    if(error==1){
        pop(0,"Atencion: Campos faltantes","Algunos campos son requeridos y no se proporcionaron para realizar la inscripcion. Por favor revise los campos en rojo e intente nuevamente.",400,150,"","","'.$prof.'");
    }
    else{
        cadena = "apellido="+xapellido+
                 "&nombre="+xnombre+
                 "&sexo="+xsexo+
                 "&tipodni="+xtipodni+
                 "&dni="+xdni+
                 "&pais="+xpais+
                 "&domicilio="+xdomicilio+
                 "&numero="+xnumero+
                 "&piso="+xdirepiso+
                 "&dia="+xdia+
                 "&mes="+xmes+
                 "&anio="+xanio+
                 "&provincia="+xprovincia+
                 "&departamento="+xdepartamento+
                 "&localidad="+xlocalidad+
                 "&diredepto="+xdiredepto+
                 "&correo="+xcorreo+
                 "&arreglo_docu="+arreglo_docu+
                 "&mensaje="+mensaje+
                 "&telefono="+xtelefono
        new ajax ("aj_modificar_datos.php",{postBody: cadena ,update: $("estado")});
    }
}
function limpiar(){
	document.getElementById("apellido").style.border = "1px solid rgba(0,0,0,.2)";
	document.getElementById("nombre").style.border = "1px solid rgba(0,0,0,.2)";
	document.getElementById("sexo").style.border = "1px solid rgba(0,0,0,.2)";
	document.getElementById("tipodni").style.border = "1px solid rgba(0,0,0,.2)";
	document.getElementById("dni").style.border = "1px solid rgba(0,0,0,.2)";
	document.getElementById("pais").style.border = "1px solid rgba(0,0,0,.2)";
	document.getElementById("direccion").style.border = "1px solid rgba(0,0,0,.2)";
	document.getElementById("direnum").style.border = "1px solid rgba(0,0,0,.2)";
	document.getElementById("element_1_2").style.border = "1px solid rgba(0,0,0,.2)";
	document.getElementById("element_1_1").style.border = "1px solid rgba(0,0,0,.2)";
	document.getElementById("element_1_3").style.border = "1px solid rgba(0,0,0,.2)";
	if(document.getElementById("provincia")){ 
		document.getElementById("provincia").style.border = "1px solid rgba(0,0,0,.2)";
	}
	if(document.getElementById("departamento")){ 
		document.getElementById("departamento").style.border = "1px solid rgba(0,0,0,.2)";
	}
	if(document.getElementById("localidad")){ 
		document.getElementById("localidad").style.border = "1px solid rgba(0,0,0,.2)";
	}
	if(document.getElementById("carrera")){ 
		document.getElementById("carrera").style.border = "1px solid rgba(0,0,0,.2)";
	}
};
function buscar_escuela(){
  var clave = document.getElementById("bus_escuela").value;

  if(clave.length>0) document.getElementById("div_buscar").style.display="block";
  else document.getElementById("div_buscar").style.display="none";

  cadena = "clave="+clave;
  new ajax ("aj_escuelas.php",{postBody: cadena ,update: $("div_buscar")});
};
function buscar_escuela_off(){
  setTimeout(function(){ document.getElementById("div_buscar").style.display="none"; }, 300);
};
function traer_escuela(nombre,cue,anexo){
  document.getElementById("bus_escuela").value = nombre;
  document.getElementById("vcue").value = cue;
  document.getElementById("vanexo").value = anexo;
};
function agregar_escuela(cue,anexo){
  var clave = document.getElementById("bus_escuela").value;
  pop(1,"Agregar nueva escuela","",420,200,"aj_nueva_escuela.php","clave="+clave,"'.$prof.'");
  document.getElementById("vcue").value = cue;
  document.getElementById("vanexo").value = anexo;

};
function agregar_nva_esc(){
  var xnombre = document.getElementById("nnombre").value;
  var xcue = document.getElementById("ncue").value;
  var xanexo = document.getElementById("nanexo").value;

  cadena = "nombre="+xnombre+"&cue="+xcue+"&anexo="+xanexo;
  new ajax ("aj_insertar_escuela.php",{postBody: cadena ,update: $("div_proc_esc")});
};
function yaexiste(){
  pop(0,"Atencion:","El establecimiento ya existe en el listado. Verifique nuevamente.",400,150,"","","'.$prof.'");
}
function esc_insertada(){
  document.getElementById("bus_escuela").value = document.getElementById("nnombre").value;
  document.getElementById("vcue").value = document.getElementById("ncue").value;
  document.getElementById("vanexo").value = document.getElementById("nanexo").value;
  pop(0,"Atencion:","El establecimiento fue agregado con éxito.",400,150,"","","'.$prof.'");
}
function chek_pase(id){
  if(id==9 && document.getElementById(id).checked){
    document.getElementById("div_pase").style.opacity = 1;
    document.getElementById("bus_escuela").disabled = false;
    document.getElementById("anio_pase").disabled = false;
  } 
  if(id==9 && !document.getElementById(id).checked){
    document.getElementById("div_pase").style.opacity = 0.3;
    document.getElementById("bus_escuela").disabled = true;
    document.getElementById("anio_pase").disabled = true;
  }
};
function activar(cue,anexo,nombre,anio){
    document.getElementById("div_pase").style.opacity = 1;
    document.getElementById("bus_escuela").disabled = false;
    document.getElementById("bus_escuela").value = nombre;
    document.getElementById("anio_pase").disabled = false;
    document.getElementById("anio_pase").selectedIndex = anio-1;
};
</script>
';
$html.= '<h1 style="background-color:'.$color_suave.';">Inscripción / Ficha inscripción</h1>';
include('../menu_inscripciones.php');
$html.= '

<div class="form">
<div class="triangulo" style="border-top-color:'.$color.'; margin-top:-20px; margin-left:35px; position:fixed;"></div><br>
<b>Datos Personales:</b>
<table border=0>
	<tr><td>Tipo doc.:</td><td><select id="tipodni" style="width:100%;">
								<option value"0">Seleccionar</option>
								<option value"1" selected>DNI</option>
								<option value"2">LE</option>
								<option value"3">LC</option>
								<option value"4">PAS</option>
								<option value"5">CF</option>
								<option value"6">CPT</option>
							   </select></td>
		<td>Nro: </td><td><table border=0 width=100%><tr><td style="width:130px;"><input type="text" id="dni" value ="28223817" onBlur="buscar()" onkeypress="validar_enter(event,buscar)" style="width:120px; text-align:center; font-size:18px; padding-right:3px;" /></td><td><a href="#" onclick="buscar()" class="btn">Buscar</a> <a href="#" 
		onclick="cuadro_busqueda(\'Buscar alumno por apellido\',\'select dni,apellido,nombre from personas\',\'apellido\',\'traedni\',0,\''.$prof.'\')" class="btn">Por Apellido </a></td><td><div id="proceso_buscar" style="width:20px;"></div></td></tr></table></td>
		
	</tr>
	<tr><td>Apellido: </td><td><input type="text" id="apellido" style="width:100%;"/></td>
	<td>Nombre: </td><td><input type="text" id="nombre" style="width:100%;" /></td>
    
	</tr>
  <tr>
  <td>Nac.: </td><td>
			<input type="text" id="element_1_2" size="1" maxlength="2" placeholder="dd" value="'.$dia.'">
			<input type="text" id="element_1_1" size="1" maxlength="2" placeholder="mm" value="'.$mes.'">
			<input type="text" id="element_1_3" size="2" maxlength="4" placeholder="aaaa" value="'.$anio.'">
			<img id="cal_img_1" class="datepicker" src="'.$prof.'imagenes/calendario.png" title="Click para seleccionar una fecha">	
		<script type="text/javascript">
			Calendar.setup({
			inputField	 : "element_1_3",
			baseField    : "element_1",
			displayArea  : "calendar_1",
			button		 : "cal_img_1",
			ifFormat	 : "%B %e, %Y",
			onSelect	 : selectDate
			});
		</script></td><td>Sexo: </td><td><select id="sexo" style="width:100%;">
                                <option value"0">Seleccionar</option>
                                <option value"1">Masculino</option>
                                <option value"2">Femenino</option>
                               </select></td>
  </tr>
</table><br><hr><br>

<div id="div_datos"></div>

<input type="hidden" id="var_nacionalidad">
<input type="hidden" id="var_idprovincia">
<input type="hidden" id="var_departamento">
<input type="hidden" id="var_idlocalidad">
<input type="hidden" id="var_idalumno">
';
$html.= '<iframe onload="cargar()" style="display:none;"></iframe>';

include($prof."template.php");
?>
