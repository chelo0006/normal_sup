<link href="<?php echo $prof;?>css/login.css?version=1.3" rel="stylesheet" type="text/css" />
<?php
if(isset($_GET['e'])) $error = '?e=1';
else $error = '';
echo '<div>
<img src="imagenes/baner2.png" style="width:98%; margin-bottom:-10px;">
<table class="login" border=0 width=100% cellspacing=10>
<tr><td><b>Usuario</b>:</td></tr>
<tr><td><input type="text" id="usuario" name="usuario" style="width:100%" onkeypress="pulsar(event)" /></td></tr>
<tr><td><b>Contraseña:</b></td></tr>
<tr><td><input type="password" id="pass" name="pass" style="width:100%" onkeypress="pulsar(event)" /></td></tr>
<tr><td>';
if ($error != '') echo '<center><font style="color:red;">Usuario y/o contraseña incorrectos</font></center>';
echo '<a class="btn" onclick="enviar();" style="display:block; text-align:center;">Ingresar</a></td></tr>
</table>
<font style="font-size:12px;">Si olvidó su contraseña por favor haga click <a class="linkk" href="#">aqui</a></font>
</div>
';
?>