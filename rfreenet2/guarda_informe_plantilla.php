<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion_id = $_GET["instalacion_id"];
$cliente_db = $_GET['cliente_db'];
$plantilla_nombre = $_GET['plantilla_nombre'];
$usuario_nombre = $_GET['usuario_nombre'];
$tipo_informe = $_GET['tipo_informe'];

mysql_select_db($cliente_db, $link);

$query="SELECT * from ".$tabla_name_plantillas." where plantilla_nombre='".$plantilla_nombre."'";
$result = mysql_query($query,$link);

if(mysql_num_rows($result)>0)
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_plantilla2'];
}
else 
{
	mysql_free_result($result);
	mysql_select_db($cliente_db, $link);
	$query = "INSERT INTO ".$tabla_name_plantillas." (plantilla_id,user_id,instalacion_id,plantilla_nombre,tipo_informe,plantilla_g1_titulo,plantilla_g1_sensor1,plantilla_g1_tipo_sensor1,plantilla_g1_sensor2,
	plantilla_g1_tipo_sensor2,plantilla_g1_sensor3,plantilla_g1_tipo_sensor3,plantilla_g1_sensor4,plantilla_g1_tipo_sensor4,plantilla_g2_titulo,plantilla_g2_sensor1,plantilla_g2_tipo_sensor1,
	plantilla_g2_sensor2,plantilla_g2_tipo_sensor2,plantilla_g2_sensor3,plantilla_g2_tipo_sensor3 ,plantilla_g2_sensor4,plantilla_g2_tipo_sensor4,plantilla_g3_titulo,plantilla_g3_sensor1,
	plantilla_g3_tipo_sensor1,plantilla_g3_sensor2,plantilla_g3_tipo_sensor2,plantilla_g3_sensor3 ,plantilla_g3_tipo_sensor3 ,plantilla_g3_sensor4,plantilla_g3_tipo_sensor4 ,
	plantilla_g4_titulo,plantilla_g4_sensor1,plantilla_g4_tipo_sensor1,plantilla_g4_sensor2 ,plantilla_g4_tipo_sensor2,plantilla_g4_sensor3,plantilla_g4_tipo_sensor3,plantilla_g4_sensor4,
	plantilla_g4_tipo_sensor4,plantilla_intervalo,plantilla_intervalo_unidad,plantilla_actualizacion,plantilla_actualizacion_unidad) VALUES 
	('',(SELECT usuario_id from rfreenet_clientes.clientes_usuarios where usuario_nombre='".$usuario_nombre."'),'".$instalacion_id."','".$plantilla_nombre."',".$tipo_informe;

	for ($i=1;$i<5;$i++)
	{
		$query .= ",'".$_GET["g".$i."_titulo"]."'";
		if(isset($_GET["g".$i."_sensor1"]))
		{
			$query .= ",'".$_GET["g".$i."_sensor1"]."','".$_GET["g".$i."_tipo1"]."'";
		}
		else
		{
			$query .= ",'0','0'";
		}
		if(isset($_GET["g".$i."_sensor2"]))
		{
			$query .= ",'".$_GET["g".$i."_sensor2"]."','".$_GET["g".$i."_tipo2"]."'";
		}
		else
		{
			$query .= ",'0','0'";
		}
		if(isset($_GET["g".$i."_sensor3"]))
		{
			$query .= ",'".$_GET["g".$i."_sensor3"]."','".$_GET["g".$i."_tipo3"]."'";
		}
		else
		{
			$query .= ",'0','0'";
		}
		if(isset($_GET["g".$i."_sensor4"]))
		{
			$query .= ",'".$_GET["g".$i."_sensor4"]."','".$_GET["g".$i."_tipo4"]."'";
		}
		else
		{
			$query .= ",'0','0'";
		}
	}
	$query .= ",'".$_GET["plantilla_intervalo"]."','".$_GET["plantilla_intervalo_unit"]."','".$_GET["plantilla_actualizacion"]."','".$_GET["plantilla_actualizacion_unit"]."')";
	echo '<br>'.$query.'<br>'.$cliente_db."<br>";
	$result = mysql_query($query,$link);
	if ($result)
	{
		
		//echo $idiomas[$_SESSION['opcion_idioma']]['general22']." ".$idiomas[$_SESSION['opcion_idioma']]['general229']." ".$idiomas[$_SESSION['opcion_idioma']]['general7']." ".$instalacion_nombre;
	}
	else
	{
		echo mysql_error($link)."<br>";
		echo $idiomas[$_SESSION['opcion_idioma']]['error_plantilla3'];
	
	}
}
mysql_close($link);
?>