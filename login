<?php include("../db.php"); ?>
<?php

$usuario = "";
$pass = "";

if(isset($_POST['iniciar']))
{
	$usuario = $_POST['usuario'];
	$pass = $_POST['pass'];
	
	$query = "SELECT count(usuario) as 'uss' FROM usuarios WHERE usuario = '$usuario'";
	$result = mysqli_query($conn, $query);
	while($row = mysqli_fetch_array($result)){ 
		$a = $row['uss'];
		if($a==1)
		{	
			
			$query = "SELECT count(pass) as 'pss', nombre, apellido, tipo_us FROM usuarios WHERE usuario = '$usuario' AND pass = '$pass'";
			$result = mysqli_query($conn, $query);
			while($row = mysqli_fetch_array($result)){

				$b = $row['pss'];
				$c = $row['nombre'];
				$d = $row['apellido'];
				$e = $row['tipo_us'];
				if($b==1)
				{
					$_SESSION['nombre'] = $c;
					$_SESSION['apellido'] = $d;
					$_SESSION['tipo_us'] = $e;
					header('Location: ../inicio.php');
					
				}
				else
				{
					$_SESSION['mensaje'] = "Contraseña incorrecta";
					$_SESSION['colorus'] = "border-success";
					$_SESSION['colorpass'] = "border-danger";
					$_SESSION['usuario'] = $usuario;
					$_SESSION['pass'] = $pass;
					header('Location: ../index.php');
					
					
					
				}
			}
		}
		else
		{
			$_SESSION['mensaje'] = "Usuario incorrecto";
			$_SESSION['colorus'] = "border-danger";
			$_SESSION['colorpass'] = "border-danger";
			$_SESSION['usuario'] = $usuario;
			$_SESSION['pass'] = $pass;
			header('Location: ../index.php');
			
			
			
		}

		
	
	 
	}

	
	
	$_SESSION['usuario'] = $usuario;
	$_SESSION['pass'] = $pass;

}

?>
