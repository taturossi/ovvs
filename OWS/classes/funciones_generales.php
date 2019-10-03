<?php
    include_once("funciones_bd.php");

      function GetConsultas()
      {
        $conexion = cnn();
        $CadenaSQL = "SELECT idConsulta
                      FROM consultasrecibidas
                      WHERE respondida = 0;";

        $idconsulta = mysql_query($CadenaSQL,$conexion[0]);

        return $idconsulta;
      }

	function GetTextos($Texto)
	{
		$conexion = cnn();
        $CadenaSQL = "SELECT descripcion
                      FROM textos
                      WHERE nombre = '".$Texto."';";

        $idconsulta = mysql_query($CadenaSQL,$conexion[0]);

        return $idconsulta;
	}
	function GrabarTextos($Texto, $descrip)
	{
		$conexion = cnn();
        $CadenaSQL = "SELECT descripcion
                      FROM textos
                      WHERE nombre = '".$Texto."';";

        $idconsulta = mysql_query($CadenaSQL,$conexion[0]);

        return $idconsulta;
	}
	function GetLogoMarca($idMarca)
	{
		$conexion = cnn();
        $CadenaSQL = "SELECT imagen, marca
                      FROM marcasimagen
                      WHERE codigomarca = '".$idMarca."';";

        $idconsulta = mysql_query($CadenaSQL,$conexion[0]);
		
		$salida = "";
		if(mysql_num_rows($idconsulta) > 0)
		{
			$array = mysql_fetch_array($idconsulta);
			$salida = $array[0];
		}
		

        return $salida;
	}
	function GetUsuario($idUser)
	{
		$conexion = cnn();
        $CadenaSQL = "SELECT u.idusuario, u.nombre, u.apellido, u.direccion, u.telefono, u.usuario, u.mail, u.zona, z.descripcion
                      FROM usuarios u, zonas z
                      WHERE u.zona = z.idZona and u.idusuario = ".$idUser.";";
					  

        $idconsulta = mysql_query($CadenaSQL,$conexion[0]);

        return $idconsulta;
	}
	
	function GetPrecioProducto($codProducto)
	{
		$conexion = cnn();
        $CadenaSQL = "SELECT precio
                      FROM tabla
                      WHERE cod_artic = '".$codProducto."';";
					  

        $idconsulta = mysql_query($CadenaSQL,$conexion[0]);
		$precio = "0";
		if(mysql_num_rows($idconsulta) > 0)
		{
			 $fila = mysql_fetch_array($idconsulta);
			 $precio = $fila[0];	
		}

        return $precio;
	}
	function GetPromedioLinea($codLinea)
	{
		$conexion = cnn();
        $CadenaSQL = "SELECT AVG(precio) as precio
                      FROM tabla
                      WHERE grupo = '".$codLinea."';";
					  

        $idconsulta = mysql_query($CadenaSQL,$conexion[0]);
		$precio = "0";
		if(mysql_num_rows($idconsulta) > 0)
		{
			 $fila = mysql_fetch_array($idconsulta);
			 $precio = $fila[0];	
		}

        return $precio;
	}
	function getZonas()
	{
		$conexion = cnn();
        $CadenaSQL = "SELECT idZona, descripcion
                      FROM zonas where fechabaja is null;";

        $idconsulta = mysql_query($CadenaSQL,$conexion[0]);
		return $idconsulta;
	}
    function getZonasViajante($codViajantes)
	{
		$conexion = cnn();
        $CadenaSQL = "SELECT distinct z.idZona, z.descripcion
                      FROM zonas z, usuariozona uz where z.idzona = uz.idzona and fechabaja is null
                      and uz.idusuario in (".$codViajantes.");";

        $idconsulta = mysql_query($CadenaSQL,$conexion[0]);
		return $idconsulta;
	}
    function getViajantes()
	{
		$conexion = cnn();
        $CadenaSQL = "SELECT idUsuario, nombre, apellido
                      FROM usuarios where tipousuario = 4 and fechabaja is null;";

        $idconsulta = mysql_query($CadenaSQL,$conexion[0]);
		return $idconsulta;
	}

    function getDirectoryList ($directory)
    {

      // create an array to hold directory list
      $results = array();

      // create a handler for the directory
      $handler = opendir($directory);

      // open directory and walk through the filenames
      while ($file = readdir($handler)) {

        // if file isn't this directory or its parent, add it to the results
        if ($file != "." && $file != "..") {
            $str = explode(".", $file);
            if( $str[1] == "png")
                $results[] = $file;
        }

      }

      // tidy up: close the handler
      closedir($handler);

      // done!
      return $results;

    }
    function generarNumeroReclamo()
    {
        $conexion = cnn();
        $CadenaSQL = "SELECT MAX(idreclamo) id
                      FROM reclamos;";

        $idconsulta = mysql_query($CadenaSQL,$conexion[0]);
        $fila = mysql_fetch_array($idconsulta);
        $id = $fila[0] + 1;
        $date = getdate();
        $id .= "_".$date["year"].$date["mon"].$date["mday"]."_".$date["hours"].$date["minutes"].$date["seconds"];
		return $id;
    }

    function generarNumeroPedido()
    {
        $conexion = cnn();
        $CadenaSQL = "SELECT MAX(idpedido) id
                      FROM pedidos;";

        $idconsulta = mysql_query($CadenaSQL,$conexion[0]);
        $fila = mysql_fetch_array($idconsulta);
        $id = $fila[0] + 1;
        $date = getdate();
        $id .= "_".$date["year"].$date["mon"].$date["mday"]."_".$date["hours"].$date["minutes"].$date["seconds"];
		return $id;
    }





?>