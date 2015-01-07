<?php
session_start();
function iObtenerModoOffline()
{ 
	include 'inc/datos_db.inc';
	include 'inc/idiomas.inc';

	$OpcionesSalida = "1";

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return $OpcionesSalida;
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($db_name_general,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}

	//Consultar la base de datos
	$query = "Select config_offline from ".$tabla_name_config.";";
	//echo $query;
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			$OpcionesSalida = $row[0];
		}
	
		mysql_free_result($result);
		mysql_close($mysql);
		return intval($OpcionesSalida);
	}
}

function RellenarListaInstalaciones($cliente_db,$cliente_id)
{ 
	include 'inc/datos_db.inc';
	include 'inc/idiomas.inc';

	$OpcionesSalida = "";
	$primera_vuelta = 0;

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return $OpcionesSalida;
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($cliente_db,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}

	//Consultar la base de datos
	$query = "Select * from cliente_instalaciones;";
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			if ($primera_vuelta = 0)
			{
				$OpcionesSalida = $OpcionesSalida . sprintf("<option selected='true' value=\"%s\">%s</option>", $row[0], $row[1]);
				$primera_vuelta = 1;
			}
			else
			{
				$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"%s\">%s</option>", $row[0], $row[1]);
			}
		}
	
		mysql_free_result($result);
		mysql_close($mysql);
		return $OpcionesSalida;
	}
}

function RellenarListaInstalacionesCliente($cliente_id_install)
{
	include 'inc/datos_db.inc';
	include 'inc/idiomas.inc';

	$OpcionesSalida = "";
	$primera_vuelta = 0;

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return $OpcionesSalida;
	}
	
	// Buscamos la db de ese cliente
	$selected = mysql_select_db($db_name_clientes,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}

	//Consultar la base de datos
	$query = sprintf("select cliente_db from clientes_datos where cliente_id='%s';",$cliente_id_install);
	//echo $query;
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			$cliente_db=$row[0];
			//echo $cliente_db;
	
			//seleccionar la base de datos
			$selected = mysql_select_db($cliente_db,$mysql);
			if(!$selected)
			{
				?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
				mysql_close($mysql);
				return $OpcionesSalida;
			}
		
			//Consultar la base de datos
			$query = "Select * from cliente_instalaciones;";
			//echo $query;
			$result = mysql_query($query,$mysql);
			if(!$result)
			{
				?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?>"); </script><?
				mysql_close($mysql);
				return $OpcionesSalida;
			}
			else
			{
				while($row = mysql_fetch_array($result))
				{
					//echo $row[0];
					if ($primera_vuelta = 0)
					{
						$OpcionesSalida = $OpcionesSalida . sprintf("<option selected='true' value=\"%s\">%s</option>", $row[0], $row[1]);
						$primera_vuelta = 1;
					}
					else
					{
						$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"%s\">%s</option>", $row[0], $row[1]);
					}
				}
			
				mysql_free_result($result);
				mysql_close($mysql);
				return $OpcionesSalida;
			}
		}
		else
		{
			?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?>"); </script><?
			mysql_close($mysql);
			return $OpcionesSalida;
		}
	}
}

function RellenarListaClientes($iTodas)
{ 
	include 'inc/datos_db.inc';
	include 'inc/idiomas.inc';

	$OpcionesSalida = "";
	$primera_vuelta = 0;

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return $OpcionesSalida;
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($db_name_clientes,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}

	//Consultar la base de datos
	$query = "Select cliente_id,cliente_nombre from clientes_datos;";
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}
	else
	{
		if ($iTodas == 1)
		{
			$OpcionesSalida="<option selected='true' id=\"0000\">".$idiomas[$_SESSION['opcion_idioma']]['general154']."</option>";
		}
		else
		{
			$OpcionesSalida='';
		}
		while($row = mysql_fetch_array($result))
		{
			$OpcionesSalida = $OpcionesSalida . sprintf("<option id=\"%s\">%s</option>", $row[0], $row[1]);
		}
	
		mysql_free_result($result);
		mysql_close($mysql);
		return $OpcionesSalida;
	}
}

function RellenarListaSuscriptores()
{ 
	include 'inc/datos_db.inc';
	include 'inc/idiomas.inc';

	$OpcionesSalida = "";
	$primera_vuelta = 0;

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return $OpcionesSalida;
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($db_name_clientes,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}

	//Consultar la base de datos
	$query = "select gw_id from clientes_suscriptores;";
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"%s\" id=\"%s\">%s</option>", $row[0], $row[0], $row[0]);
		}
	
		mysql_free_result($result);
		mysql_close($mysql);
		return $OpcionesSalida;
	}
}

