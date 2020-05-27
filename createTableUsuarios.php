<?php
    include_once dirname(__FILE__) . '../../../config.php';
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    $sql = "CREATE TABLE Usuarios 
    (
        Id  int AUTO_INCREMENT,
        PRIMARY KEY(Id),
        NombreUsuario VARCHAR(255),
        Rol VARCHAR(255),
        Contrasena VARCHAR(255),
        Cedula INT NOT NULL,
        FOREIGN KEY (Cedula) references personas (Cedula)
    )";
    if (mysqli_query($con, $sql)) {
        echo "Tabla Usuarios creada correctamente";
    } else {
        echo "Error en la creacion " . mysqli_error($con);
    }
?>