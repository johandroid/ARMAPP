<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$cliente_id = $_GET["cliente_id"];

// Si son todos los clientes
$sResultado="<instalaciones>";
if ($cliente_id=='0000')
{
	mysql_select_db($db_name_clientes, $link);
	$query = "SELECT cliente_id FROM clientes_datos";;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		$sResultado="ERROR";
	}
	else
	{		
		while($row = mysql_fetch_array($result))
		{
			// obtenemos la DB del cliente
			mysql_select_db($db_name_clientes, $link);
			$id_cliente_actual=$row['cliente_id'];
			$query = sprintf("SELECT cliente_db FROM clientes_datos where cliente_id='%s'", $id_cliente_actual);
			$result = mysql_query($query,$link);
			if(!$result)
			{
				$sResultado="ERROR";
				break;
			}
			else if ($row = mysql_fetch_array($result))
			{	
				mysql_select_db($row['cliente_db'], $link);
				
				$query = "SELECT instalacion_id,instalacion_nombre FROM cliente_instalaciones";;
				$result = mysql_query($query,$link);
				if(!$result)
				{
					$sResultado="ERROR";
					break;
				}
				else
				{		
					$sResultado.="<instalacion id=\"0000\" nombre=\"Todas\" cliente=\"".$id_cliente_actual."\"></instalacion>";
					while($row = mysql_fetch_array($result))
					{
						$sResultado.="<instalacion id=\"";
						$sResultado.=$row['instalacion_id'];
						$sResultado.="\" nombre=\"";
						$sResultado.=$row['instalacion_nombre'];
						$sResultado.="\" cliente=\"";
						$sResultado.=$id_cliente_actual;
						$sResultado.="\" ></instalacion>";
					}
				}
			}
		}
		$sResultado.="</instalaciones>";
	}
}
// Para un cliente en particular, una sola query
else
{
	// obtenemos la DB del cliente
	mysql_select_db($db_name_clientes, $link);
	$query = sprintf("SELECT cliente_db FROM clientes_datos where cliente_id='%s'", $cliente_id);
	$result = mysql_query($query,$link);
	if(!$result)
	{
		$sResultado="ERROR";
	}
	else if ($row = mysql_fetch_array($result))
	{	
		mysql_select_db($row['cliente_db'], $link);
		
		$query = "SELECT instalacion_id,instalacion_nombre FROM cliente_instalaciones";;
		$result = mysql_query($query,$link);
		if(!$result)
		{
			$sResultado="ERROR";
		}
		else
		{		
			$sResultado.="<instalacion id=\"0000\" nombre=\"Todas\" cliente=\"".$cliente_id."\"></instalacion>";
			while($row = mysql_fetch_array($result))
			{
				$sResultado.="<instalacion id=\"";
				$sResultado.=$row['instalacion_id'];
				$sResultado.="\" nombre=\"";
				$sResultado.=$row['instalacion_nombre'];
				$sResultado.="\" cliente=\"";
				$sResultado.=$cliente_id;
				$sResultado.="\" ></instalacion>";
			}
			$sResultado.="</instalaciones>";	
		}
	}
}

echo $sResultado;

mysql_free_result($result);
mysql_close($link);
?>