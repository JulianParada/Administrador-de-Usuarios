<?php

session_start();
if(isset($_SESSION['visitas'])){
$_SESSION['visitas']=$_SESSION['visitas']+1;
}
else{
$_SESSION['visitas']=1;
}

include_once dirname(__FILE__) . '../../../config.php';

$con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
if (mysqli_connect_errno()) {
    echo "Error en la conexión: " . mysqli_connect_error();
}

if (isset($_POST['guardar'])) {

    $_SESSION['c'] = $_POST['Cedula'];
    $_SESSION['n'] = $_POST['Nombre'];
    $_SESSION['a'] = $_POST['Apellido'];
    $_SESSION['ce'] = $_POST['CorreoElectronico'];
    $_SESSION['e'] = $_POST['Edad'];

    $nuevaPersona = array (
        "Cedula" => $_POST['Cedula'],
        "Nombre" => $_POST['Nombre'],
        "Apellido" => $_POST['Apellido'],
        "CorreoElectronico" => $_POST['CorreoElectronico'],
        "Edad" => $_POST['Edad']
    );

    if($_POST['Cedula'] != '' && $_POST['Nombre'] != '' && $_POST['Apellido'] != '' && $_POST['Edad'] != '' && $_POST['CorreoElectronico'] != ''){
            $sql = "INSERT INTO Personas (Cedula, Nombre, Apellido, CorreoElectronico, Edad) VALUES (\"$nuevaPersona[Cedula]\",
                                        \"$nuevaPersona[Nombre]\", \"$nuevaPersona[Apellido]\",
                                        \"$nuevaPersona[CorreoElectronico]\", $nuevaPersona[Edad])";
        if(mysqli_query($con, $sql)){
            $_SESSION['c'] = '';
            $_SESSION['n'] = '';
            $_SESSION['a'] = '';
            $_SESSION['ce'] = '';
            $_SESSION['e'] = '';
            echo "CREADO";
        }
        else{
            if(mysqli_error($con) == "Duplicate entry '$nuevaPersona[Cedula]' for key 'PRIMARY'"){
                $sql = "UPDATE Personas SET 
                        Cedula = \"$nuevaPersona[Cedula]\", 
                        Nombre = \"$nuevaPersona[Nombre]\", 
                        Apellido = \"$nuevaPersona[Apellido]\", 
                        CorreoElectronico = \"$nuevaPersona[CorreoElectronico]\", 
                        Edad = $nuevaPersona[Edad]
                        WHERE Cedula = \"$nuevaPersona[Cedula]\"";
                if(mysqli_query($con, $sql)){
                    $_SESSION['c'] = '';
                    $_SESSION['n'] = '';
                    $_SESSION['a'] = '';
                    $_SESSION['ce'] = '';
                    $_SESSION['e'] = '';
                    echo "ACTUALIZADO";
                }
            }
        }
    }else{
        header ("Location: administrador.php");
    }
    

    echo "<form action='mostrarVisitas.php' method='post'>";
    echo "<input type=\"submit\" value='SALIR' name='guardar'>";
    echo "</form>";

    echo "<br>";
    echo "<a href=\"administrador.php\">Regresar</a>";
}

if(isset($_POST['guardarusuario'])){

    $_SESSION['name'] = $_POST['Nombre'];
    $_SESSION['contr'] = $_POST['Contrasena'];
    $_SESSION['cc'] = $_POST['Cedula'];

    $cedula = $_POST['Cedula'];
    $nombre = $_POST['Nombre'];
    $password = $_POST['Contrasena'];

    if($_POST['Cedula'] != '' && $_POST['Nombre'] != '' && $_POST['Contrasena']){
        $_SESSION['name'] = '';
        $_SESSION['contr'] = '';
        $_SESSION['cc'] = '';

        $verify = "SELECT * FROM Personas WHERE Cedula = \"$cedula\" ";
        $res = mysqli_query($con, $verify);
        $exists = mysqli_num_rows($res);

        if($exists > 0){
            $verify2 = "SELECT * FROM Usuarios WHERE NombreUsuario = \"$nombre\" ";
            $res2 = mysqli_query($con, $verify2);
            $exists2 = mysqli_num_rows($res2);

            if($exists2 > 0){
                echo "No se puede crear el usuario, el nombre de usuario ya existe";
            }else{
                $verify3 = "SELECT * FROM Usuarios";
                $res3 = mysqli_query($con, $verify3);
                $exists3 = mysqli_num_rows($res3);
                $rol = "usuario";

                if($exists3 == 0){
                    $rol = "admin";
                }

                if (CRYPT_SHA512 == 1){
                    $hash = crypt($password, '$6$rounds=5000$unsaltcheveredeejemplo$');
                }else{
                    echo "SHA-512 no esta soportado.";
                }

                $sql = "INSERT INTO Usuarios (Cedula, NombreUsuario, Rol, Contrasena) VALUES (\"$cedula\", \"$nombre\", \"$rol\", \"$hash\")";
                
                if(mysqli_query($con, $sql)){

                    echo "Usuario creado correctamente.";
                }
            }

        }else{

            echo "No se puede crear el usuario, la cedula no existe.";

            
        }

        echo "<form action='mostrarVisitas.php' method='post'>";
        echo "<input type=\"submit\" value='SALIR' name='guardar'>";
        echo "</form>";


        echo "<br>";
        echo "<a href=\"administrador.php\">Regresar</a>";
    }else{
        header ("Location: administrador.php");
    }

    
}

