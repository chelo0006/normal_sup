<?PHP
$opcionmenu = 'Datos';
$inicio = '';
$titulo ='';
$color = 'rgb(176, 66, 244)';
$color_suave = 'rgba(176, 66, 244,.2)';
echo '<style>
#seleccionado{
	background-color: '.$color.';
	text-shadow: 1px 1px 2px #000000;
}
.nav li a:hover {
	background-color: '.$color.';
}
.btnmenu:hover{
	background-color:'.$color_suave.';
}
.btn:hover {
  background-color: '.$color.';
  text-decoration: none;
  cursor: pointer;
}
::-webkit-scrollbar {
    width: 10px;
    border:1px solid rgba(0,0,0,.3);
    border-radius:0 0 5px 0;
}
::-webkit-scrollbar-track {
    background: rgba(0,0,0,.05); 
    border-radius:0 0 5px 0;
}
 
::-webkit-scrollbar-thumb {
    background: '.$color_suave.';
    border-radius:0 0 5px 0;
    -webkit-box-shadow: 1px 0 5px 1px rgba(0,0,0,.3);
    box-shadow: 1px 0 5px 1px rgba(0,0,0,.3);
}

::-webkit-scrollbar-thumb:hover {
  cursor: pointer;
  background: '.$color.';  
  border-radius:0 0 5px 0;
  -webkit-box-shadow:1px 0 5px 1px rgba(0,0,0,.3);
  box-shadow:1px 0 5px 1px rgba(0,0,0,.3);
}
.tabla tr:nth-child(odd):hover, .tabla tr:nth-child(even):hover { 
    background-color: rgba(51,51,51,.2);
    color:white;
    -webkit-box-shadow: inset 1px 1px 35px 6px '.$color_suave.';
    -moz-box-shadow: inset 1px 1px 35px 6px '.$color_suave.';
    box-shadow: inset 1px 1px 35px 6px '.$color_suave.';
    cursor: pointer; 
}
</style>';

$botones = '<ul class="nav">
				<li><a href="'.$prof.'datos/inscripcion/inscripcion/inscripciones.php">Inscripcion</a></li>
				<li><a href="'.$prof.'datos/alumnos/notascursado/notas.php">Alumnos</a></li>
				<li><a>Administracion</a>
				  <ul>
            <li><a href="'.$prof.'datos/administracion/usuarios.php">Usuarios</a></li>
     			</ul>
				</li>
			</ul>';
			
			
?>