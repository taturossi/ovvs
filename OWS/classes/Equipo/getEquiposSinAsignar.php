<?php
    include_once("../funciones_bd.php");
	header("Content-Type: text/html;charset=utf-8");
	
	
	$conexion = cnn();
	
	$CadenaSQL = "SELECT e.idEquipo, e.codigo, e.Descripcion, m.Descripcion marca, mo.descripcion Modelo, te.idTipoEquipo, te.Descripcion TipoEquipo , ti.Descripcion tipoinstalacion, \"Torre\", e.FechaAlta, e.FechaBaja
					FROM equipo e inner JOIN
					marcaequipo m on e.IdMarcaEquipo = m.idMarcaEquipo inner JOIN
					modeloequipo mo on e.IdModeloEquipo = mo.idmodeloequipo INNER JOIN
					tipoequipo te on e.IdTipoHardware = te.idTipoEquipo left outer JOIN
					tipoinstalacion ti on  e.IdTipoInstalacion = ti.idTipoInstalacion
					WHERE fechabaja is null AND e.idEquipo not in (select idequipo from equiponodo where fechabaja is null)";
	
			
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