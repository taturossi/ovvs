<?php
//----------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------
include('cnn.php');

function GetStrValue($Value, $TypeValue)
{
	$strValue = "";
	if ($Value == null)
	{
		$strValue = "null";
		return $strValue;
	}
	switch ($TypeValue)
	{
		case "S":
			$strValue = "'".str_replace("'", " ", $Value)."'";
			break;
		case "B":
			$strValue = $Value;
			break;
		case "N":
			$strValue = str_replace(",", ".", $Value);
			break;
		case "F":
			$strValue = "'".$Value."'";
			break;
	}
	return $strValue;
}

function MakeInsertSQL($SQLStr, $FieldName, $Value, $TypeValue)
{
	$retStr = "";
	$sep = "";
	$fields = "";
	$values = "";
      
	if (strlen($SQLStr) == 0)
	{
		$fields = "()";
		$values = "()";
		$sep = "";
	}
	else
	{
		$ef = strpos($SQLStr,")");
		$sv = strpos( $SQLStr, "(", $ef);

		$fields =  substr( $SQLStr, 0, $ef + 1);
		$values = substr($SQLStr,$sv);
		$sep = ",";
	}

	$strValue = GetStrValue($Value, $TypeValue);
	
	if ( strpos($FieldName, "_") > 0 && ( $strValue== "'0'" || $strValue == "''"))
	{
		$strValue = "null";
	}
	
	$fields = str_replace( ")", $sep.$FieldName.")", $fields);
	
	//values = values.Replace(")", sep + strValue + ")");
	$values = substr( $values, 0, strlen( $values) -1).$sep.$strValue.")";
	$retStr = $fields." values ".$values;

	return $retStr;
}

function MakeUpdateSQL($SQLStr, $FieldName, $Value, $TypeValue)
{

	$retStr = "";
	$sep = "";
	
	if (strlen($SQLStr) == 0)
	{
		$retStr = " set ";
		$sep = "";
	}
	else
	{
		$retStr = $SQLStr;
		$sep = ",";
	}
	
	$strValue = GetStrValue($Value, $TypeValue);

	
	
	if ( strpos($FieldName, "_") > 0 && ( $strValue== "'0'" || $strValue == "''"))
	{
		$strValue = "null";
	}

	$retStr = $retStr.$sep." ".$FieldName."=".$strValue;
	return $retStr;
}
		
