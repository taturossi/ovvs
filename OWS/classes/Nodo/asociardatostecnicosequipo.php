<?php
    session_start();

     include_once("../funciones_bd.php");
    
	
	$idanteq = $_GET["idanteq"];
	$mod = $_GET["mod"];
	$frecs = $_GET["frecs"];
	$ab = $_GET["ab"];
	$frec = $_GET["frec"];
		
	$d = new DateTime();
  
	$conexion = cnn();
	
	$CadenaSQL = "INSERT INTO detalleequiponodo (idequiponodo, modalidad, frecuencias, anchobanda, frecuencia, fechaalta) 
	VALUES (".$idanteq .",'".$mod."','".$frecs."','".$ab."','".$frec."','".$d->format('y-m-d')."')";
			
	$result = mysqli_query($conexion,$CadenaSQL);
	$result = mysqli_insert_id($conexion);
	ECHO $result;
	

?>