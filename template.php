<html>
<head>
<title>SisGEN</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="<?php echo $prof;?>imagenes/favicon.png" />
<link href="<?php echo $prof;?>css/estilo.css?version=4.5" rel="stylesheet" type="text/css" media="all"/>
<link href="<?php echo $prof;?>css/botonera.css?version=1.4" rel="stylesheet" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php echo $prof;?>css/calendario.css" media="all">
<script type="text/javascript" src="<?php echo $prof;?>scripts/calendario.js" media="all"></script>
<script src="<?php echo $prof;?>scripts/pops.js?version=3.3" type="text/javascript" media="all"></script>
<?PHP echo $java; ?>
<?PHP 
echo '
<script language="JavaScript" type="text/JavaScript">
function problema(){
  pop(1,"Reportar un problema","",500,400,"'.$prof.'soporte.php","ruta='.$_SERVER['REQUEST_URI'].'","'.$prof.'");
};
function guardar_error(){
  var descripcion = document.getElementById("descripcion").value;
  var ruta = document.getElementById("ruta").value;
  new ajax ("'.$prof.'aj_insertar_reporte_error.php", {postBody:  "descripcion="+descripcion+"&ruta="+ruta,update: $("estado")});
}

function exportar_error(){
  cerrar();	
  window.open("'.$prof.'reporte_error.php");
}

function finalizar_informe_error(){
  cerrar();
  pop(0,"Atencion:","El informe de error se guardó exitosamente",400,150,"","","'.$prof.'");
} 
function cerrar(){
  document.getElementById("cargando").innerHTML = "";
  document.getElementById("mensaje").style.display="none";
};
</script>';
?>
</head>
<body onload="cargar()">
<table border=0 width="100%" height="100%" cellpadding="0" cellspacing="0">
  <tr style="height: 30px;"><td colspan=2><div id="botonera">    
    <?PHP echo $botones;?>
    <div id="seleccionado" style="color:white; -webkit-border-radius: 20px 0 0 20px; border-radius: 20px 0 0 20px; float: right; width: auto; height: 100%; padding-left: 15px;"><span style="float: right; padding-left: 10px;"></span><b><font style="color:white;"><?PHP echo $opcionmenu;?></font></b></div>
  </div></td></tr>
  <tr><td style="width: 40px;" valign="top">
    <div style="position: fixed; top: 50%; margin-top:-100px; height: 100%; z-index: 999;">
      <ul class="menu">
        <a href="<?PHP echo $prof;?>datos/opciones.php"><li style="border-right: 5px solid rgb(176, 66, 244);">Datos<span style="float:right;"><img src="<?PHP echo $prof;?>imagenes/carpeta.png" style="width:25px; margin-top:6px; margin-right: 6px;"></span></li></a>
        <a href="<?PHP echo $prof;?>datosnormalizados/opciones.php"><li style="border-right: 5px solid rgb(54, 135, 29);">Datos normalizados<span style="float:right;"><img src="<?PHP echo $prof;?>imagenes/engranaje.png" style="width:25px; margin-top:6px; margin-right: 6px;"></span></li></a>
        <a href="<?PHP echo $prof;?>movimientos/opciones.php"><li style="border-right: 5px solid rgb(30, 151, 204);">Movimiento de alumnos<span style="float:right;"><img src="<?PHP echo $prof;?>imagenes/flechas.png" style="width:23px; margin-top:7px; margin-right: 7px;"></span></li></a>
        <a href="<?PHP echo $prof;?>listados/opciones.php"><li style="border-right: 5px solid rgb(226, 226, 45);">Listados<span style="float:right;"><img src="<?PHP echo $prof;?>imagenes/lista.png" style="width:25px; margin-top:8px; margin-right: 6px;"></span></li></a>
        <a href="<?PHP echo $prof;?>constancias/opciones.php"><li style="border-right: 5px solid rgb(226, 60, 44);">Constancias<span style="float:right;"><img src="<?PHP echo $prof;?>imagenes/certificado.png" style="width:25px; margin-top:9px; margin-right: 6px;"></span></li></a>
      </ul>
    </div>
  </td><td>
    <div id="cuerpo">
      <div style="border:0px solid red; padding: 0px 10px;">
      <?PHP echo '<table width=100% ><tr><td><img src="'.$prof.'imagenes/baner.png"></td><td align=right valign=top><br><a class="link" href="#" onclick="problema()"><img src="'.$prof.'imagenes/alerta.png" style="width:10px; vertical-align:-1px;"/> Reportar/Exportar un problema</a><br><br><a href="'.$prof.'" class="btn" >Salir</a></td></tr></table>';?>
     <?PHP echo $html;?>
    </div>
    </div>
  </td></tr>
  <tr style="height: 30px;"><td colspan=2>
    <div id="pie"><div style="margin-left:5px; color: white; font-size: 12px; padding-top: 3px;">
      <table cellspacing=0 cellpadding=0 width="100%" border=0 style="margin-top: 3px;"><tr><td style="color:white; width: 70px;">Estado:</td><td><div id="estado" style="color:white;"></div></td><td align=right><div id="cargando" style="color:white;"></div></td></tr></table>
  </div></td></tr>
</table>
<div id="ventana"></div>
<div id="mensaje" style="width: 100%; height: 100%; z-index: 9999; position: fixed; left:0; top: 0; background-color: rgba(0,0,0,.7); display: none;"></div>
</body>
</html>