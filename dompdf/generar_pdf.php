<?php 
session_start();
$cfilename="mi_pdf.pdf";
# Cargamos la librería dompdf.
require_once 'dompdf_config.inc.php';
$cXLS="hola bebe";
$mipdf = new DOMPDF();
$mipdf ->set_paper("A4", "landscape");
$mipdf ->load_html(utf8_decode($cXLS));
$mipdf ->render();
$mipdf ->stream($cfilename);
?>