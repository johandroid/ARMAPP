<?php
	ini_set('memory_limit','200M');
	include 'inc/datos_db.inc';
	include 'inc/funciones_medidas.inc';
	include 'inc/funciones_db.inc';
	
	$cliente_db = $_GET["cliente_db"];
	$gw_id=$_GET['gw_id'];
	
	$link = mysql_connect($db_host, $db_user, $db_pass);	
	
	mysql_select_db($db_name_clientes, $link);
	$query = sprintf("SELECT gw_tipo FROM clientes_suscriptores WHERE gw_id='%s'",$gw_id);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR 1";
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			$gw_tipo = $row['gw_tipo'];
		}
		mysql_free_result($result);
		
		mysql_select_db($cliente_db, $link);
		
		echo "<Gateway>";
		echo "<parametro><nombre>GTI</nombre><valor>".$gw_tipo."</valor></parametro>";
		// Si es un GW normal
		if ($gw_tipo == $tipo_gw)
		{
			$query = sprintf("SELECT gw_versionHW, gw_versionSW FROM cliente_params_gw WHERE gw_id='%s'",$gw_id);
			//echo $query;
			$result = mysql_query($query,$link);
			if(!$result)
			{
				echo "ERROR 2";
			}
			else
			{
				if($row = mysql_fetch_array($result))
				{
					
					echo "<parametro><nombre>VHW</nombre><valor>".$row['gw_versionHW']."</valor></parametro>";
					echo "<parametro><nombre>VSW</nombre><valor>".$row['gw_versionSW']."</valor></parametro>";					
				}
				else
				{
					echo "ERROR 3";
				}
			}
		}
		// Si es LP
		else
		{
			echo "<parametro><nombre>VHW</nombre><valor>10</valor></parametro>";
			echo "<parametro><nombre>VSW</nombre><valor>1002</valor></parametro>";
		}
		echo "</Gateway>";
	}
	mysql_free_result($result);
	mysql_close($link);			
?>
