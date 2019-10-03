<?php
    session_start();

     include_once("../funciones_bd.php");
    
	
	$codigo = "";
	$descrip = "";
	$tipo = "";
	
	
	$codigo = $_GET["c"];
	$descrip = $_GET["d"];
	$tipo = $_GET["t"];
	$d = new DateTime();
  
	$conexion = cnn();
	
	$CadenaSQL = "INSERT INTO tipomovimiento(Codigo, Descripcion, FechaAlta, TipoImputacion) 
					VALUES ('".$codigo ."','".$descrip."','".$d->format('y-m-d')."','".$tipo."')";
						
	$result = mysqli_query($conexion,$CadenaSQL);
	ECHO $result;
	

?>