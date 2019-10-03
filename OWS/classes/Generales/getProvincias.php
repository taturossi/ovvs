<?php
    include_once("../funciones_bd.php");
	
	$conexion = cnn();
	
	$CadenaSQL = "SELECT IdProvincia, Descripcion FROM provincia order by Descripcion asc ";
					
	  $result = mysqli_query($conexion,$CadenaSQL);

	  $dbdata = array();

			
	  while ( $row = $result->fetch_object())  {
		$dbdata[]=$row;
	  }

	//Print array in JSON format
	 $json = json_encode($dbdata);

	echo $json;
	

?>