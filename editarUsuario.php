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
        <title> Editar Rol / Eliminar Perfil </title>
        <h1>Editar Rol / Eliminar Perfil</h1>
    </head>
    <body>
    
    <?php

        include_once dirname(__FILE__) . '../../../config.php';

        $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
        if (mysqli_connect_errno()) {
            echo "Error en la conexión: " . mysqli_connect_error();
        }

        $cedula = $_GET['cc'];

        $sqlPersona = "SELECT * FROM Personas WHERE Cedula = \"$cedula\" ";
        $sqlUser = "SELECT * FROM Usuarios WHERE Cedula = \"$cedula\"";
        $respuestaP = mysqli_query($con, $sqlPersona);
        $filaPersona = mysqli_fetch_array($respuestaP);
        $respuestaPU = mysqli_query($con, $sqlUser);
        $filaPersonaU = mysqli_fetch_array($respuestaPU);

        $nombreU = $filaPersona['Nombre'];
        $apellidoU = $filaPersona['Apellido'];
        $cedulaU = $filaPersona['Cedula'];
        $emailU = $filaPersona['CorreoElectronico'];
        $edadU = $filaPersona['Edad'];
        $rol = $filaPersonaU['Rol'];

        $str_datos="";
        $str_datos.='<h2>Perfil del Usuario: '. $nombreU .'</h2>';
        $str_datos.='<form action=\'administrarPersonas.php\' method=\'post\'>';
        $str_datos.='<table>';
        $str_datos.= 'Nombre: <input type="text" name="Nombre" readonly value='.$nombreU.'><br>';
        $str_datos.= 'Apellido: <input type="text" name="Apellido" readonly value='.$apellidoU.'><br>';
        $str_datos.= 'Cedula: <input type="number" name="Cedula" readonly value='.$cedulaU.'><br>';
        $str_datos.= 'Correo Electronico: <input type="email" readonly name="CorreoElectronico" value='.$emailU.'><br>';
        $str_datos.= 'Edad: <input type="number" name="Edad" readonly value='.$edadU.'><br>';


        if($rol == 'usuario'){
            $str_datos.='<input name="Rol" type="radio" value="usuario" checked="checked"/>Usuario';
            $str_datos.='<input name="Rol" type="radio" value="admin" />Admin';
        }else if($rol == 'admin'){
            $str_datos.='<input name="Rol" type="radio" value="usuario" />Usuario';
            $str_datos.='<input name="Rol" type="radio" value="admin" checked="checked"/>Admin';
        }

        $str_datos.='<br>';
        $str_datos.='</table>';
        $str_datos.='<input type="submit" value=\'Guardar\' name=\'editarusuario\'>';
        $str_datos.='<input type="submit" value=\'Eliminar\' name=\'eliminarusuario\'>';
        $str_datos.='</form>';
        echo $str_datos;

        echo "<form action='mostrarVisitas.php' method='post'>";
        echo "<input type=\"submit\" value='SALIR' name='guardar'>";
        echo "</form>";

        echo "<br>";
        echo "<br>";
        echo "<a href=\"index.php\">Regresar a Inicio</a>";

    ?>

    </body>
</html>