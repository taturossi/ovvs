<?php
    include_once("../funciones_bd.php");
	
	$codigo = "";
	
	if(isset($_GET["c"]))
		$codigo = $_GET["c"];
	      
	$conexion = cnn();
	
	$CadenaSQL = "SELECT n.IdNodo, n.Codigo, n.LinkMaps, n.Descripcion, n.IdCiudad, n.OtrosDetalles, n.UPS, n.Baterias
	, n.Servidor, n.PanelSolar, n.Regulador, n.BocasElectricas 
	FROM nodos n inner join ciudad c on n.IdCiudad = c.idCiudad inner join provincia p on c.idProvincia = p.idProvincia 
	WHERE n.Codigo like '%".$codigo."%'"; 
	
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