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
        <title> Personas </title>
        <h1>Gestor de Personas y Usuarios</h1>
    </head>
    <body>
    <div>
        <h2>Crear/Actualizar Persona</h2>
        <br>
        <form action='administrarPersonas.php' method='post'>
	        <table>
                Cedula: <input type="number" name="Cedula" value="<?php if (isset($_SESSION['c'])){ echo $_SESSION['c']; } ?>"><br>
                Nombre: <input type="text" name="Nombre" value="<?php if (isset($_SESSION['n'])){ echo $_SESSION['n']; } ?>"><br>
                Apellido: <input type="text" name="Apellido" value="<?php if (isset($_SESSION['a'])){ echo $_SESSION['a']; } ?>"><br>
                Correo Electronico: <input type="email" name="CorreoElectronico" value="<?php if (isset($_SESSION['ce'])){ echo $_SESSION['ce']; } ?>"><br>
                Edad: <input type="number" name="Edad" value="<?php if (isset($_SESSION['e'])){ echo $_SESSION['e']; } ?>"><br>
	        </table>
	    <input type="submit" value='Guardar' name='guardar'>
        </form>
        <br>
    </div>


    <div>
        <h2>Crear Usuario</h2>
        <br>
        <form action='administrarPersonas.php' method='post'>
	        <table>
                Nombre de Usuario: <input type="text" name="Nombre" value="<?php if (isset($_SESSION['name'])){ echo $_SESSION['name']; } ?>"><br>
                Contraseña: <input type="password" name="Contrasena" value="<?php if (isset($_SESSION['contr'])){ echo $_SESSION['contr']; } ?>"><br>
                Cedula: <input type="number" name="Cedula" value="<?php if (isset($_SESSION['cc'])){ echo $_SESSION['cc']; } ?>"><br>
	        </table>
	    <input type="submit" value='Guardar' name='guardarusuario'>
        </form>
        <br>
    </div>

    <form action='mostrarVisitas.php' method='post'>
	    <input type="submit" value='SALIR' name='guardar'>
    </form>

    <br>
    <a href="index.php">Regresar</a>

    </body>
</html>