if(isset($_POST['iniciarsesion'])){

    $_SESSION['user'] = $_POST['Usuario'];
    $_SESSION['pas'] = $_POST['Contrasena'];

    $usuario = $_POST['Usuario'];
    $password = $_POST['Contrasena'];

    $verify = "SELECT * FROM Usuarios WHERE NombreUsuario = \"$usuario\" ";
    $res = mysqli_query($con, $verify);
    $exists = mysqli_num_rows($res);

    if($_POST['Usuario'] != '' && $_POST['Contrasena'] != ''){
        if($exists > 0){

            $fila = mysqli_fetch_array($res);
            $rol = $fila['Rol'];
            $hashBD = $fila['Contrasena'];
            $cedula = $fila['Cedula'];
    
            if (hash_equals($hashBD, crypt($password, $hashBD))) {
                
                $_SESSION['user'] = '';
                $_SESSION['pas'] = '';
                
                if($rol == "usuario"){
    
                    $sqlPersona = "SELECT * FROM Personas WHERE Cedula = \"$cedula\" ";
                    $respuestaP = mysqli_query($con, $sqlPersona);
                    $filaPersona = mysqli_fetch_array($respuestaP);
    
                    $nombreU = $filaPersona['Nombre'];
                    $apellidoU = $filaPersona['Apellido'];
                    $cedulaU = $filaPersona['Cedula'];
                    $emailU = $filaPersona['CorreoElectronico'];
                    $edadU = $filaPersona['Edad'];
    
                    $str_datos="";
                    $str_datos.='<h2>Perfil del Usuario: '. $usuario .'</h2>';
                    $str_datos.='Nombre: '.$nombreU;
                    $str_datos.='<br>';
                    $str_datos.='Apellido: '.$apellidoU;
                    $str_datos.='<br>';
                    $str_datos.='Cedula: '.$cedulaU;
                    $str_datos.='<br>';
                    $str_datos.='Correo Electronico: '.$emailU;
                    $str_datos.='<br>';
                    $str_datos.='Edad: '.$edadU;
                    $str_datos.='<br>';
                    echo $str_datos;
    
                }else if($rol == "admin"){
                    $sqlPersonas = "SELECT * FROM Usuarios WHERE Rol = \"usuario\" ";
                    $respuestaPs = mysqli_query($con, $sqlPersonas);
                    
                    $str_datos="";
                    $str_datos.='<h2>Perfil del Administrador: '. $usuario .'</h2>';
                    $str_datos.='<h3>Lista de Usuarios</h3>';
                    $str_datos.='<table border=1>';
                    $str_datos.='<tr>';
                    $str_datos.='<th>Nombre de Usuario</th>';
                    $str_datos.='</tr>';
                    
                    foreach ($respuestaPs as $user) {
                        $str_datos.='<tr>';
                            $str_datos.='<td><a href=\'editarUsuario.php?cc='.$user['Cedula'].'\'>'. $user['NombreUsuario'] . '</a></td>';
                        $str_datos.='</tr>';
                    }
                    $str_datos.='</table>';
                    $str_datos.='<br>';
                    echo $str_datos;
                }
    
                echo "<form action='mostrarVisitas.php' method='post'>";
                echo "<input type=\"submit\" value='SALIR' name='guardar'>";
                echo "</form>";
    
                echo "<br>";
                echo "<a href=\"login.php\">Cerrar Cesion</a>";
    
            } else {
                echo "Contraseña Incorrecta :(";
    
                // header ("Location: login.php");
    
                echo "<form action='mostrarVisitas.php' method='post'>";
                echo "<input type=\"submit\" value='SALIR' name='guardar'>";
                echo "</form>";
    
                echo "<br>";
                echo "<a href=\"login.php\">Regresar</a>";
            }
    
        }else{
            echo "No existe el nombre de usuario";
    
            // header ("Location: login.php");
    
            echo "<form action='mostrarVisitas.php' method='post'>";
            echo "<input type=\"submit\" value='SALIR' name='guardar'>";
            echo "</form>";
    
            echo "<br>";
            echo "<a href=\"login.php\">Regresar</a>";
        }
    }else{
        header ("Location: login.php");
    }
}

if(isset($_POST['eliminarusuario'])){

    $cedula = $_POST['Cedula'];

    $sql = "DELETE FROM Usuarios WHERE Cedula = \"$cedula\"";
    if(mysqli_query($con, $sql)){
        echo "Usuario eliminado";
    }
    else{
        echo "Error";
    }

    echo "<form action='mostrarVisitas.php' method='post'>";
    echo "<input type=\"submit\" value='SALIR' name='guardar'>";
    echo "</form>";

    echo "<br>";
    echo "<a href=\"index.php\">Regresar a Inicio</a>";

}

if(isset($_POST['editarusuario'])){

    $cedula = $_POST['Cedula'];
    $rol = $_POST['Rol'];

    $sql = "UPDATE Usuarios set 
            Rol = \"$rol\" 
            WHERE Cedula = \"$cedula\"";

    if(mysqli_query($con, $sql)){
        echo "Rol del usuario actualizado";
    }

    echo "<form action='mostrarVisitas.php' method='post'>";
    echo "<input type=\"submit\" value='SALIR' name='guardar'>";
    echo "</form>";

    echo "<br>";
    echo "<a href=\"index.php\">Regresar a Inicio</a>";
}

?>