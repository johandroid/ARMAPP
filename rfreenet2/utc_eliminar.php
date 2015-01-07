<?php
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_db.inc';
	include 'inc/comunica.inc';
	
	$sInstalacionActual=$_GET['instalacion_id'];
	$disp_id=$_GET['disp_id'];
	$cliente_db = $_GET['cliente_db'];
	$offline=$_GET['offline'];
	
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($cliente_db, $link);
	$query = sprintf("SELECT gw_id,analizador_direccion FROM %s WHERE analizador_id='%s';", $tabla_name_utcs, $disp_id);
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR1";
		echo $query;
		return;
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			$gw_id = $row[0];
			$direccion = $row[1];
			$sComando=sprintf("c%sB%02s",$gw_id,strtoupper($direccion));
			//echo $sComando.'<br>';
			mysql_free_result($result);
			if ($offline == 0)
			{
				$sTramaLeida=conectar($sComando);
				//echo $sTramaLeida."<br>";
				if ($sTramaLeida[0] != 'c')
				{
					//echo "alert('Trama incorrecta');";
					echo "ERROR ";
				}
			}
			else
			{
				$query = sprintf("INSERT INTO cliente_comandos (gw_id,nodo_ip,comandos_trama,comandos_fecha) VALUES ('%s','%s','%s',NOW());",  $gw_id, $direccion, $sComando);
				//echo $query;
				mysql_query($query,$link) or die(mysql_error());
				$sTramaLeida[0] = 'c';
			}

			if ($sTramaLeida[0] != 'c')
			{
				//echo "alert('Trama incorrecta');";
				echo "ERROR2 ";
			}
			else
			{
			
				// Finalmente, cuando ya está actualizada la red en el gateway sin el nodo, lo eliminamos de DB
				$query = sprintf("DELETE FROM %s WHERE analizador_id='%s'",$tabla_name_utcs,$disp_id);
				//echo $query.'<br>';
				$result = mysql_query($query,$link);
				if(!$result)
				{
					echo "ERROR3";
				}
				else
				{
					echo $idiomas[$_SESSION['opcion_idioma']]['general256'].' '.$direccion.' '.$idiomas[$_SESSION['opcion_idioma']]['general216'];
				}
			}
		}
		else
		{
			echo "ERROR4 ";
			echo $query;
		}
	}
	mysql_close($link);
?>
