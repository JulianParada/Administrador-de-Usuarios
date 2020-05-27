<?php
    include_once dirname(__FILE__) . '../../../config.php';
    $con = mysqli_connect(HOST_DB, USUARIO_DB, USUARIO_PASS, NOMBRE_DB);
    $sql = "CREATE TABLE Personas 
    (
    Cedula INT NOT NULL,
    PRIMARY KEY(Cedula),
    Nombre CHAR(15),
    Apellido CHAR(15),
    CorreoElectronico CHAR(50),
    Edad INT
    )";
    if (mysqli_query($con, $sql)) {
        echo "Tabla Personas creada correctamente";
    } else {
        echo "Error en la creacion " . mysqli_error($con);
    }
?>