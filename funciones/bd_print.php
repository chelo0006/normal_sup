<?php
$html= '<style>
.tabla{
    width: 100%;  
    border: 1px solid rgb(0,0,0,.3);
    border-collapse: 0px;
    border-spacing: 0px;
    border-radius: 0px 0px 8px 8px;
    -moz-border-radius: 0px 0px 0px 8px;
    -webkit-border-radius: 0px 0px 0px 8px;

}
.tabla tr { 
    -webkit-box-shadow: inset 1px 1px 35px 6px rgba(0,0,0,0.05);
    -moz-box-shadow: inset 1px 1px 35px 6px rgba(0,0,0,0.05);
    box-shadow: inset 1px 1px 35px 6px rgba(0,0,0,0.05);
}
.tabla th{
    color:black;
    background-color: rgb(200,200,200);  
}
.tabla td, th{
    padding: 5px;    
    color:black;
    font-size: 10px;
    border-right:1px solid rgb(180,180,180);
    border-bottom:1px solid rgb(180,180,180);
}
</style>';

/***************************************************************************************************************************************/
function dbConectar(){
    $db = pg_connect("host=localhost port=5432 dbname=normal_sup user=postgres password=marcelo6") or die('error en la coneccion, espere un momento y vuelva a intentar');
    return $db;
}
function dbConsultar($bd,$consulta){
    return pg_query($bd, $consulta);
}
function dbcampo($clt,$campo){
    $indice = pg_field_num($clt, $campo);
    return $indice;
}
function dbfila($clt){
    return pg_fetch_row($clt);
}
function dbCount($clt){
    return pg_num_rows($clt);
}
function dbRewin($clt){
    pg_result_seek($clt, 0);
}
/**************************************************************************************************************************************/
?>