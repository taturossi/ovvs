<?php
    session_start();

     include_once("../funciones_bd.php");
    
	
	$id = $_GET["id"];
	$fb = "";
	
	
	
	$conexion = cnn();
	
	$CadenaSQL = "update tipomovimiento 
				  set "; 
	
	if(isset($_GET["d"]))
	{
		$descrip = $_GET["d"];
		$CadenaSQL .= " Descripcion = '".$descrip."'"; ;
	}
	else if(isset($_GET["fb"]))
	{
		$fb = new DateTime();	
		$CadenaSQL .= " FechaBaja = '".$fb->format('y-m-d')."'";
	}
	
	$CadenaSQL .=  " where idtipomovimiento = ".$id;
	
	
	$result = mysqli_query($conexion,$CadenaSQL);
	ECHO $result;
	

?>