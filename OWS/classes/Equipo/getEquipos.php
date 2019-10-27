<?php
    include_once("../funciones_bd.php");
	header("Content-Type: text/html;charset=utf-8");
	
	$codigo = "";
	$descrip = "";
	$tipoequipo = "";
	$marca = "";
	$modelo = "";
	$torre = "";
	
	if(isset($_GET["c"]))
		$codigo = $_GET["c"];
	
	if(isset($_GET["d"]))
		$descrip = $_GET["d"];
	
	if(isset($_GET["t"]))
		$tipoequipo = $_GET["t"];
    
	if(isset($_GET["m"]))
		$marca = $_GET["m"];
	
	if(isset($_GET["mo"]))
		$modelo = $_GET["mo"];
	
	if(isset($_GET["to"]))
		$torre = $_GET["to"];

	
	
	
	$conexion = cnn();
	
	$CadenaSQL = "SELECT e.idEquipo, e.codigo, e.Descripcion, m.Descripcion marca, mo.descripcion Modelo, te.Descripcion TipoEquipo , ti.Descripcion tipoinstalacion, \"Torre\", e.FechaAlta, e.FechaBaja
					FROM equipo e inner JOIN
					marcaequipo m on e.IdMarcaEquipo = m.idMarcaEquipo inner JOIN
					modeloequipo mo on e.IdModeloEquipo = mo.idmodeloequipo INNER JOIN
					tipoequipo te on e.IdTipoHardware = te.idTipoEquipo left outer JOIN
					tipoinstalacion ti on  e.IdTipoInstalacion = ti.idTipoInstalacion
					WHERE fechabaja is null ";
	
	if ($codigo != "" )
		$CadenaSQL .= " and e.codigo like '%".$codigo."%'"; 	
	
	if ($descrip != "")
		$CadenaSQL .= " and e.Descripcion like '%".$descrip."%'"; 				
	
	if($tipoequipo != "")
		$CadenaSQL .= " and te.idTipoEquipo = ". $tipoequipo;
	
	if ($marca != "")
		$CadenaSQL .= " and m.idMarcaEquipo = ".$marca;
	
	if ($modelo != "")
		$CadenaSQL .= " and mo.idmodeloequipo = ".$modelo;
	
	//if ($Torre != "")
	//	$CadenaSQL .= " and mo.idmodeloequipo = ".$modelo;
			
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