function Ejecutar_SQL($cadenaSQL)
{
	//Llama a la funcion que realiza la conexion devolviendo una
	//matriz que contiene el identificador de conexion y el nombre de la base de datos.
	$conexion= cnn();
	$Retorno = 0;
	if ($conexion[0]>=0 and $conexion[1]<> '')  //Pregunta si contienen valores vlidos
	{
		//Ejecuta la instruccion contra la bd, si falla devuelve un error
		$idconsulta=mysql_query($cadenaSQL,$conexion[0]) or die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": EL ingreso de registro fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		
		$Retorno = mysql_insert_id();
		
		mysql_close();
		if (!$idconsulta) //Pregunta si el identificador devuelve un valor que corresponda a una ejecucion exitosa
		{
			die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": EL ingreso de registro fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		}
		else
		{
			return $Retorno;
			//return true;
		}
		
	}
	else
	{
		return 0; //false;
	}
}

function Ejecutar_SELECT($cadenaSQL)
{
	//Llama a la funcion que realiza la conexion devolviendo una
	//matriz que contiene el identificador de conexion y el nombre de la base de datos.
	$conexion= cnn();
	$Retorno = 0;
	if ($conexion[0]>=0 and $conexion[1]<> '')  //Pregunta si contienen valores vlidos
	{
		//Ejecuta la instruccion contra la bd, si falla devuelve un error
		$idconsulta=mysql_query($cadenaSQL,$conexion[0]) or die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": EL ingreso de registro fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		
		mysql_close();
		if (!$idconsulta) //Pregunta si el identificador devuelve un valor que corresponda a una ejecucion exitosa
		{
			die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": EL ingreso de registro fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		}
		else
		{
			return $idconsulta;
		}
	}
	else
	{
		return null; //false;
	}
}


//Chequea si existe el registro dentro de una tabla en la bd.
function existe_bd($tabla,$condicion,$campos_seleccionado)
{
	//Llama a la funcion que realiza la conexion devolviendo una
	//matriz que contiene el identificador de conexion y el nombre de la base de datos.
	$conexion= cnn();
	if ($conexion[0]>=0 and $conexion[1]<> '')  //Pregunta si contienen valores vlidos
	{
		//Define la instruccion SQL
		$cadenaSQL="SELECT ".$campos_seleccionado." FROM ".$tabla." WHERE ".$condicion;
		//echo "cadena [existe_bd]: ".$cadenaSQL;
		//Ejecuta la instruccion contra la bd, si falla devuelve un error
		$idconsulta=mysql_query($cadenaSQL,$conexion[0]) or die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La consulta fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		if (!$idconsulta) //Pregunta si el identificador devuelve un valor que corresponda a una ejecucion exitosa
		{
			die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La consulta fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		}
		else
		{
			$_SESSION["NroFilas"] = mysql_num_rows($idconsulta);
			return(mysql_fetch_object($idconsulta)); //Retorna el resultado de la consulta
		}
		mysql_free_result($idconsulta);
		mysql_close();
	}
}
//----------------------------------------------------------------------------------------------------------
//Chequea si existe el registro dentro de una tabla en la bd. 
//------------------------------------------------------------------------------------------------------
//                                         NO USAR
//------------------------------------------------------------------------------------------------------
function ultimo_reg($tabla,$campo_seleccionado)
{
	//Llama a la funcion que realiza la conexion devolviendo una
	//matriz que contiene el identificador de conexion y el nombre de la base de datos.
	$conexion= cnn();
	if ($conexion[0]>=0 and $conexion[1]<> '')  //Pregunta si contienen valores vlidos
	{
		//Selecciono todos los ID. para buscar si se saltea algunos
		$nuevoID=0;
		$cadenaSQL="SELECT ".$campo_seleccionado." AS nuevo FROM ".$tabla." ORDER BY ".$campo_seleccionado;
		//echo "cadena [ultimo_reg]: ".$cadenaSQL;
		$idconsulta=mysql_query($cadenaSQL,$conexion[0]) or die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La consulta fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		if ($idconsulta) //Si se ejecuto exitosamente
		{
			$anterior=0;
			while ($IDs=mysql_fetch_object($idconsulta)) //Recorro el objeto cargado con los ids de la tabla
			{
				if ($IDs->nuevo != $anterior + 1 ) //Pregunto si el id actual NO es igual al id anterior mas uno
				{
					$nuevoID = $anterior + 1; //Carga la var. devuelta, con el id recuperado
					break 1;
				}
				else //Si son iguales carga la var. anterior con el id actual
				{
					$anterior = $IDs->nuevo;
				}
			}
		}
		//Si la var. no se cargo, es por que los id son correlativos, por lo tanto busca el ultimo mas uno.-
		if ($nuevoID == 0)
		{
			//Define la instruccion SQL
			$cadenaSQL="SELECT (MAX(".$campo_seleccionado.")+1) AS nuevo FROM ".$tabla;
			//$cadenaSQL="SELECT COUNT(idusuario) AS Cantidad FROM usuarios WHERE cuenta LIKE 'MauriLP'";
			//Ejecuta la instruccion contra la bd, si falla devuelve un error
			$idconsulta=mysql_query($cadenaSQL,$conexion[0]) or die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La consulta fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
			if (!$idconsulta) //Pregunta si el identificador devuelve un valor que corresponda a una ejecucion exitosa
			{
				die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La consulta fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
			}
			else
			{
				//carga una matriz;
				$IDs = mysql_fetch_object($idconsulta);
				//carga la var. que retorna el valor encontrado
				if (!$IDs->nuevo) //Si la consulta devuelve falso el ID es 1
				{
					$nuevoID = 1;
				}
				else //Si no devuelve el ultimo mas uno
				{
					$nuevoID = $IDs->nuevo;
				}
			}
		}
		//Retorna con el valor encontrado
		//echo "El id articulos es: ".$nuevoID;
		return $nuevoID;
		mysql_free_result($idconsulta);
		mysql_close();
	}
}
//----------------------------------------------------------------------------------------------------------
//Inserta un registro en un tabla en la base de datos
function insert_reg($tabla,$campos_seleccionado,$nuevos_valores)
{
	//Llama a la funcion que realiza la conexion devolviendo una
	//matriz que contiene el identificador de conexion y el nombre de la base de datos.
	$conexion= cnn();
	if ($conexion[0]>=0 and $conexion[1]<> '')  //Pregunta si contienen valores vlidos
	{
		//Define la instruccion SQL
		$cadenaSQL="INSERT INTO ".$tabla."(".$campos_seleccionado.") VALUES (".$nuevos_valores.")";
		//echo "Consulta [insert_reg]: ".$cadenaSQL."<br>";
		//Ejecuta la instruccion contra la bd, si falla devuelve un error
		$idconsulta=mysql_query($cadenaSQL,$conexion[0]) or die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": EL ingreso de registro fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		
		mysql_close();
		if (!$idconsulta) //Pregunta si el identificador devuelve un valor que corresponda a una ejecucion exitosa
		{
			die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": EL ingreso de registro fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		}
		else
		{
			return true;
			//					echo "<center><span style=\"vertical-align:middle;\"><b><font size=\"+1\" color=\"#557FFF\">Su registro fue guardado, deber esperar al menos 24hs. para poder comprar o vender</font></b></span><br>\n";
			//					echo "<span style=\"vertical-align:middle;\"><b><font size=\"+1\" color=\"#557FFF\">Desde ya, muchas gracias</font></b></span> <br>\n</center>";
		}
		
	}
}
//----------------------------------------------------------------------------------------------------------
//Actualiza un registro en un tabla en la base de datos
function update_reg($tabla,$campos_actualiza,$condicion)
{
	//Llama a la funcion que realiza la conexion devolviendo una
	//matriz que contiene el identificador de conexion y el nombre de la base de datos.
	$conexion= cnn();
	if ($conexion[0]>=0 and $conexion[1]<> '')  //Pregunta si contienen valores vlidos
	{
		//Define la instruccion SQL
		$cadenaSQL="UPDATE ".$tabla." SET ".$campos_actualiza." WHERE ".$condicion;
		//echo "Consulta [update_reg]: ".$cadenaSQL."<br>";
		//Ejecuta la instruccion contra la bd, si falla devuelve un error
		$idconsulta=mysql_query($cadenaSQL,$conexion[0]) or die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La actualizaci&oacute;n fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		if (!$idconsulta) //Pregunta si el identificador devuelve un valor que corresponda a una ejecucion exitosa
		{
			die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La actualizaci&oacute;n fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		}
		else
		{
			return true;
		}
		mysql_close();
	}
}
//----------------------------------------------------------------------------------------------------------
//Elimina un registro en un tabla en la base de datos
function delete_reg($tabla,$condicion)
{
	//Llama a la funcion que realiza la conexion devolviendo una
	//matriz que contiene el identificador de conexion y el nombre de la base de datos.
	$conexion= cnn();
	if ($conexion[0]>=0 and $conexion[1]<> '')  //Pregunta si contienen valores vlidos
	{
		//Define la instruccion SQL
		$cadenaSQL="DELETE FROM ".$tabla." WHERE ".$condicion;
		//	echo "Consulta: ".$cadenaSQL."<br>";
		//Ejecuta la instruccion contra la bd, si falla devuelve un error
		$idconsulta=mysql_query($cadenaSQL,$conexion[0]) or die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La eliminaci&oacute;n fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		//Pregunta si el identificador devuelve un valor que corresponda a una ejecucion exitosa
		if (!$idconsulta)
		{
			die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La eliminaci&oacute;n fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		}
		mysql_close();
	}
}
//----------------------------------------------------------------------------------------------------------		//Lista los registros cargados
function seleccion_bd($tablas,$campos_seleccionado,$limites)
{
	//Llama a la funcion que realiza la conexion devolviendo una
	//matriz que contiene el identificador de conexion y el nombre de la base de datos.
	$conexion= cnn('localhost','mundomed_anonimo','123456','mundomed_web','3306');
	if ($conexion[0]>=0 and $conexion[1]<> '')  //Pregunta si contienen valores vlidos
	{
	//Define la instruccion SQL
	$cadenaSQL="SELECT ".$campos_seleccionado." FROM ".$tablas." LIMIT ".$limites;
	//	echo "Consulta: ".$cadenaSQL."<br>";
	//Ejecuta la instruccion contra la bd, si falla devuelve un error
	$idconsulta=mysql_query($cadenaSQL,$conexion[0]) or die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La consulta fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
	if (!$idconsulta) //Pregunta si el identificador devuelve un valor que corresponda a una ejecucion exitosa
	{
	die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La consulta fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
	}
	else
	{
	//					 echo "Cantidad: ".mysql_num_rows($idconsulta);
	//					 return(mysql_fetch_object($idconsulta)); //Retorna el resultado de la consulta
	return(mysql_fetch_row($idconsulta));
	}
	mysql_free_result($idconsulta);
	mysql_close();
	}
}
//----------------------------------------------------------------------------------------------------------		//Consulta que devuelte la cantidad de registros
function cantidad_reg($tabla_s,$condicion)
{
//Llama a la funcion que realiza la conexion devolviendo una
//matriz que contiene el identificador de conexion y el nombre de la base de datos.
$conexion= cnn('localhost','mundomed_anonimo','123456','mundomed_web','3306');
if ($conexion[0]>=0 and $conexion[1]<> '')  //Pregunta si contienen valores vlidos
{
if (!empty($condicion) || $condicion != '')
{
//Define la instruccion SQL
$cadenaSQL="SELECT * FROM ".$tabla_s." WHERE ".$condicion;
}
else
{
//Define la instruccion SQL
$cadenaSQL="SELECT * FROM ".$tabla_s;
}
//echo $cadenaSQL;
//Ejecuta la instruccion contra la bd, si falla devuelve un error
$idconsulta=mysql_query($cadenaSQL,$conexion[0]) or die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La consulta fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
if (!$idconsulta) //Pregunta si el identificador devuelve un valor que corresponda a una ejecucion exitosa
{
die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La consulta fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
}
else
{
return(mysql_num_rows($idconsulta)); //Retorna la cantidad de registros encontrados
}
mysql_free_result($idconsulta);
mysql_close();
}
}
//--------------------------------------------------------------------------------------------------------------------------------------------------------
function Devuelve_Img($idarticulo,$idimg)
{
	//Intento realizar la conexion al servidor MySQL, si falla me arroja un error
	//$conexion= cnn('localhost','mundomed_anonimo','123456','mundomed_web','3306');
	$idcnn=mysql_connect('localhost','mundomed_anonimo','123456') or die("Error conectando al servidor $host con el nombre de usuario $user <br>\n".mysql_error());
	//Intento seleccionar la b.datos, si falla me arroja un error
	mysql_select_db('mundomed_web', $idcnn) or die ("No puede usar la base de datos: $bd <br\n>".mysql_error());
	if ($idcnn>=0)  //Pregunta si contienen valores vlidos
	{
		$condicion="idarticulo=".$idarticulo." AND idimagen='".$idimg."'";
		//Define la instruccion SQL
		$cadenaSQL="SELECT nbre_archivo FROM imagenes WHERE ".$condicion." LIMIT 0, 1";
		//echo "Consulta: ".$cadenaSQL."<br>";
		//Ejecuta la instruccion contra la bd, si falla devuelve un error
		$idconsulta=mysql_query($cadenaSQL,$idcnn) or die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La consulta fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		if (!$idconsulta) //Pregunta si el identificador devuelve un valor que corresponda a una ejecucion exitosa
		{
			die("<span style=\"vertical-align:bottom;\"><i><b><font size=\"+1\" color=\"#FF0000\">Error ".mysql_errno().": La consulta fall&oacute;: ".mysql_error()."</font></b></i></span><br>\n");
		}
		else
		{
			$res = mysql_fetch_assoc($idconsulta);
			if ($res["nbre_archivo"] != '' || !is_null($res["nbre_archivo"]))
			{
				$foto = "upload_archivos/img_articulos/".$res["nbre_archivo"];
			}
			else  //Sino encuentra una imagen devuelve la por defecto
			{
				if (strpos($idimg,"A") > 0)
				{
					$foto="imagenes/SinFoto.jpg";
				}else
				{
					$foto=false;
				}
			}
			return $foto;
		}
		//Libera la consulta de la mem.
		mysql_free_result($idconsulta);
		//Cierra la conexion
		mysql_close();
	}
}


//------------------------------------------------------------------------------------------------------------------------------------------------------

function clasificar($pidarticulo)
{
     include_once('cnn.php');
     $conexion= cnn('localhost','mundomed_anonimo','123456','mundomed_web','3306');
     if ($conexion[0]>=0 and $conexion[1]<> '')  //Pregunta si contienen valores vlidos
     {

     $sql = "SELECT * FROM ranking WHERE idranking = ".$pidarticulo;
     $rs = mysql_query($sql,$conexion[0]) or die(mysql_error());
     $row = mysql_fetch_object($rs);
     $valoracionN_total = @round($row->puntos/$row->num_votos,2);

     if(isset($_POST["cbovalor"]))
     {
         if (mysql_num_rows($rs) == 0)
         {
             @mysql_query("INSERT INTO ranking (`idranking`, `num_votos`, `puntos`) VALUES(".$_POST['txthid'].", 1, ".$_POST['cbovalor'].")", $conexion[0]) or die("Error al insertar un registro: ".mysql_error());
         }
         else
         {
             @mysql_query("UPDATE ranking SET num_votos = num_votos + 1, puntos = puntos + ".$_POST["cbovalor"]." WHERE idranking = ".$_POST["txthid"],$conexion[0]) or die('Error al modificar registro: '.mysql_error());
         }
         //header('Location:'.$_SERVER['REQUEST_URI']);
         echo "<script language=\"javascript\"> window.open('".$_SERVER['REQUEST_URI']."','mainFrame'); </script>";
         exit;
     }
     $clas="";
     switch ($valoracionN_total)
     { 
         case 0:
              $clas .= "<img src=\"imagenes/V_0.gif\" width=\"100\" height=\"25\" alt=\"Valoración Media: ".$valoracionN_total."\">";
              break;
         case 1:
              $clas .= "<img src=\"imagenes/V_1.gif\" width=\"100\" height=\"25\"  alt=\"Valoración Media: ".$valoracionN_total."\">";
              break;
         case 2:
              $clas .= "<img src=\"imagenes/V_2.gif\" width=\"100\" height=\"25\"  alt=\"Valoración Media: ".$valoracionN_total."\">";
              break;
         case 3:
              $clas .= "<img src=\"imagenes/V_3.gif\"  width=\"100\" height=\"25\"  alt=\"Valoración Media: ".$valoracionN_total."\">";
              break;
         case 4:
              $clas .= "<img src=\"imagenes/V_4.gif\" width=\"100\" height=\"25\"  alt=\"Valoración Media: ".$valoracionN_total."\">";
              break;
         case 5:
              $clas .= "<img src=\"imagenes/V_5.gif\" width=\"100\" height=\"25\"  alt=\"Valoración Media: ".$valoracionN_total."\">";
              break;
         case 6:
              $clas .= "<img src=\"imagenes/V_6.gif\" width=\"100\" height=\"25\"  alt=\"Valoración Media: ".$valoracionN_total."\">";
              break;
         case 7:
              $clas .= "<img src=\"imagenes/V_7.gif\" width=\"100\" height=\"25\"  alt=\"Valoración Media: ".$valoracionN_total."\">";
              break;
         case 8:
              $clas .= "<img src=\"imagenes/V_8.gif\" width=\"100\" height=\"25\"  alt=\"Valoración Media: ".$valoracionN_total."\">";
              break;
         case 9:
              $clas .= "<img src=\"imagenes/V_9.gif\" width=\"100\" height=\"25\"  alt=\"Valoración Media: ".$valoracionN_total."\">";
              break;
         case 10:
              $clas .= "<img src=\"imagenes/V_10.gif\" width=\"100\" height=\"25\"  alt=\"Valoración Media: ".$valoracionN_total."\">";
              break;
     }
}
     //echo '<strong> Valoración Media: '.$valoracionN_total.'</strong><div style="background-color:#EFEFEF; width:50px"><img width="'.($valoracionN_total * 5).'" height="6" style="background-color:"#000099"></div><br>Total de votos: '.$row[num_votos];

  $clas .= "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\">";
  $clas .= "<select name=\"cbovalor\" id=\"valor\">";
  for($i=1;$i<=10;$i++)
  {
       $clas .= "<option value=\"".$i."\">".$i."</option>";
  }
  $clas .= "</select>";
  $clas .= "<input type=\"hidden\" name=\"txthid\" value=\"".$pidarticulo."\"/>";
  $clas .= "&nbsp;<input type=\"submit\" value=\"Votar\">";
  $clas .= "</form>";
  return $clas;
}

?>