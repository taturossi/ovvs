<?php
    include_once("../funciones_bd.php");
	
	$codigo = "";
	
	if(isset($_GET["c"]))
		$codigo = $_GET["c"];
	      
	$conexion = cnn();
	
	$CadenaSQL = "SELECT idEquipo,codigo,Descripcion,IdMarcaEquipo,IdModeloEquipo,IdTipoHardware,FechaAlta 
					FROM equipo where codigo like '%".$codigo."%'"; 
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