function RellenarListaEventos()
{
	session_start();
	include 'inc/datos_db.inc';
	include 'inc/idiomas.inc';

	$OpcionesSalida = "";
	$primera_vuelta = 0;

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?
		return $OpcionesSalida;
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($db_name_general,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}

	//Consultar la base de datos
	$query = "select evento_codigo,evento_texto from rfreenet_texto_eventos_".$_SESSION['opcion_idioma']." WHERE evento_codigo>5;";
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?>"); </script><?
		mysql_close($mysql);
		return $OpcionesSalida;
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			$OpcionesSalida = $OpcionesSalida . sprintf("<option id=\"%s\">%s (%s)</option>", $row[0], utf8_encode($row[1]), $row[0]);
		}
	
		mysql_free_result($result);
		mysql_close($mysql);
		return $OpcionesSalida;
	}
}

function Mostrar_Nivel_Privilegios($iNivelNumerico)
{
	include 'inc/idiomas.inc';
	
	switch($iNivelNumerico)
	{
		case '0':
			return $idiomas[$_SESSION['opcion_idioma']]['user_superadmin'];
			break;	
		case '1':
			return $idiomas[$_SESSION['opcion_idioma']]['user_admin'];
			break;	
		case '2':
			return $idiomas[$_SESSION['opcion_idioma']]['user_oper'];
			break;	
		case '3':
			return $idiomas[$_SESSION['opcion_idioma']]['user_visit'];
			break;	
	}
}
function Rellenar_Filtro_Sensores_Informes()
{
	include 'inc/idiomas.inc';
	
	$OpcionesSalida="";
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"tot\" id=\"tot\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type0']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"hum\" id=\"hum\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type1']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"tem\" id=\"tem\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type2']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"con\" id=\"con\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type3']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"ana\" id=\"ana\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type4']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"dig\" id=\"dig\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type5']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"plu\" id=\"plu\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type6']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"ane\" id=\"ane\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type7']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"vel\" id=\"vel\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type8']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"pul\" id=\"pul\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type9']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"420\" id=\"420\">%s</option>", "4-20mA");
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"010\" id=\"010\">%s</option>", "0..10V");
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"dou\" id=\"dou\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type12']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"flu\" id=\"flu\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type13']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"pre\" id=\"pre\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type22']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"prb\" id=\"prb\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type22']." (Ba)");
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"cor\" id=\"cor\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type25']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"pot\" id=\"pot\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type45']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"fpo\" id=\"fpo\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type29']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"fre\" id=\"fre\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type31']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"ene\" id=\"ene\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type46']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"thd\" id=\"thd\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type47']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"oxd\" id=\"oxd\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type20']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"tur\" id=\"tur\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type23']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"orp\" id=\"orp\">%s</option>", "ORP");
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"amr\" id=\"amr\">%s</option>", "AMR");
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"pyr\" id=\"pyr\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type21']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"clo\" id=\"clo\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type52']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"sph\" id=\"sph\">%s</option>", "pH");
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"err\" id=\"err\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['general302']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"ala\" id=\"ala\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['general303']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"war\" id=\"war\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['general304']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"niv\" id=\"niv\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type17']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"air\" id=\"air\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type51']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"dou\" id=\"dou\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type12']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"rot\" id=\"rot\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type19']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"eva\" id=\"eva\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type86']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"bat\" id=\"bat\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['supply2']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"cog\" id=\"cog\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['event_cob_gprs']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"cau\" id=\"cau\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type87']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"mts\" id=\"mts\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type90']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"mms\" id=\"mms\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['sensor_type89']);
	return $OpcionesSalida;
}

function Rellenar_Combo_Idiomas()
{
	include 'inc/idiomas.inc';
	
	$OpcionesSalida="";
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"es\" id=\"es\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['idioma_text1']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"en\" id=\"en\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['idioma_text2']);
	$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"fr\" id=\"fr\">%s</option>", $idiomas[$_SESSION['opcion_idioma']]['idioma_text3']);
	return $OpcionesSalida;
}

