<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

$cliente_id = $_GET["cliente_id"];

mysql_select_db($db_name_clientes, $link);
$iErrores = 0;
$query = "SHOW TABLES LIKE 'clientes_sms_%';";
//echo $query."<br/>";

$result = mysql_query($query,$link);
if(!$result)
{
	$sResultado=$idiomas[$_SESSION['opcion_idioma']]['error_sms7'];
}
else
{	
	while($row = mysql_fetch_array($result))
	{
		$query2 = sprintf("DELETE FROM %s WHERE sms_enviado='0' AND cliente_id='%s';",$row[0],$cliente_id);
		//echo $query2."<br/>";
		$result2 = mysql_query($query2,$link);
		if(!$result2)
		{
			$iErrores++;	
		}
	}
}

if ($iErrores > 0)
{
	$sResultado=$idiomas[$_SESSION['opcion_idioma']]['error_sms8'];
}
else
{
	$sResultado=$idiomas[$_SESSION['opcion_idioma']]['sms_text1'];
}
echo $sResultado;
mysql_free_result($result);
mysql_close($link);
?>