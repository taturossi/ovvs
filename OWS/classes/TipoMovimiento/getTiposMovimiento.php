<?php
    include_once("../funciones_bd.php");
	
	$codigo = "";
	$descrip = "";
	$tipo = "";
	
	if(isset($_GET["c"]))
		$codigo = $_GET["c"];
	
	if(isset($_GET["d"]))
		$descrip = $_GET["d"];
	
	if(isset($_GET["t"]))
		$tipo = $_GET["t"];
      
	$conexion = cnn();
	
	$CadenaSQL = "SELECT IdTipoMovimiento, Codigo, Descripcion, FechaAlta, FechaBaja, TipoImputacion 
					FROM tipomovimiento
					WHERE 1 ";
	if ($codigo != "" )
		$CadenaSQL .= " and Codigo like '%".$codigo."%'"; 	
	
	if ($descrip != "")
		$CadenaSQL .= " and Descripcion like '%".$descrip."%'"; 				
	
	if ($tipo != "")
		$CadenaSQL .= " and TipoImputacion = '".$tipo."'"; 	

	if(isset($_GET["ch"]))
		$CadenaSQL .= " and FechaBaja is null";
					
	
	
	//Fetch 3 rows from actor table
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