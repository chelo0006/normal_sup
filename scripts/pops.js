function pop(tipo,titulo,mensaje,ancho,alto,ruta,parametros,prof){
	margen_left = ancho/2;
	margen_top = (alto/2)+30;
	switch(tipo){
		case 1:
			document.getElementById("mensaje").style.display="block";
			document.getElementById("mensaje").innerHTML = "<style>.anima {-webkit-box-shadow: 1px 1px 10px 2px rgba(0,0,0,.5); border:1px solid rgba(0,0,0,1); box-shadow: 1px 1px 10px 2px rgba(0,0,0,.3); position:absolute; left:50%; top: 50%; margin-left: -"+margen_left+"px; margin-top: -"+margen_top+"px; background-color:white; -webkit-border-radius: 0px 5px 5px 5px; border-radius: 5px 5px 5px 5px; width:"+ancho+"px; height:"+alto+"px;-webkit-animation-name: ventana; -webkit-animation-duration: 0.3s; animation-name: ventana; animation-duration: 0.3s;} @-webkit-keyframes ventana { 0% {letf:0%; margin-top: -"+alto+"px; opacity:0; } 100% {width:"+ancho+"px; height:"+alto+"px; opacity:1;}} @keyframes ventana {0% {margin-top: -"+alto+"px; opacity:0;}100% {width:"+ancho+"px; height:"+alto+"px; opacity:1;}}</style><div class=\"anima\"><table border=0 width=100% height=100% cellspacing=0 cellpadding=0 style=\"margin-left:0px;\"><tr style=\"height:25px; background-color:rgb(51,51,51);\"><td style=\"color:rgba(255,255,255,.8); text-align:left;\"><table><tr><td><img src=\""+prof+"imagenes/favicon.png\" style=\"width:25px; margin-right: 5px;  margin-left:5px;\"></td><td style=\"color:rgba(255,255,255,.9);\">"+titulo+"</td></tr></table></td></tr><tr><td align=center valign=top><div id=\"divmensaje\"></div></td></tr></table></div>";
			document.getElementById("divmensaje").innerHTML = "<div class='lds-ellipsis'><div></div><div></div><div></div><div></div></div>";
			new ajax (ruta,{postBody: parametros ,update: $("divmensaje")});
		break;
		case 0:
			document.getElementById("mensaje").style.display="block";
			document.getElementById("mensaje").innerHTML = "<style>.anima {-webkit-box-shadow: 1px 1px 10px 2px rgba(0,0,0,.5); border:1px solid rgba(0,0,0,1); box-shadow: 1px 1px 10px 2px rgba(0,0,0,.3); position:absolute; left:50%; top: 50%; margin-left: -"+margen_left+"px; margin-top: -"+margen_top+"px; background-color:white; -webkit-border-radius: 5px 5px 5px 5px; border-radius: 5px 5px 5px 5px; width:"+ancho+"px; height:"+alto+"px;-webkit-animation-name: ventana; -webkit-animation-duration: 0.3s; animation-name: ventana; animation-duration: 0.3s;} @-webkit-keyframes ventana { 0% {letf:0%; margin-top: -"+alto+"px; opacity:0; } 100% {width:"+ancho+"px; height:"+alto+"px; opacity:1;}} @keyframes ventana {0% {margin-top: -"+alto+"px; opacity:0;}100% {width:"+ancho+"px; height:"+alto+"px; opacity:1;}}</style><div class=\"anima\"><table width=100% height=100% cellspacing=0 cellpadding=0 style=\"margin-left:0px;\"><tr style=\"height:25px; background-color:rgb(51,51,51);\"><td style=\"color:rgba(255,255,255,.8); text-align:left;\"><table ><tr><td><img src=\""+prof+"imagenes/favicon.png\" style=\"width:25px; margin-right: 5px;  margin-left:5px;\"></td><td style=\"color:rgba(255,255,255,.9);\">"+titulo+"</td></tr></table></td></tr><tr><td align=center valign=middle style=\"padding:5px;\">"+mensaje+"<br><br><a class=\"btn\" onclick=\"cerrar();\" style=\"text-align:center;\">Cerrar</a></td></tr></table></div>";
		break;
	}
}
function busqueda_grilla(consulta,parametro,funcion,campo,prof){
	var xclave = document.getElementById("clave").value;
	document.getElementById("div_grilla").innerHTML = "<center><div class='lds-ellipsis'><div></div><div></div><div></div><div></div></div></center>";
	if(xclave == "") document.getElementById("clave").style.border = "1px solid rgb(200,0,0)";	
	else{
		cadena = "clave="+xclave+"&consulta="+consulta+"&parametro="+parametro+"&funcion="+funcion+"&campo="+campo;
		new ajax (prof+"funciones/grilla.php",{postBody: cadena ,update: $("div_grilla")});
	}
};
function cuadro_busqueda(titulo,consulta,parametro,funcion,campo,prof){
	pop(1,titulo,"",600,500,prof+"/funciones/busqueda.php","consulta="+consulta+"&parametro="+parametro+"&funcion="+funcion+"&campo="+campo+"&prof="+prof,prof);
};
function validar_enter(e,funcion,argumentos="") {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
     funcion(argumentos);
   }
};

