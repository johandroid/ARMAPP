
<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion = $_GET["instalacion_id"];
$cliente_db = $_GET["cliente_db"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT instalacion_habilitado_et1,instalacion_alias_et1,instalacion_gw_et1,instalacion_altura_mar_et1,instalacion_altura_anemometro_et1,instalacion_coeficiente_cultivo_et1,instalacion_latitud_et1,instalacion_habilitado_et2,instalacion_alias_et2,instalacion_gw_et2,instalacion_altura_mar_et2,instalacion_altura_anemometro_et2,instalacion_coeficiente_cultivo_et2 ,instalacion_latitud_et2,instalacion_habilitado_et3,instalacion_alias_et3,instalacion_gw_et3,instalacion_altura_mar_et3,instalacion_altura_anemometro_et3,instalacion_coeficiente_cultivo_et3,instalacion_latitud_et3 FROM cliente_instalaciones where instalacion_id='%s';", $instalacion);
$result = mysql_query($query,$link);


echo "<evapotranspiracion>";
if((!$result) && (!$result2))
{
	echo "error";
}
else
{
	if($row = mysql_fetch_array($result))
	{
		echo "<instalacion_habilitado_et1>";
		echo $row['instalacion_habilitado_et1'];
		echo "</instalacion_habilitado_et1>";
		echo "<instalacion_alias_et1>";
		echo $row['instalacion_alias_et1'];
		echo "</instalacion_alias_et1>";
		echo "<instalacion_gw_et1>";
		echo $row['instalacion_gw_et1'];
		echo "</instalacion_gw_et1>";
		echo "<instalacion_altura_mar_et1>";
		echo $row['instalacion_altura_mar_et1'];
		echo "</instalacion_altura_mar_et1>";
		echo "<instalacion_altura_anemometro_et1>";
		echo $row['instalacion_altura_anemometro_et1'];
		echo "</instalacion_altura_anemometro_et1>";
		echo "<instalacion_coeficiente_cultivo_et1>";
		echo $row['instalacion_coeficiente_cultivo_et1'];
		echo "</instalacion_coeficiente_cultivo_et1>";
		echo "<instalacion_latitud_et1>";
		echo $row['instalacion_latitud_et1'];
		echo "</instalacion_latitud_et1>";
		
		echo "<instalacion_habilitado_et2>";
		echo $row['instalacion_habilitado_et2'];
		echo "</instalacion_habilitado_et2>";
		echo "<instalacion_alias_et2>";
		echo $row['instalacion_alias_et2'];
		echo "</instalacion_alias_et2>";
		echo "<instalacion_gw_et2>";
		echo $row['instalacion_gw_et2'];
		echo "</instalacion_gw_et2>";
		echo "<instalacion_altura_mar_et2>";
		echo $row['instalacion_altura_mar_et2'];
		echo "</instalacion_altura_mar_et2>";
		echo "<instalacion_altura_anemometro_et2>";
		echo $row['instalacion_altura_anemometro_et2'];
		echo "</instalacion_altura_anemometro_et2>";
		echo "<instalacion_coeficiente_cultivo_et2>";
		echo $row['instalacion_coeficiente_cultivo_et2'];
		echo "</instalacion_coeficiente_cultivo_et2>";
		echo "<instalacion_latitud_et2>";
		echo $row['instalacion_latitud_et2'];
		echo "</instalacion_latitud_et2>";
		
		echo "<instalacion_habilitado_et3>";
		echo $row['instalacion_habilitado_et3'];
		echo "</instalacion_habilitado_et3>";
		echo "<instalacion_alias_et3>";
		echo $row['instalacion_alias_et3'];
		echo "</instalacion_alias_et3>";
		echo "<instalacion_gw_et3>";
		echo $row['instalacion_gw_et3'];
		echo "</instalacion_gw_et3>";
		echo "<instalacion_altura_mar_et3>";
		echo $row['instalacion_altura_mar_et3'];
		echo "</instalacion_altura_mar_et3>";
		echo "<instalacion_altura_anemometro_et3>";
		echo $row['instalacion_altura_anemometro_et3'];
		echo "</instalacion_altura_anemometro_et3>";
		echo "<instalacion_coeficiente_cultivo_et3>";
		echo $row['instalacion_coeficiente_cultivo_et3'];
		echo "</instalacion_coeficiente_cultivo_et3>";
		echo "<instalacion_latitud_et3>";
		echo $row['instalacion_latitud_et3'];
		echo "</instalacion_latitud_et3>";
		
	}
}
echo "</evapotranspiracion>";

mysql_free_result($result);
mysql_close($link);
?>