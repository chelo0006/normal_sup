<?PHP
$opcionmenu = 'Datos';
$inicio = '';
$prof = '../';
$titulo ='';
$color = 'rgb(176, 66, 244)';
echo '<style>
#seleccionado{
	background-color: '.$color.';
	text-shadow: 1px 1px 2px #000000;
}
.nav li a:hover {
	background-color: '.$color.';
}
.btnmenu:hover{
	color: '.$color.';
	background-color:rgba(0,0,0,.05);
}
.btn:hover {
  background-color: '.$color.';
  text-decoration: none;
  cursor: pointer;
}
</style>';


$botones = '<ul class="nav">
				<li ><a href="inscripciones.php">Inscripcion</a></li>
				<li><a href="">Movimientos en bloque</a>
					<ul>
						<li><a href="">Ficha inscripcion por bloque</a>
							<ul>
								<li><a href="">inscribir por alumno carrera y curso</a></li>
								<li><a href="">Marcar o desmarcar inscripto</a></li>
							</ul>
						</li>
						<li><a href="">Cambiar cuat. por esp. curricular y año</a></li>
					</ul>
				</li>
				<li><a href="">Censo alumnos</a></li>
				<li><a href="">Profesores y comision</a></li>
			</ul>';
?>