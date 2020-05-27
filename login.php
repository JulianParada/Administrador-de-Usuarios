
<?php
session_start();
if(isset($_SESSION['visitas'])){
$_SESSION['visitas']=$_SESSION['visitas']+1;
}
else{
$_SESSION['visitas']=1;
}
?>
<!DOCTYPE html>
<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. createTable.php
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title> Login </title>
        <h1>Login</h1>
    </head>
    <body>

    <div>
        <br>
        <form action='administrarPersonas.php' method='post'>
	        <table>
                Usuario: <input type="text" name="Usuario"><br>
                Contraseña: <input type="password" name="Contrasena"><br>
	        </table>
	    <input type="submit" value='Iniciar Sesion' name='iniciarsesion'>
        </form>
        <br>
    </div>

    <form action='mostrarVisitas.php' method='post'>
	    <input type="submit" value='SALIR' name='guardar'>
    </form>

    </body>
</html>