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
		echo "<configuracion email1_on=\"";
		echo $row['instalacion_email1_on'];
		echo "\" email1=\"";
		echo $row['instalacion_email1'];
		echo "\" email1_idioma=\"";
		echo $row['instalacion_email1_idioma'];
		echo "\" email2_on=\"";
		echo $row['instalacion_email2_on'];
		echo "\" email2=\"";
		echo $row['instalacion_email2'];
		echo "\" email2_idioma=\"";
		echo $row['instalacion_email2_idioma'];
		echo "\" email_texto=\"";
		echo $row['instalacion_email_texto'];
		echo "\" ></configuracion>";
	}
}
echo "</params>";

mysql_free_result($result);
mysql_close($link);
?>