<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_name_general, $link);

$query = sprintf("SELECT * FROM rfreenet_config_sms");
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
		echo $row['sms_telf1_on'];
		echo "\" telf1=\"";
		echo $row['sms_telf1'];
		echo "\" telf1_idioma=\"";
		echo $row['sms_telf1_idioma'];
		echo "\" telf2_on=\"";
		echo $row['sms_telf2_on'];
		echo "\" telf2=\"";
		echo $row['sms_telf2'];
		echo "\" telf2_idioma=\"";
		echo $row['sms_telf2_idioma'];
		echo "\" ></configuracion>";
	}
}
echo "</params>";

mysql_free_result($result);
mysql_close($link);
?>