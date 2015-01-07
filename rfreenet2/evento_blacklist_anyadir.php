<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';

$blacklist_gateway = $_GET["blacklist_gateway"];
$blacklist_mac = $_GET['blacklist_mac'];
$blacklist_evento = $_GET['blacklist_evento'];

$link2 = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name_general, $link2);
$query = sprintf("SELECT * FROM rfreenet_blacklist WHERE blacklist_suscriptor='%s' AND blacklist_mac='%s' AND blacklist_evento='%s'", $blacklist_gateway, $blacklist_mac, $blacklist_evento);
//echo $query.'<br>';
$result = mysql_query($query,$link2);
if (!$result)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_acceso_db'];
}
else
{
	if($row = mysql_fetch_array($result))
	{
		echo $idiomas[$_SESSION['opcion_idioma']]['error_evento9'];
	}
	else
	{
		mysql_free_result($result);
		$query = sprintf("INSERT INTO rfreenet_blacklist VALUES ('','%s','%s','%s')", $blacklist_gateway, $blacklist_mac, $blacklist_evento);
		//echo $query.'<br>';
		
		$result = mysql_query($query,$link2);
		if ($result)
		{
			echo $idiomas[$_SESSION['opcion_idioma']]['general31']." '$blacklist_evento' ".$idiomas[$_SESSION['opcion_idioma']]['evento_text2'];
		}
		else
		{
			echo $idiomas[$_SESSION['opcion_idioma']]['error_evento10']." '$blacklist_evento' ";
		}
	}
}
if ($link2)
{
	mysql_close($link2);
}
?>