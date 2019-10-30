<?php
    session_start();

     include_once("../funciones_bd.php");
    
	
	$idEq = "";
	$idEqPadre = "";
	$idNodo = "";

	
	
	$idEq = $_GET["idEq"];
	$idEqPadre = $_GET["idEqPadre"];
	$idNodo = $_GET["idNodo"];
	
	if ($idEqPadre == 0)
		$idEqPadre = "NULL";

	$d = new DateTime();
  
	$conexion = cnn();
	
	$CadenaSQL = "INSERT INTO equiponodo(idEquipo, IdEquipoPadre, idNodo, FechaAsignacion) 
	VALUES (".$idEq .",".$idEqPadre.",".$idNodo.",'".$d->format('y-m-d')."')";		
	$result = mysqli_query($conexion,$CadenaSQL);
	ECHO $result;
	

?>