function Rellenar_Zonas_Horarias()
{
	$list = DateTimeZone::listAbbreviations();
	//echo "1->".count($list);
    $idents = DateTimeZone::listIdentifiers();
    /*static $regions = array(
	    'Africa' => DateTimeZone::AFRICA,
	    'America' => DateTimeZone::AMERICA,
	    'Antarctica' => DateTimeZone::ANTARCTICA,
	    'Asia' => DateTimeZone::ASIA,
	    'Atlantic' => DateTimeZone::ATLANTIC,
	    'Europe' => DateTimeZone::EUROPE,
	    'Indian' => DateTimeZone::INDIAN,
	    'Pacific' => DateTimeZone::PACIFIC
	);*/
	//echo "1";
	/*foreach ($regions as $name => $mask) {
	    $idents[] = DateTimeZone::listIdentifiers($mask);
	}*/
	//echo "2->".count($idents);
    $data = $offset = $added = array();
	//echo "3";
    foreach ($list as $abbr => $info) 
    {
        foreach ($info as $zone) 
        {
        	//echo "Una zona ".($zone['timezone_id']);
            if ( ! empty($zone['timezone_id']) &&  !in_array($zone['timezone_id'], $added) && in_array($zone['timezone_id'], $idents)) 
          	{
                $z = new DateTimeZone($zone['timezone_id']);
                $c = new DateTime(null, $z);
                $zone['time'] = $c->format('H:i a');
				$zone['offset'] = $c->format('Z');
                $data[] = $zone;
                //$offset[] = $z->getOffset($c);
                //echo $c->format('Z')."<br>";
                $offset[] = $c->format('Z');
                $added[] = $zone['timezone_id'];
            }
        }
    }
	//print_r($offset);
	// var_dump($data);
    array_multisort($offset, SORT_ASC, $data);
	//var_dump($offset);
	//var_dump($data);
    $options = array();
    foreach ($data as $key => $row) 
    {
        $options[$row['timezone_id']] = $row['time'] . ' - '. formatOffset($row['offset'])/*$row['offset']*/.' '.$row['timezone_id'];
    }

	//print_r($options);
	foreach ($options as $key => $value)
	//foreach ($data as $key => $value)
	{
		//print_r($value);
		$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"%s\">%s</option>",$key,$value);
		//$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"%s\">%s</option>",$value['timezone_id'],$value['timezone_id']);
	}
	
	return $OpcionesSalida;
}

function formatOffset($offset) 
{
    $hours = $offset / 3600;
    $remainder = $offset % 3600;
    $sign = $hours > 0 ? '+' : '-';
    $hour = (int) abs($hours);
    $minutes = (int) abs($remainder / 60);

    if ($hour == 0 AND $minutes == 0) 
    {
        $sign = ' ';
    }
    return 'UTC' .$sign . str_pad($hour, 2, '0', STR_PAD_LEFT).':'. str_pad($minutes,2, '0');
}

function RellenarEventosNotificacion()
{
	session_start();
	include 'inc/datos_db.inc';
	include 'inc/idiomas.inc';

	$OpcionesSalida = "";
	$primera_vuelta = 0;

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?>"); </script><?php
		return $OpcionesSalida;
	}

	//seleccionar la base de datos
	$selected = mysql_select_db($db_name_general,$mysql);
	if(!$selected)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?>"); </script><?php
		mysql_close($mysql);
		return $OpcionesSalida;
	}

	//Consultar la base de datos
	$query = "select evento_codigo,evento_texto from rfreenet_texto_eventos_".$_SESSION['opcion_idioma']." where evento_codigo='006' OR evento_codigo='016' OR evento_codigo='020' OR evento_codigo='007'OR evento_codigo='008' OR evento_codigo='009' order by evento_codigo;";
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?>"); </script><?php
		mysql_close($mysql);
		return $OpcionesSalida;
	}
	else
	{
		$OpcionesSalida = array();
		while($row = mysql_fetch_array($result))
		{
			$OpcionesSalida[] = array($row[0], utf8_encode($row[1]));
		}
	
		mysql_free_result($result);
		mysql_close($mysql);
		return $OpcionesSalida;
	}
}

