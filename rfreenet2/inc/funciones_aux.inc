<?php

function pad_izquierda($cadena,$lon,$caracter)
{
	$iIndice=0;
	$sAuxiliar = '';
	//alert('Padding ' + cadena + " from " +cadena.length+ " to " + lon + " with " + caracter);
	if ($lon > (strlen($cadena)))
	{
		//$iIndice=$lon - strlen($cadena);
		for ($iIndice=0; $iIndice<($lon - strlen($cadena));$iIndice++)
		{
			$sAuxiliar .= $caracter;
		}
		$sAuxiliar.=$cadena;
	}
	else
	{
		$sAuxiliar=$cadena;
	}
	return $sAuxiliar;
}

function table_exists ($tabla, $linkito) 
{ 
	$resultado = mysql_query("SHOW TABLES LIKE '".$tabla."'", $linkito);

	if ($resultado)
	{
		if(mysql_num_rows($resultado))
		{
			return TRUE;
		}
		else
		{						
			return FALSE;
		}
	}
	else
	{
		return FALSE;
	}
}
function table_exists_i ($tabla, $linkito) //AMB 11/09/2012 Función para comprobar la existencia de una tabla pero con mysqli en lugar de mysql
{ 
	$resultado = mysqli_query($linkito, "SHOW TABLES LIKE '".$tabla."'");
	
	if ($resultado)
	{
		if(mysqli_num_rows($resultado))
		{
			return TRUE;
		}
		else
		{						
			return FALSE;
		}
	}
	else
	{
		return FALSE;
	}
}

function sConvertirCharSensor($iSensorEntrada)
{
	switch ($iSensorEntrada)
	{
		case 16:
			return 'G';
			
		case 17:
			return 'H';
			
		case 18:
			return 'I';

		case 0:
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 7:
		case 8:
		case 9:
		case 10:
		case 11:
		case 12:
		case 13:
		case 14:
		case 15:
		default:
			return strtoupper(dechex($iSensorEntrada));
			break;		
	}
}
function trama_corto($cadena)
{
	include 'idiomas.inc';
	
	switch ($cadena[0])
	{
		case 'L':
			switch ($cadena[5])
			{
				case 'N':
					return $idiomas[$_SESSION['opcion_idioma']]['general285'];
					break;
				default:
					return $idiomas[$_SESSION['opcion_idioma']]['general273'];
					break;
			}
			break;
		case 'M':
			switch ($cadena[5])
			{
				case 'N':
					return $idiomas[$_SESSION['opcion_idioma']]['general286'];
					break;
				default:
					return $idiomas[$_SESSION['opcion_idioma']]['general274'];
					break;
			}
			break;
		case 'W':
			switch ($cadena[5])
			{
				case 'N':
					return $idiomas[$_SESSION['opcion_idioma']]['general286'];
					break;
				default:
					return $idiomas[$_SESSION['opcion_idioma']]['general274'];
					break;
			}
			break;			
		case 'N':
			switch ($cadena[5])
			{
				case 'D':
					return $idiomas[$_SESSION['opcion_idioma']]['general287'];
					break;
				default:
					return $idiomas[$_SESSION['opcion_idioma']]['general275'];
					break;
			}
			break;
		case 'P':
			switch ($cadena[5])
			{
				case 'N':
					return $idiomas[$_SESSION['opcion_idioma']]['general288'];
					break;
				default:
					return $idiomas[$_SESSION['opcion_idioma']]['general276'];
					break;
			}
		case 'E':
		case 'A':
			switch ($cadena[5])
			{
				case 'N':
					return $idiomas[$_SESSION['opcion_idioma']]['general289'];
					break;
				default:
					return $idiomas[$_SESSION['opcion_idioma']]['general277'];
					break;
			}
			break;
		case 'R':
			switch ($cadena[5])
			{
				case 'N':
					return $idiomas[$_SESSION['opcion_idioma']]['general364'];
					break;
				default:
					return $idiomas[$_SESSION['opcion_idioma']]['general282'];
					break;
			}			
			break;	
		case 'K':
			return $idiomas[$_SESSION['opcion_idioma']]['general363'];			
			break;
		case 'U':
			return $idiomas[$_SESSION['opcion_idioma']]['general50']." ".$idiomas[$_SESSION['opcion_idioma']]['general32'];			
			break;
		case 'B':
			return $idiomas[$_SESSION['opcion_idioma']]['general54']." ".$idiomas[$_SESSION['opcion_idioma']]['general32'];
			break;
		case 'D':
			return $idiomas[$_SESSION['opcion_idioma']]['general56']." ".$idiomas[$_SESSION['opcion_idioma']]['general32'];
			break;
		case 'I':
			return $idiomas[$_SESSION['opcion_idioma']]['general279'];
			break;		
		case 'i':
			return $idiomas[$_SESSION['opcion_idioma']]['general281'];
			break;
		case 'T':
			return $idiomas[$_SESSION['opcion_idioma']]['general365'];
			break;
		case 'O':
			switch ($cadena[5])
			{
				case 'N':
					return $idiomas[$_SESSION['opcion_idioma']]['nodo_text1'].' O'.$cadena[9];
					break;
				default:
					return $idiomas[$_SESSION['opcion_idioma']]['gw_text1'].' O'.$cadena[5];
					break;
			}
			break;
		case 'm':
			switch ($cadena[11])
			{
				case '1':
					return $idiomas[$_SESSION['opcion_idioma']]['general368'];
					break;
				default:
					return $idiomas[$_SESSION['opcion_idioma']]['general367'];
					break;
			}
			break;
		case 'c':
			switch ($cadena[5])
			{
				case 'B':
					return $idiomas[$_SESSION['opcion_idioma']]['general371'];
					break;
				default:
					return $idiomas[$_SESSION['opcion_idioma']]['general370'];
					break;
			}
			break;
		case 'Q':
			return $idiomas[$_SESSION['opcion_idioma']]['general374'].' '.$cadena[6];
			break;
		case 'G':
			return $idiomas[$_SESSION['opcion_idioma']]['general375'].' '.$cadena[13];
			break;
		case 'F':
			return $idiomas[$_SESSION['opcion_idioma']]['general376'].' '.$cadena[13];
			break;
		default:
			return $cadena;
			
	}
}
?>