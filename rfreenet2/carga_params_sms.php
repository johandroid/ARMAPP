<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT * FROM cliente_instalaciones where instalacion_id='%s'", $instalacion);
$result = mysql_query($query,$link);
echo "<params>";
if(!$result)
{
	echo "ERROR";
}
else
{
	if($row = mysql_fetch_array($result))
	{
		echo "<configuracion telf1_on=\"";
		echo $row['instalacion_sms_telf1_on'];
		echo "\" telf1=\"";
		echo $row['instalacion_sms_telf1'];
		echo "\" telf1_idioma=\"";
		echo $row['instalacion_sms_telf1_idioma'];
		echo "\" telf2_on=\"";
		echo $row['instalacion_sms_telf2_on'];
		echo "\" telf2=\"";
		echo $row['instalacion_sms_telf2'];
		echo "\" telf2_idioma=\"";
		echo $row['instalacion_sms_telf2_idioma'];
		echo "\" ></configuracion>";
	}
}
echo "</params>";

mysql_free_result($result);
mysql_close($link);
?>