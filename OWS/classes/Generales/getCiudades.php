<?php
    include_once("../funciones_bd.php");
	header("Content-Type: text/html;charset=utf-8");
	
	$conexion = cnn();
	mysqli_query($conexion, "SET NAMES 'utf8'");
	$prov = $_GET["p"];
	
	$CadenaSQL = "SELECT IdCiudad, Descripcion  FROM ciudad where IdProvincia = ".$prov." order by Descripcion  asc ";
					
	  $result = mysqli_query($conexion,$CadenaSQL);

	  $dbdata = array();

	  while ( $row = $result->fetch_object())  {
		//echo $row->IdCiudad . ' -- ' . $row->Descripcion ;
		$dbdata[]=$row;
	  }

	//Print array in JSON format
	 $json = json_encode($dbdata);

	echo $json;
	

?>