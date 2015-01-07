<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name_general, $link);
//$query = sprintf("select IF(TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP,demonio_fecha))>$timeout_procesos,'1','0') as demonio_fecha, IF(TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP,monitor_fecha))>$timeout_procesos,'1','0') as monitor_fecha from %s",$tabla_name_demonios);
$query= sprintf("select IF(TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP,demonio_fecha))>%u,0,1) as estado_demonio,IF(TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP,monitor_fecha))>%u,0,1) as estado_monitor,IF(TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP,demonio_fecha_rutinas))>%u,0,1) as estado_demonio_rutinas,IF(TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP,monitor_fecha_rutinas))>%u,0,1) as estado_monitor_rutinas,IF(TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP,demonio_xml_fecha))>%u,0,1) as estado_demonio_xml,IF(TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP,monitor_xml_fecha))>%u,0,1) as estado_monitor_xml from %s", $timeout_procesos, $timeout_procesos, $timeout_procesos, $timeout_procesos, $timeout_procesos, $timeout_procesos, $tabla_name_demonios);
//echo $query.'<br>';
$result = mysql_query($query,$link);
if(!$result)
{
	echo "ERROR";
}
else
{
	echo "<estados>";
	while($row = mysql_fetch_array($result))
	{
		echo "<monitor>";
		echo $row['estado_monitor'];
		echo "</monitor>";
		echo "<demonio>";
		echo $row['estado_demonio'];
		echo "</demonio>";
		echo "<monitorR>";
		echo $row['estado_monitor_rutinas'];
		echo "</monitorR>";
		echo "<demonioR>";
		echo $row['estado_demonio_rutinas'];
		echo "</demonioR>";
		echo "<monitorX>";
		echo $row['estado_monitor_xml'];
		echo "</monitorX>";
		echo "<demonioX>";
		echo $row['estado_demonio_xml'];
		echo "</demonioX>";
	}
	echo "</estados>";
	mysql_free_result($result);
}
mysql_close($link);
?>