function Rellenar_VersionesHW_GW()
{
	include 'inc/idiomas.inc';
	
	$OpcionesSalida="";
	$OpcionesSalida = $OpcionesSalida . "<option value=\"12\" id=\"12\">12</option>";
	$OpcionesSalida = $OpcionesSalida . "<option value=\"11\" id=\"11\">11</option>";
	$OpcionesSalida = $OpcionesSalida . "<option value=\"10\" id=\"10\">10</option>";
	return $OpcionesSalida;
}
function Rellenar_VersionesSW_GW()
{
	include 'inc/idiomas.inc';
	
	$OpcionesSalida="";
	$OpcionesSalida = $OpcionesSalida . "<option value=\"1002\" id=\"1002\">1002</option>";
	$OpcionesSalida = $OpcionesSalida . "<option value=\"1001\" id=\"1001\">1001</option>";
	$OpcionesSalida = $OpcionesSalida . "<option value=\"1000\" id=\"1000\">1000</option>";
	return $OpcionesSalida;
}
function Rellenar_VersionesHW_GW_LOW()
{
	include 'inc/idiomas.inc';
	
	$OpcionesSalida="";
	$OpcionesSalida = $OpcionesSalida . "<option value=\"11\" id=\"11\">11</option>";
	$OpcionesSalida = $OpcionesSalida . "<option value=\"10\" id=\"10\">10</option>";
	return $OpcionesSalida;
}
function Rellenar_VersionesSW_GW_LOW()
{
	include 'inc/idiomas.inc';
	
	$OpcionesSalida="";
	$OpcionesSalida = $OpcionesSalida . "<option value=\"1001\" id=\"1001\">1001</option>";
	$OpcionesSalida = $OpcionesSalida . "<option value=\"1000\" id=\"1000\">1000</option>";
	return $OpcionesSalida;
}

function RellenarListaDispositivosEntradaTelemando($instalacion_id_tm, $gw_id_tm)
{
	session_start();
	include 'inc/datos_db.inc';
	include 'inc/idiomas.inc';

	$OpcionesSalida = "";

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?> 1"); </script><?
	}
	else 
	{
		// Buscamos la db de ese cliente
		$selected = mysql_select_db($_SESSION["cliente_db"],$mysql);
		if(!$selected)
		{
			?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?> 2"); </script><?
		}
		else
		{
			//Consultar la base de datos
			$query = sprintf("SELECT gw_nombre,gw_TS1,gw_TS2,gw_TS3,gw_TS4,gw_TS5,gw_TS6,gw_TS7,gw_TS8,gw_TS9 FROM cliente_params_gw where instalacion_id='%s' AND gw_id='%s';", $instalacion_id_tm, $gw_id_tm);
			$result = mysql_query($query,$mysql);
			if(!$result)
			{
				?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?> 3"); </script><?
			}
			else
			{
				if($row = mysql_fetch_array($result))
				{
					$iAnyadirD = 0;
					if ($row['gw_nombre'] != '')
					{
						$etiqueta = $row['gw_nombre'];
					}
					else
					{
						$etiqueta = $idiomas[$_SESSION['opcion_idioma']]['general20']." ".$gw_id_tm;
					}
					for ($iInd=1;$iInd<10;$iInd++)
					{
						// Si es telemando, añadimos el dispositivo directamente
						$iValor = intval($row['gw_TS'.$iInd]);
						if (($iValor > 0) && ($iValor != 27) && ($iValor != 28) && ($iValor != 29))
						{
							$iAnyadirD = 1;
							break;
						}
					}
					if ($iAnyadirD == 1)
					{
						$OpcionesSalida .= sprintf("<option value=\"%s\">%s</option>", "000", $etiqueta);
					}
				
					// Y ahora extraemos todos los nodos que tengan salidas digitales de telemando configuradas
					$query = sprintf("Select gw_id,nodo_mac,nodo_ip,nodo_nombre,nodo_SEN,nodo_TS1,nodo_TS2,nodo_TS3,nodo_TS4,nodo_TS5,nodo_TS6 from cliente_params_nodo where instalacion_id='%s' AND gw_id='%s' ORDER BY nodo_nombre;", $instalacion_id_tm, $gw_id_tm);
					$result = mysql_query($query,$mysql);
					if(!$result)
					{
						?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?> 4"); </script><?
					}
					else
					{
						while($row = mysql_fetch_array($result))
						{
							if ($row['nodo_nombre'] != '')
							{
								$etiqueta = $row['nodo_nombre'];
							}
							else
							{
								$etiqueta = $idiomas[$_SESSION['opcion_idioma']]['general21']." ".$row['nodo_mac'];
							}
							$iAcum=intval($row['nodo_SEN']);
							$iAnyadirD = 0;
							for ($iInd=0;$iInd<6;$iInd++)
							{
								$iParcial=intval($iAcum/(pow(2,(5-$iInd))));
								$iResto=$iAcum%(pow(2,(5-$iInd)));
								if ($iParcial==1)
								{
									// Si no es salida digital, añadimos el dispositivo directamente
									if (substr($row['nodo_TS'.(6-$iInd)], 0 ,1) != '5')
									{
										$iAnyadirD = 1;
										break;
									}
								}
								$iAcum=$iResto;
							}
							if ($iAnyadirD == 1)
							{
								$OpcionesSalida .= sprintf("<option value=\"%s\">%s</option>", $row['nodo_ip'], $etiqueta);
							}
						}
					}
				}
			}
		}
	}
	mysql_free_result($result);
	mysql_close($mysql);
	return $OpcionesSalida;
}

