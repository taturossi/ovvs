<?php
    include_once("../funciones_bd.php");
	
	$conexion = cnn();
	
	$CadenaSQL = "SELECT idMarcaEquipo,Descripcion FROM marcaequipo order by Descripcion asc ";
					
	  $result = mysqli_query($conexion,$CadenaSQL);

	  $dbdata = array();

			
	  while ( $row = $result->fetch_object())  {
		$dbdata[]=$row;
	  }

	//Print array in JSON format
	 $json = json_encode($dbdata);

	echo $json;
	

?>