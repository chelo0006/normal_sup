<style>
.tabla{
    width: 100%;  
    border: 1px solid rgba(0,0,0,.3);
    border-collapse: 0px;
    border-spacing: 0px;
    border-radius: 0px 0px 8px 8px;
    -moz-border-radius: 0px 0px 0px 8px;
    -webkit-border-radius: 0px 0px 0px 8px;
    
}
.tabla tr:nth-child(even) { 
    background-color: rgba(0,0,0,.01); 
    -webkit-box-shadow: inset 1px 1px 35px 6px rgba(0,0,0,0.05);
    -moz-box-shadow: inset 1px 1px 35px 6px rgba(0,0,0,0.05);
    box-shadow: inset 1px 1px 35px 6px rgba(0,0,0,0.05);
}
.tabla tr:nth-child(odd) { 
    background-color: rgba(0,0,0,.05);
    -webkit-box-shadow: inset 1px 1px 35px 6px rgba(0,0,0,0.05);
    -moz-box-shadow: inset 1px 1px 35px 6px rgba(0,0,0,0.05);
    box-shadow: inset 1px 1px 35px 6px rgba(0,0,0,0.05);
}
.tabla th{
    color:white;
    background-color: rgba(51,51,51,1);  
    border-right: 1px solid rgba(255,255,255,.05);
    border-top: 1px solid rgba(255,255,255,.05);
}
.tabla td, th{
    padding: 5px;    
    color:black;
    font-size: 14px;
    border-right:1px solid rgba(0,0,0,.1);
}
</style>

<?PHP
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