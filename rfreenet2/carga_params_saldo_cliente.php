<?
include 'inc/datos_db.inc';
$link8 = mysql_connect($db_host, $db_user, $db_pass);

$cliente_id = $_GET["cliente_id"];

mysql_select_db($db_name_clientes, $link8);

$query = sprintf("SELECT cliente_saldo_sms FROM clientes_datos WHERE cliente_id='%s'",$cliente_id);
//echo $query;
$result8 = mysql_query($query,$link8);
echo "<params>";
if(!$result8)
{
	echo "<configuracion sms_saldo=\"ERROR\"></configuracion>";
}
else
{
	if($row = mysql_fetch_array($result8))
	{
		echo "<configuracion sms_saldo=\"";
		echo $row['cliente_saldo_sms'];
		echo "\" ></configuracion>";
	}
	mysql_free_result($result8);
}
echo "</params>";
mysql_close($link8);
?>