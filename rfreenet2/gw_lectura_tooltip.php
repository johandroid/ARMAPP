<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$gw_id = $_GET["gw_id"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT gw_show_image,gw_show_sensor1,gw_show_sensor2,gw_show_sensor3,gw_show_sensor4,gw_show_sensor5,gw_show_sensor6,gw_show_sensor7,gw_show_sensor8,gw_show_sensor9 FROM cliente_gateways WHERE gw_id='%s'",$gw_id);
//echo $query;
$result = mysql_query($query,$link);
$sSalida="<params>";
if(!$result)
{
	$sSalida="ERROR";
}
else
{
	if($row = mysql_fetch_array($result))
	{
		$sSalida.="<parametro><nombre>MI</nombre><valor>".$row['gw_show_image']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS1</nombre><valor>".$row['gw_show_sensor1']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS2</nombre><valor>".$row['gw_show_sensor2']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS3</nombre><valor>".$row['gw_show_sensor3']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS4</nombre><valor>".$row['gw_show_sensor4']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS5</nombre><valor>".$row['gw_show_sensor5']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS6</nombre><valor>".$row['gw_show_sensor6']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS7</nombre><valor>".$row['gw_show_sensor7']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS8</nombre><valor>".$row['gw_show_sensor8']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS9</nombre><valor>".$row['gw_show_sensor9']."</valor></parametro>";
	}
	$sSalida.="</params>";
}
echo $sSalida;

mysql_free_result($result);
mysql_close($link);
?>