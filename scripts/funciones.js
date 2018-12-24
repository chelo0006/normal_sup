function imprimir_mensage(msg,prof){
        var midiv = document.createElement("div");
		midiv.setAttribute('id','mensage'); //importante la css #mensage para que funcione correctamente el mensage
        document.body.appendChild(midiv); 
        new ajax (prof + 'mensage.php',{postBody: "msg=" + msg ,update: $('mensage')});
};

function cerrar_mensages(){
        var midiv = document.getElementById('mensage');
        document.body.removeChild(midiv);
}; 
function ver_listado(prof){
        var midiv = document.createElement("div");
		midiv.setAttribute('id','mensage'); 
        document.body.appendChild(midiv); 
        new ajax (prof + 'listados/lista_alumnos.php',{postBody: "msg=sarasa" ,update: $('mensage')});
};
function materias_adeudadas(prof,dni){
        var midiv = document.createElement("div");
		midiv.setAttribute('id','mensage'); 
        document.body.appendChild(midiv); 
        new ajax (prof + 'listados/materias_adeudadas.php',{postBody: "dni=" + dni ,update: $('mensage')});
};
