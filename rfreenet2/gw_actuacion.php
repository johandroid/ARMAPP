<?php
	session_start();
	ini_set('memory_limit','200M');
	include 'inc/comunica.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_db.inc';
	include 'inc/funciones_medidas.inc';
	
	$gw_id=$_GET['gw_id'];
	$gw_send=$_GET['gw_send'];
	$gw_out=$_GET['gw_out'];
	$offline=$_GET['offline'];
	
	if ($offline != 0)
	{
		$link = mysql_connect($db_host, $db_user, $db_pass);
		mysql_select_db($_SESSION['cliente_db'], $link);
	}

	$xml_lectura="<Gateway>";	
	for($i=1;$i<4;$i++)
	{
		if ($gw_send[$i-1]==1)
		{
			// Enviamos trama de modificacion
			if ($offline == 0)
			{
				$sTramaLeida=conectar('O'.$gw_id.$i.$gw_out[$i-1]);
			}
			else 
			{
				$sTramaLeida='O'.$gw_id.$i.$gw_out[$i-1];
				$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','000','%s',NOW());",  $gw_id, $sTramaLeida);
				//echo $query;
				mysql_query($query,$link) or die(mysql_error());
			}
			//echo $sTramaLeida."<br>";
		
			if ($sTramaLeida[0] == 'O')
			{
					$xml_lectura.="<parametro><nombre>OU".$i."</nombre><valor>".substr($sTramaLeida,6,1)."</valor></parametro>";
			}
			else
			{
				echo 'ERROR';
				return;
			}
			//sleep(2);
		}
	}
	$xml_lectura.="</Gateway>";
	if ($offline != 0)
	{
		mysql_close($link);
	}
		
	echo $xml_lectura;
?>
