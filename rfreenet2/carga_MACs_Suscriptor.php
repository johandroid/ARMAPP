<?
	include 'inc/datos_db.inc';

	$sus_id = $_GET['gw_id'];
	
	$OpcionesSalida = "ERROR";
	$primera_vuelta = 0;

	$mysql = mysql_connect($db_host, $db_user, $db_pass);
	if(!$mysql)
	{
		echo $OpcionesSalida;
	}
	
	// Buscamos la db de ese cliente
	$selected = mysql_select_db($db_name_clientes,$mysql);
	if(!$selected)
	{
		mysql_close($mysql);
		echo $OpcionesSalida;
	}

	//Consultar la base de datos
	$query = sprintf("select cliente_db from (clientes_datos inner join clientes_suscriptores on clientes_datos.cliente_id=clientes_suscriptores.cliente_id) where clientes_suscriptores.gw_id='%s';",$sus_id);
	//echo $query;
	$result = mysql_query($query,$mysql);
	if(!$result)
	{
		mysql_close($mysql);
		echo $OpcionesSalida;
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
				mysql_close($mysql);
				echo $OpcionesSalida;
			}
			$OpcionesSalida = utf8_decode("<option selected='true' value=\"000000000000\">&nbsp;&nbsp;&nbsp;&nbsp;(Gateway)</option>");
			
			//Consultar la base de datos
			$query = sprintf("SELECT nodo_mac FROM cliente_nodos WHERE gw_id='%s';", $sus_id);
			//echo $query;
			$result = mysql_query($query,$mysql);
			if(!$result)
			{
				mysql_close($mysql);
				echo $OpcionesSalida;
			}
			else
			{
				while($row = mysql_fetch_array($result))
				{
					//echo $row[0];
					$OpcionesSalida = $OpcionesSalida . sprintf("<option value=\"%s\">%s</option>", $row[0], $row[0]);
				}
			
				mysql_free_result($result);
				mysql_close($mysql);
				echo $OpcionesSalida;
			}
		}
		else
		{
			mysql_close($mysql);
			echo $OpcionesSalida;
		}
	}
?>