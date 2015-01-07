<?
include 'inc/datos_db.inc';
include 'inc/funciones_sensores.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$analizador_id = $_GET["analizador_id"];

mysql_select_db($db_name_general, $link);

$query = sprintf("SELECT modbus_num_registros,modbus_vector_magnitudes,modbus_vector_notificaciones FROM %s WHERE modbus_id='%s';", $tabla_name_modbus, $analizador_id);
$result = mysql_query($query,$link);
//echo $query;
echo "<utcs>";
if(!$result)
{
	echo "error";
}
else
{
	while($row = mysql_fetch_array($result))
	{
		echo "<registros total=\"";
		echo $row['modbus_num_registros'];
		echo "\" ></registros>";
		for($i=0; $i<$row['modbus_num_registros']; $i++)
		{
			echo "<magnitud nombre".($i+1)."=\"";
			echo sObtener_Cadena_Tipo_Sensor_UTC(substr($row['modbus_vector_magnitudes'],($i*4+1),2),substr($row['modbus_vector_magnitudes'],($i*4+3),1));
			/*if(substr($row['modbus_vector_magnitudes'],($i*4+3),1) != '0')
			{
				echo " ".substr($row['modbus_vector_magnitudes'],($i*4+3),1);
			}*/
			echo "\" habilita=\"".substr($row['modbus_vector_notificaciones'],$i,1)."\"";
			echo "></magnitud>";
		}
		
	}
}
echo "</utcs>";

mysql_free_result($result);
mysql_close($link);
?>