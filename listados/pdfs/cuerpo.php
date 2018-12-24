<?php
$radio = '5px';
$cuerpo.='<div style="border:1px solid black; padding:2px; border-radius: '.$radio.' '.$radio.' '.$radio.' '.$radio.';">
	<table border=0 style="border:1px solid black; border-radius:'.$radio.' '.$radio.' 0px 0px;" width=100%>
		<tr>
			<td rowspan=2 style="padding:5px; width:100px;"><img src="monograma2.jpg" width=100/></td>
			<td rowspan=2>Esc. Normal Superior en Lenguas Vivas<br>Juan Bautista Alberdi<br>Muñecas 219 - San Miguel de Tucumán</td>
			<td valign=top align=right>Pagina 1</td>
		</tr>
		<tr>
			<td align=right valign=bottom><b>Fecha de emisión </b>'.date('d/m/Y').'</td>
		</tr>

	</table> 
	<div style="border:1px solid black; text-align:center; margin-top:3px;">
	<b>'.strtoupper($titulo_listado).'</b>
	</div>
		<style>
	*{
		font-size: 12px;
	}
	.detalle td{
		border:1px solid rgb(200,200,200);
	}
	</style><br> 
	<b>'.$titulos.'</b><br><br>
	';

$cuerpo.= $html.'<br>
El listado esta sujeto a modificaciones futuras.
<div style="border:1px solid black; text-align:center; margin-top:3px; border-radius: 0px 0px '.$radio.' '.$radio.';">
	<b>'.strtoupper($titulo_listado).'</b>
	</div>';

?>