<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);
require_once('FirePHPCore/FirePHP.class.php'); 

ob_start();
$mifirePHP = FirePHP::getInstance(true); 

$query = sprintf("SELECT gw_id,gw_nombre FROM cliente_gateways where instalacion_id='%s' ORDER BY gw_nombre ASC;", $instalacion);
$result = mysql_query($query,$link);
echo "<gateways>";
if(!$result)
{
	echo "error";
}
else
{
	$mifirePHP -> log($query);
	while($row = mysql_fetch_array($result))
	{
		$mifirePHP -> log($row['gw_nombre']);
		echo "<gateway id=\"";
		echo $row['gw_id'];
		echo "\" nombre=\"";
		echo $row['gw_nombre'];
		echo "\" ></gateway>";
	}
}
echo "</gateways>";

mysql_free_result($result);
mysql_close($link);
?>