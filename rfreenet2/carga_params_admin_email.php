<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_name_general, $link);

$query = sprintf("SELECT * FROM rfreenet_config_email");
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
		echo "<configuracion email_tecnico1_on=\"";
		echo $row['email_tecnico1_on'];
		echo "\" email_tecnico1=\"";
		echo $row['email_tecnico1'];
		echo "\" email_tecnico1_idioma=\"";
		echo $row['email_tecnico1_idioma'];
		echo "\" email_tecnico2_on=\"";
		echo $row['email_tecnico2_on'];
		echo "\" email_tecnico2=\"";
		echo $row['email_tecnico2'];
		echo "\" email_tecnico2_idioma=\"";
		echo $row['email_tecnico2_idioma'];
		echo "\" email_ventas1_on=\"";
		echo $row['email_ventas1_on'];
		echo "\" email_ventas1=\"";
		echo $row['email_ventas1'];
		echo "\" email_ventas1_idioma=\"";
		echo $row['email_ventas1_idioma'];
		echo "\" email_ventas2_on=\"";
		echo $row['email_ventas2_on'];
		echo "\" email_ventas2=\"";
		echo $row['email_ventas2'];
		echo "\" email_ventas2_idioma=\"";
		echo $row['email_ventas2_idioma'];
		echo "\" texto_email=\"";
		echo $row['email_texto'];
		echo "\" ></configuracion>";
	}
}
echo "</params>";

mysql_free_result($result);
mysql_close($link);
?>