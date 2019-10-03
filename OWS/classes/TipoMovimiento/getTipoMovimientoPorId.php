<?php
    include_once("../funciones_bd.php");
	
	$codigo = "";
	
	$codigo = $_GET["id"];
	      
	$conexion = cnn();
	
	$CadenaSQL = "SELECT IdTipoMovimiento, Codigo, Descripcion, TipoImputacion 
					FROM tipomovimiento
					WHERE idTipoMovimiento = ".$codigo; 
	$result = mysqli_query($conexion,$CadenaSQL);

	//Initialize array variable
	  $dbdata = array();

	//Fetch into associative array
	  while ( $row = $result->fetch_object())  {
		$dbdata[]=$row;
	  }

	//Print array in JSON format
	 $json = json_encode($dbdata);

	echo $json;
	

?>