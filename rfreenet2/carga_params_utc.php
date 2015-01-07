<?
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$cliente_db = $_GET["cliente_db"];
$analizador_id = $_GET["utc_id"];

mysql_select_db($cliente_db, $link);

$query = sprintf("SELECT analizador_nombre, analizador_direccion, analizador_tipo, analizador_reposicion, gw_id, analizador_vector_magnitudes, analizador_vector_magnitudes_SMS,analizador_vector_magnitudes_EMAIL,analizador_tiempo_medida,analizador_setpoint,analizador_delta,analizador_lowpoint,analizador_lowpoint_habilitado,analizador_max,analizador_max_habilitado,analizador_alarma_alta_cloro,analizador_alarma_alta_cloro_habilitado,analizador_alarma_baja_cloro,analizador_alarma_baja_cloro_habilitado, analizador_pwd  FROM %s where analizador_id='%s';", $tabla_name_utcs, $analizador_id);
$result = mysql_query($query,$link);

if(!$result)
{
	echo "ERROR";
}
else
{
	echo "<utcs>";
	while($row = mysql_fetch_array($result))
	{
		echo "<utc nombre=\"";
		echo $row['analizador_nombre'];
		echo "\" direccion=\"";
		echo $row['analizador_direccion'];
		echo "\" tipo=\"";
		echo $row['analizador_tipo'];
		echo "\" gw_id=\"";
		echo $row['gw_id'];
		echo "\" magnitudes=\"";
		echo $row['analizador_vector_magnitudes'];
		echo "\" magnitudesSMS=\"";
		echo $row['analizador_vector_magnitudes_SMS'];
		echo "\" magnitudesEMAIL=\"";
		echo $row['analizador_vector_magnitudes_EMAIL'];
		echo "\" reposicion=\"";
		echo $row['analizador_reposicion'];
		echo "\" tiempo_medida=\"";
		echo $row['analizador_tiempo_medida'];
		echo "\" setpoint=\"";
		echo $row['analizador_setpoint'];
		echo "\" delta=\"";
		echo $row['analizador_delta'];
		echo "\" lowpoint=\"";
		echo $row['analizador_lowpoint'];
		echo "\" lowpoint_habilitado=\"";
		echo $row['analizador_lowpoint_habilitado'];
		echo "\" max=\"";
		echo $row['analizador_max'];
		echo "\" max_habilitado=\"";
		echo $row['analizador_max_habilitado'];
		echo "\" alarma_alta_cloro=\"";
		echo $row['analizador_alarma_alta_cloro'];
		echo "\" alarma_alta_cloro_habilitado=\"";
		echo $row['analizador_alarma_alta_cloro_habilitado'];
		echo "\" alarma_baja_cloro=\"";
		echo $row['analizador_alarma_baja_cloro'];
		echo "\" alarma_baja_cloro_habilitado=\"";
		echo $row['analizador_alarma_baja_cloro_habilitado'];
		echo "\" alarma_password=\"";
		echo $row['analizador_pwd'];
		echo "\" ></utc>";
	}
	echo "</utcs>";
}

mysql_free_result($result);
mysql_close($link);
?>