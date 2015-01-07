<?
session_start();
include 'inc/datos_db.inc';
include 'inc/idiomas.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_name_general, $link);

$query = sprintf("SELECT * FROM rfreenet_blacklist INNER JOIN rfreenet_texto_eventos_%s on rfreenet_blacklist.blacklist_evento=rfreenet_texto_eventos_%s.evento_codigo", $_SESSION['opcion_idioma'], $_SESSION['opcion_idioma']);
$result = mysql_query($query,$link);
echo "<params>";
if(!$result)
{
	echo "ERROR";
}
else
{
	while  ($row = mysql_fetch_array($result))
	{
		echo "<blacklisted blacklist_id=\"";
		echo $row['blacklist_id'];
		echo "\" blacklist_suscriptor=\"";
		echo $row['blacklist_suscriptor'];
		echo "\" blacklist_mac=\"";
		echo $row['blacklist_mac'];
		echo "\" blacklist_evento=\"";
		echo $row['blacklist_evento'];
		echo "\" blacklist_nombre_evento=\"";
		echo utf8_encode($row['evento_texto']);
		echo "\" ></blacklisted>";
	}
}
echo "</params>";

mysql_free_result($result);
mysql_close($link);
?>