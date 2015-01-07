<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_name_general, $link);
$sEventoID=$_GET['id_evento'];
$query = sprintf("DELETE FROM rfreenet_blacklist WHERE blacklist_id=%s",$sEventoID);
$result = mysql_query($query,$link);

if(!$result)
{
	echo "ERROR";
}
else
{
	echo "OK";
}
mysql_close($link);
?>