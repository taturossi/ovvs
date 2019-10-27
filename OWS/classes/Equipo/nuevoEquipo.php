<?php
    session_start();

     include_once("../funciones_bd.php");
    
	
	$codigo = "";
	$descrip = "";
	$tipo = "";
	$marca = "";
	$modelo = "";
	
	$codigo = $_GET["c"];
	$descrip = $_GET["d"];
	$tipo = $_GET["t"];
	$marca = $_GET["m"];
	$modelo = $_GET["mo"];
	
	$d = new DateTime();
  
	$conexion = cnn();
	
	$CadenaSQL = "INSERT INTO `equipo` (codigo, Descripcion, IdMarcaEquipo, IdModeloEquipo, IdTipoHardware,FechaAlta) 
					VALUES ('".$codigo ."','".$descrip."',".$marca.",".$modelo.",".$tipo.",'".$d->format('y-m-d')."')";
	$result = mysqli_query($conexion,$CadenaSQL);
	ECHO $result;
	

?>