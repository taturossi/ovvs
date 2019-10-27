<?php
    include_once("../funciones_bd.php");
	
	$id = "";
	
	if(isset($_GET["id"]))
		$id = $_GET["id"];
	      
	$conexion = cnn();
	
	$CadenaSQL = "SELECT idEquipo,codigo,Descripcion,IdMarcaEquipo,IdModeloEquipo,IdTipoHardware,FechaAlta 
					FROM equipo where idEquipo = ".$id; 
	$result = mysqli_query($conexion,$CadenaSQL);
	$filas = $result->num_rows;
	
	if($filas > 0)
	{
		$dbdata = array();

		while ( $row = $result->fetch_object())  {
			$dbdata[]=$row;
		}

		$json = json_encode($dbdata);
		echo $json;
	}
	else
		echo "";

	
	

?>