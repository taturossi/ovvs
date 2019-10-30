<?php
    session_start();

     include_once("../funciones_bd.php");
    
	
	$codigo = "";
	$descrip = "";
	$tipo = "";
	
	
	$codigo = $_GET["codigo"];
	$descrip = $_GET["descrip"];
	$maps = $_GET["maps"];
	$ciudad = $_GET["ciudad"];
	$otros = $_GET["otros"];
	$ups = $_GET["ups"];
	$bat = $_GET["bat"];
	$server = $_GET["server"];
	$panel = $_GET["panel"];
	$regulador = $_GET["regulador"];
	$bocas = $_GET["bocas"];
		
	$d = new DateTime();
  
	$conexion = cnn();
	
	$CadenaSQL = "INSERT INTO nodos(Codigo, Descripcion, FechaAlta,LinkMaps, IdCiudad, OtrosDetalles,  UPS, Baterias, Servidor, PanelSolar, Regulador, BocasElectricas) 
	VALUES ('".$codigo ."','".$descrip."','".$d->format('y-m-d')."','".$maps."',".$ciudad.",'".$otros."','".$ups."','".$bat."','".$server."','".$panel."','".$regulador."','".$bocas."')";
			
	$result = mysqli_query($conexion,$CadenaSQL);
	$result = mysqli_insert_id($conexion);
	ECHO $result;
	

?>