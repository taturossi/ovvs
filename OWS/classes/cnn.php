<?php
      //Funcion que nos permite controlar la conexion completa hacia la base
      //de datos MySQL.-
	function cnn()
	{
		$ini = parse_ini_file("cnf.ini");
		
		$host = $ini['host'];//'localhost';
		$user = $ini['user'];//'root';
		$clave = $ini['clave'];
		$bd = $ini['db'];
  	    $port = $ini['port'];

		//Intento realizar la conexion al servidor MySQL, si falla me arroja un error
		$idcnn=mysqli_connect($host,$user,$clave,$bd) or die("Error conectando al servidor $host con el nombre de usuario $user <br>\n".mysqli_error());

		//Intento seleccionar la b.datos, si falla me arroja un error
		mysqli_select_db($idcnn, $bd) or die ("No puede usar la base de datos: $bd <br\n>".mysqli_error());
		mysqli_query($idcnn, "SET NAMES 'utf8'");

	
		//----------------------------------------------------------------------------------------------------------------------

		return $idcnn;    //Retorno al script que llamó la funcion con
                                       //el valor del id devuelto por la conexion y la bdatos.
	}
?>
