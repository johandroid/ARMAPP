<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_name_general, $link);

$query = sprintf("SELECT modbus_id,modbus_nombre FROM %s ORDER BY modbus_nombre ASC;", $tabla_name_modbus);
$result = mysql_query($query,$link);
echo "<utcs>";
if(!$result)
{
	echo "error";
}
else
{
	while($row = mysql_fetch_array($result))
	{
		echo "<utc id=\"";
		echo $row['modbus_id'];
		echo "\" nombre=\"";
		echo $row['modbus_nombre'];
		echo "\" ></utc>";
	}
}
echo "</utcs>";

mysql_free_result($result);
mysql_close($link);
?>