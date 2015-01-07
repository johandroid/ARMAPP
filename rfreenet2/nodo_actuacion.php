<?php
session_start();
	ini_set('memory_limit','200M');
	include 'inc/datos_db.inc';
	include 'inc/funciones_db.inc';
	include 'inc/comunica.inc';
	include 'inc/funciones_medidas.inc';
	
	$gw_id=$_GET['gw_id'];
	$nodo_ip=$_GET['nodo_ip'];
	$nodo_send=$_GET['nodo_send'];
	$nodo_out=$_GET['nodo_out'];
	$offline=$_GET['offline'];
	
	if ($offline != 0)
	{
		$link = mysql_connect($db_host, $db_user, $db_pass);
		mysql_select_db($_SESSION['cliente_db'], $link);
	}

	$xml_lectura="<Gateway>";	
	for($i=1;$i<7;$i++)
	{
		if ($nodo_send[$i-1]==1)
		{
			// Enviamos trama de modificacion
			if ($offline == 0)
			{
				$sTramaLeida=conectar('O'.$gw_id."N".$nodo_ip.$i.$nodo_out[$i-1]);
			}
			else 
			{
				$sTramaLeida='O'.$gw_id."N".$nodo_ip.$i.$nodo_out[$i-1];
				$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $nodo_ip, $sTramaLeida);
				//echo $query;
				mysql_query($query,$link) or die(mysql_error());
			}
			//echo $sTramaLeida."<br>";
		
			if ($sTramaLeida[0] == 'O')
			{
					$xml_lectura.="<parametro><nombre>OU".$i."</nombre><valor>".substr($sTramaLeida,10,1)."</valor></parametro>";
			}
			else
			{
				//echo "alert('Trama incorrecta');";
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
