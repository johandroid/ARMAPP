<?php
	include 'inc/datos_db.inc';
	$link = mysql_connect($db_host, $db_user, $db_pass);
	$cliente_db = $_GET["cliente_db"];
	$gw_id=$_GET['gw_id'];
	$nodo_mac=$_GET['nodo_mac'];
	$SuscriptorTrama=substr($comando,1,4);
	$IPTrama=substr($comando,6,12);
	
	mysql_select_db($cliente_db, $link);
	
	$query = sprintf("SELECT nodo_TS1,nodo_TS2,nodo_TS3,nodo_TS4,nodo_TS5,nodo_TS6,nodo_SEN FROM cliente_params_nodo WHERE gw_id='%s' AND nodo_mac='%s'",$gw_id,$nodo_mac);
	//echo $query;
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR";
	}
	else
	{
		if($row = mysql_fetch_array($result))
		{
			echo "<Nodo>";
			echo "<parametro><nombre>SEN</nombre><valor>".$row['nodo_SEN']."</valor></parametro>";
			echo "<parametro><nombre>TS1</nombre><valor>".$row['nodo_TS1']."</valor></parametro>";
			echo "<parametro><nombre>TS2</nombre><valor>".$row['nodo_TS2']."</valor></parametro>";
			echo "<parametro><nombre>TS3</nombre><valor>".$row['nodo_TS3']."</valor></parametro>";
			echo "<parametro><nombre>TS4</nombre><valor>".$row['nodo_TS4']."</valor></parametro>";
			echo "<parametro><nombre>TS5</nombre><valor>".$row['nodo_TS5']."</valor></parametro>";
			echo "<parametro><nombre>TS6</nombre><valor>".$row['nodo_TS6']."</valor></parametro>";			
			echo "</Nodo>";
		}
		else
		{
			echo "ERROR";
		}
	}
	
	mysql_free_result($result);
	mysql_close($link);
?>
