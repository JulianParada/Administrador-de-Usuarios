<?php
session_start();
if(isset($_SESSION['visitas'])){
$_SESSION['visitas']=$_SESSION['visitas']+1;
}
else{
$_SESSION['visitas']=1;
}
?>
<html>
	<head>
		<title>Administrar Personas y Usuarios</title>
	</head>	
	<body>
		<header>
			Taller 2
		</header>
		<table border=1>			
			<tr>
				<td><a href="administrador.php">Crear Personas y Usuarios</a></td>
			</tr>
			<tr>
				<td><a href="login.php">Iniciar Sesion</a></td>
			</tr>
		</table>

		<form action='mostrarVisitas.php' method='post'>
	    	<input type="submit" value='SALIR' name='guardar'>
        </form>

		<footer>
			Administrador Web Basico
		</footer>
	</body>
</html>