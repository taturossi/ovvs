<?php
    include_once("../funciones_bd.php");
	header("Content-Type: text/html;charset=utf-8");
	
	$codigo = "";
	$descrip = "";
	$prov = "";
	$ciudad = "";
	
	if(isset($_GET["c"]))
		$codigo = $_GET["c"];
	
	if(isset($_GET["d"]))
		$descrip = $_GET["d"];
	
	if(isset($_GET["p"]))
		$prov = $_GET["p"];
    
	if(isset($_GET["ci"]))
		$ciudad = $_GET["ci"];
	
	$conexion = cnn();
	
	$CadenaSQL = "SELECT n.idNodo, n.Codigo, n.LinkMaps, n.Descripcion Nodo, p.Descripcion Provincia, c.Nombre Ciudad, 
	n.FechaAlta, 6 Clientes, 		  n.FechaBaja 
					FROM nodo n inner join ciudad c on n.IdCiudad = c.IdCiudad 
						inner join provincia p on c.idProvincia = p.idProvincia
					WHERE 1 ";
	if ($codigo != "" )
		$CadenaSQL .= " and n.codigo like '%".$codigo."%'"; 	
	
	if ($descrip != "")
		$CadenaSQL .= " and n.Descripcion like '%".$descrip."%'"; 				
	
	if($ciudad != "")
		$CadenaSQL .= " and c.IdCiudad = ". $ciudad;
	else if ($prov != "")
		$CadenaSQL .= " and p.IdProvincia = ".$prov; 	

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