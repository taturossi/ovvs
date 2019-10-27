<?php
    session_start();

     include_once("../funciones_bd.php");
    
	
	$id = "";
	$descrip = "";
	$tipo = "";
	$marca = "";
	$modelo = "";
	$fb = "";

	$id = $_GET["id"];
	$CadenaSQL = "update equipo set ";
	$conexion = cnn();
	
	if(isset($_GET["fb"]))
	{
		$fb = new DateTime();	
		$CadenaSQL .= " FechaBaja = '".$fb->format('y-m-d')."'";
	}
	else
	{
	
		
		$descrip = $_GET["d"];
		$tipo = $_GET["t"];
		$marca = $_GET["m"];
		$modelo = $_GET["mo"];
	
		$CadenaSQL = $CadenaSQL . 
						"Descripcion= '".$descrip."',
						idMarcaEquipo =".$marca.",
						idModeloequipo=".$modelo.",
						IdTipoHardware=".$tipo;
	}
	
	$CadenaSQL = $CadenaSQL . "where idEquipo = ".$id;
	$result = mysqli_query($conexion,$CadenaSQL);
	ECHO $result;
	

?>