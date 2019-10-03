<?php
    include_once("../funciones_bd.php");
	
	$codigo = "";
	$descrip = "";
	$tipo = "";
	
	if(isset($_GET["c"]))
		$codigo = $_GET["c"];
	      
	$conexion = cnn();
	
	$CadenaSQL = "SELECT IdTipoMovimiento, Codigo, Descripcion, FechaAlta, FechaBaja, TipoImputacion 
					FROM tipomovimiento
					WHERE Codigo like '%".$codigo."%'"; 
	
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