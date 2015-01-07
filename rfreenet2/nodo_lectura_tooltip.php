<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$gw_id = $_GET["gw_id"];
$cliente_db = $_GET["cliente_db"];
$nodo_mac = $_GET["nodo_mac"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT nodo_show_image,nodo_show_s1,nodo_show_s2,nodo_show_s3,nodo_show_s4,nodo_show_s5,nodo_show_s6 FROM cliente_nodos WHERE gw_id='%s' AND nodo_mac='%s'",$gw_id,$nodo_mac);
//echo $query;
$result = mysql_query($query,$link);
$sSalida="<params>";
if(!$result)
{
	$sSalida="ERROR";
}
else
{
	if($row = mysql_fetch_array($result))
	{
		$sSalida.="<parametro><nombre>MI</nombre><valor>".$row['nodo_show_image']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS1</nombre><valor>".$row['nodo_show_s1']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS2</nombre><valor>".$row['nodo_show_s2']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS3</nombre><valor>".$row['nodo_show_s3']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS4</nombre><valor>".$row['nodo_show_s4']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS5</nombre><valor>".$row['nodo_show_s5']."</valor></parametro>";
		$sSalida.="<parametro><nombre>MS6</nombre><valor>".$row['nodo_show_s6']."</valor></parametro>";
	}
	$sSalida.="</params>";
}
echo $sSalida;

mysql_free_result($result);
mysql_close($link);
?>