function RellenarListaDispositivosSalidaTelemando($instalacion_id_tm, $gw_id_tm)
{
	session_start();
	include 'inc/datos_db.inc';
	include 'inc/idiomas.inc';

	$OpcionesSalida = "";

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];?> 1"); </script><?
	}
	else 
	{
		// Buscamos la db de ese cliente
		$selected = mysql_select_db($_SESSION["cliente_db"],$mysql);
		if(!$selected)
		{
			?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_select_db'];?> 2"); </script><?
		}
		else
		{
			//Consultar la base de datos
			$query = sprintf("SELECT gw_nombre,gw_TS1,gw_TS2,gw_TS3,gw_TS4,gw_TS5,gw_TS6,gw_TS7,gw_TS8,gw_TS9 FROM cliente_params_gw where instalacion_id='%s' AND gw_id='%s';", $instalacion_id_tm, $gw_id_tm);
			$result = mysql_query($query,$mysql);
			if(!$result)
			{
				?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?> 3"); </script><?
			}
			else
			{
				if($row = mysql_fetch_array($result))
				{
					$iAnyadirD = 0;
					if ($row['gw_nombre'] != '')
					{
						$etiqueta = $row['gw_nombre'];
					}
					else
					{
						$etiqueta = $idiomas[$_SESSION['opcion_idioma']]['general20']." ".$gw_id_tm;
					}
					for ($iInd=1;$iInd<10;$iInd++)
					{
						// Si es telemando, añadimos el dispositivo directamente
						$iValor = intval($row['gw_TS'.$iInd]);
						if (($iValor == 27) || ($iValor == 28) || ($iValor == 29))
						{
							$iAnyadirD = 1;
							break;
						}
					}
					if ($iAnyadirD == 1)
					{
						$OpcionesSalida .= sprintf("<option value=\"%s\">%s</option>", "000", $etiqueta);
					}
				
					// Y ahora extraemos todos los nodos que tengan salidas digitales de telemando configuradas
					$query = sprintf("Select gw_id,nodo_mac,nodo_ip,nodo_nombre,nodo_SEN,nodo_TS1,nodo_TS2,nodo_TS3,nodo_TS4,nodo_TS5,nodo_TS6 from cliente_params_nodo where instalacion_id='%s' AND gw_id='%s' AND nodo_RS1='62' ORDER BY nodo_nombre;", $instalacion_id_tm, $gw_id_tm);
					$result = mysql_query($query,$mysql);
					if(!$result)
					{
						?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?> 4"); </script><?
						mysql_close($mysql);
						return $OpcionesSalida;
					}
					else
					{
						while($row = mysql_fetch_array($result))
						{
							if ($row['nodo_nombre'] != '')
							{
								$etiqueta = $row['nodo_nombre'];
							}
							else
							{
								$etiqueta = $idiomas[$_SESSION['opcion_idioma']]['general21']." ".$row['nodo_mac'];
							}
							$iAcum=intval($row['nodo_SEN']);
							$iAnyadirD = 0;
							for ($iInd=0;$iInd<6;$iInd++)
							{
								$iParcial=intval($iAcum/(pow(2,(5-$iInd))));
								$iResto=$iAcum%(pow(2,(5-$iInd)));
								if ($iParcial==1)
								{
									// Si no es salida digital, añadimos el dispositivo directamente
									if (substr($row['nodo_TS'.(6-$iInd)], 0 ,1) == '5')
									{
										$iAnyadirD = 1;
										break;
									}
								}
								$iAcum=$iResto;
							}
							if ($iAnyadirD == 1)
							{
								$OpcionesSalida .= sprintf("<option value=\"%s\">%s</option>", $row['nodo_ip'], $etiqueta);
							}
						}
					}
				}
			}
		}
	}
	mysql_free_result($result);
	mysql_close($mysql);
	return $OpcionesSalida;
}
?>
