<?php
	ini_set('memory_limit','200M');
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_aux.inc';
	include 'inc/funciones_sensores.inc';
	
	$cliente_db = $_GET["cliente_db"];
	$instalacion = $_GET["instalacion_id"];
	$gw_id = $_GET["gw_id"];
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($cliente_db, $link);
	
	for ($iInd=0;$iInd<10;$iInd++)
	{
		$operacion[$iInd] = '0';
		$nodoIN[$iInd] = '000';
		$sensorIN[$iInd] = '0';
		$evento[$iInd] = '000';
		$nodoOUT[$iInd] = '000';
		$sensorOUT[$iInd] = '0';
	}

	$query = sprintf("SELECT gw_telemando00,gw_telemando01,gw_telemando02,gw_telemando03,gw_telemando04,gw_telemando05,gw_telemando06,gw_telemando07,gw_telemando08,gw_telemando09 FROM cliente_params_gw where instalacion_id='%s' AND gw_id='%s';", $instalacion, $gw_id);
	$result = mysql_query($query,$link);
	if(!$result)
	{
		?><script> alert("<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_query_db'];?> 1"); </script><?
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			for ($iInd=0;$iInd<10;$iInd++)
			{
				//echo $row['gw_telemando0'.$iInd].'<br/>';
				if (strlen($row['gw_telemando0'.$iInd]) == 13)
				{
					$habilitado[$iInd] = substr($row['gw_telemando0'.$iInd], 0, 1);
					$nodoIN[$iInd] = substr($row['gw_telemando0'.$iInd], 1, 3);
					$sensorIN[$iInd] = substr($row['gw_telemando0'.$iInd], 4, 1);
					$evento[$iInd] = substr($row['gw_telemando0'.$iInd], 5, 3);
					$nodoOUT[$iInd] = substr($row['gw_telemando0'.$iInd],8, 3);
					$sensorOUT[$iInd] = substr($row['gw_telemando0'.$iInd], 11, 1);
					$operacion[$iInd] = substr($row['gw_telemando0'.$iInd], 12, 1);
				}
			}
		}
	}
	mysql_free_result($result);
	mysql_close($link);
	
	$sResultado = "<telemando>";
	for ($iInd=0;$iInd<10;$iInd++)
	{
		switch ($habilitado[$iInd])
		{
			case '1':
				switch ($operacion[$iInd])
				{
					case '1':
						$sResultado .= "<parametro><nombre>on".($iInd+1)."</nombre><valor>1</valor></parametro>";
						$sResultado .= "<parametro><nombre>off".($iInd+1)."</nombre><valor>0</valor></parametro>";
						break;
					case '0':
					default:	
						$sResultado .= "<parametro><nombre>on".($iInd+1)."</nombre><valor>0</valor></parametro>";
						$sResultado .= "<parametro><nombre>off".($iInd+1)."</nombre><valor>1</valor></parametro>";
						break;
				}
				$sResultado .= "<parametro><nombre>devin".($iInd+1)."</nombre><valor>".$nodoIN[$iInd]."</valor></parametro>";
				$sResultado .= "<parametro><nombre>in".($iInd+1)."</nombre><valor>".$sensorIN[$iInd]."</valor></parametro>";
				$sResultado .= "<parametro><nombre>evento".($iInd+1)."</nombre><valor>".$evento[$iInd]."</valor></parametro>";
				$sResultado .= "<parametro><nombre>devout".($iInd+1)."</nombre><valor>".$nodoOUT[$iInd]."</valor></parametro>";
				$sResultado .= "<parametro><nombre>out".($iInd+1)."</nombre><valor>".$sensorOUT[$iInd]."</valor></parametro>";
				break;
			case '0':
			default:
				$sResultado .= "<parametro><nombre>on".($iInd+1)."</nombre><valor>0</valor></parametro>";
				$sResultado .= "<parametro><nombre>off".($iInd+1)."</nombre><valor>0</valor></parametro>";
				break;
		}
	}
	$sResultado .= "</telemando>";
	echo $sResultado;
?>
