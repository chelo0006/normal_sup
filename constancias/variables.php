<?PHP
$opcionmenu = 'Constancias';
$inicio = '';
$prof = '../';
$titulo ='';
$color = 'rgb(226, 60, 44)';
echo '<style>
#seleccionado{
	background-color: '.$color.';
	text-shadow: 1px 1px 2px #000000;
}
.nav li a:hover {
	background-color: '.$color.';
}
</style>';


$botones = '<ul class="nav">
				<li ><a href="">Alumno regular</a></li>
				<li><a href="">De estudios</a></li>
				<li><a href="">Ficha analitica</a></li>
				<li><a href="">De titulo</a></li>
				<li><a href="">Postitulo</a>
					<ul>
					<li><a href="">Un modulo</a></li>
					<li><a href="">Todos los modulos</a></li>
					</ul></li>
			</ul>';
?>