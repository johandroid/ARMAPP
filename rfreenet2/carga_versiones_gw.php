<?
include 'inc/datos_db.inc';

$sInstalacionActual=$_POST['instalacion_id'];
$gw_id=$_POST['gw_id'];
$db_client=$_POST['cliente_db'];
	
$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_client, $link);

$query = sprintf("SELECT gw_tipo,gw_versionHW,gw_versionSW FROM %s INNER JOIN %s ON %s.gw_id=%s.gw_id WHERE gw_id='%s' AND instalacion_id='%s';", $tabla_name_params_gateways,$tabla_name_gateways,$tabla_name_params_gateways,$tabla_name_gateways,$gw_id,$sInstalacionActual);
$result = mysql_query($query,$link);
echo "<gws>";
if(!$result)
{
	echo "error";
}
else
{
	while($row = mysql_fetch_array($result))
	{
		echo "<gw gw_id=\"";
		echo $row['gw_id'];
		echo "\" gw_tipo=\"";
		echo $row['gw_tipo'];
		echo "\" gw_versionHW=\"";
		echo $row['gw_versionHW'];
		echo "\" gw_versionSW=\"";
		echo $row['gw_versionSW'];
		echo "\" ></gw>";
	}
}
echo "</gws>";

mysql_free_result($result);
mysql_close($link);
?>