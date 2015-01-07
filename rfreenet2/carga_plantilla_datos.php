<?
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$instalacion_id = $_GET["instalacion_id"];
$cliente_db = $_GET['cliente_db'];
$plantilla_id = $_GET['plantilla_id'];

mysql_select_db($cliente_db, $link);

$query="SELECT tipo_informe,plantilla_g1_titulo,plantilla_g1_sensor1,plantilla_g1_tipo_sensor1,plantilla_g1_sensor2,
	plantilla_g1_tipo_sensor2,plantilla_g1_sensor3,plantilla_g1_tipo_sensor3,plantilla_g1_sensor4,plantilla_g1_tipo_sensor4,plantilla_g2_titulo,plantilla_g2_sensor1,plantilla_g2_tipo_sensor1,
	plantilla_g2_sensor2,plantilla_g2_tipo_sensor2,plantilla_g2_sensor3,plantilla_g2_tipo_sensor3 ,plantilla_g2_sensor4,plantilla_g2_tipo_sensor4,plantilla_g3_titulo,plantilla_g3_sensor1,
	plantilla_g3_tipo_sensor1,plantilla_g3_sensor2,plantilla_g3_tipo_sensor2,plantilla_g3_sensor3 ,plantilla_g3_tipo_sensor3 ,plantilla_g3_sensor4,plantilla_g3_tipo_sensor4 ,
	plantilla_g4_titulo,plantilla_g4_sensor1,plantilla_g4_tipo_sensor1,plantilla_g4_sensor2 ,plantilla_g4_tipo_sensor2,plantilla_g4_sensor3,plantilla_g4_tipo_sensor3,plantilla_g4_sensor4,
	plantilla_g4_tipo_sensor4,plantilla_intervalo,plantilla_intervalo_unidad,plantilla_actualizacion,plantilla_actualizacion_unidad from ".$tabla_name_plantillas." where plantilla_id='".$plantilla_id."'";
$result = mysql_query($query,$link);

if($row=mysql_fetch_array($result))
{
	echo "<plantilla id=\"";
	echo $plantilla_id;
	echo "\" tipo_informe=\"";
	echo $row['tipo_informe'];
	echo "\" plantilla_g1_titulo=\"";
	echo $row['plantilla_g1_titulo'];
	echo "\" plantilla_g1_sensor1=\"";
	echo $row['plantilla_g1_sensor1'];
	echo "\" plantilla_g1_tipo_sensor1=\"";
	echo $row['plantilla_g1_tipo_sensor1'];
	echo "\" plantilla_g1_sensor2=\"";
	echo $row['plantilla_g1_sensor2'];
	echo "\" plantilla_g1_tipo_sensor2=\"";
	echo $row['plantilla_g1_tipo_sensor2'];
	echo "\" plantilla_g1_sensor3=\"";
	echo $row['plantilla_g1_sensor3'];
	echo "\" plantilla_g1_tipo_sensor3=\"";
	echo $row['plantilla_g1_tipo_sensor3'];
	echo "\" plantilla_g1_sensor4=\"";
	echo $row['plantilla_g1_sensor4'];
	echo "\" plantilla_g1_tipo_sensor4=\"";
	echo $row['plantilla_g1_tipo_sensor4'];
	echo "\" plantilla_g2_titulo=\"";
	echo $row['plantilla_g2_titulo'];
	echo "\" plantilla_g2_sensor1=\"";
	echo $row['plantilla_g2_sensor1'];
	echo "\" plantilla_g2_tipo_sensor1=\"";
	echo $row['plantilla_g2_tipo_sensor1'];
	echo "\" plantilla_g2_sensor2=\"";
	echo $row['plantilla_g2_sensor2'];
	echo "\" plantilla_g2_tipo_sensor2=\"";
	echo $row['plantilla_g2_tipo_sensor2'];
	echo "\" plantilla_g2_sensor3=\"";
	echo $row['plantilla_g2_sensor3'];
	echo "\" plantilla_g2_tipo_sensor3=\"";
	echo $row['plantilla_g2_tipo_sensor3'];
	echo "\" plantilla_g2_sensor4=\"";
	echo $row['plantilla_g2_sensor4'];
	echo "\" plantilla_g2_tipo_sensor4=\"";
	echo $row['plantilla_g2_tipo_sensor4'];
	echo "\" plantilla_g3_titulo=\"";
	echo $row['plantilla_g3_titulo'];
	echo "\" plantilla_g3_sensor1=\"";
	echo $row['plantilla_g3_sensor1'];
	echo "\" plantilla_g3_tipo_sensor1=\"";
	echo $row['plantilla_g3_tipo_sensor1'];
	echo "\" plantilla_g3_sensor2=\"";
	echo $row['plantilla_g3_sensor2'];
	echo "\" plantilla_g3_tipo_sensor2=\"";
	echo $row['plantilla_g3_tipo_sensor2'];
	echo "\" plantilla_g3_sensor3=\"";
	echo $row['plantilla_g3_sensor3'];
	echo "\" plantilla_g3_tipo_sensor3=\"";
	echo $row['plantilla_g3_tipo_sensor3'];
	echo "\" plantilla_g3_sensor4=\"";
	echo $row['plantilla_g3_sensor4'];
	echo "\" plantilla_g3_tipo_sensor4=\"";
	echo $row['plantilla_g3_tipo_sensor4'];
	echo "\" plantilla_g4_titulo=\"";
	echo $row['plantilla_g4_titulo'];
	echo "\" plantilla_g4_sensor1=\"";
	echo $row['plantilla_g4_sensor1'];
	echo "\" plantilla_g4_tipo_sensor1=\"";
	echo $row['plantilla_g4_tipo_sensor1'];
	echo "\" plantilla_g4_sensor2=\"";
	echo $row['plantilla_g4_sensor2'];
	echo "\" plantilla_g4_tipo_sensor2=\"";
	echo $row['plantilla_g4_tipo_sensor2'];
	echo "\" plantilla_g4_sensor3=\"";
	echo $row['plantilla_g4_sensor3'];
	echo "\" plantilla_g4_tipo_sensor3=\"";
	echo $row['plantilla_g4_tipo_sensor3'];
	echo "\" plantilla_g4_sensor4=\"";
	echo $row['plantilla_g4_sensor4'];
	echo "\" plantilla_g4_tipo_sensor4=\"";
	echo $row['plantilla_g4_tipo_sensor4'];
	echo "\" plantilla_intervalo=\"";
	echo $row['plantilla_intervalo'];
	echo "\" plantilla_intervalo_unidad=\"";
	echo $row['plantilla_intervalo_unidad'];
	echo "\" plantilla_actualizacion=\"";
	echo $row['plantilla_actualizacion'];
	echo "\" plantilla_actualizacion_unidad=\"";
	echo $row['plantilla_actualizacion_unidad'];
	echo "\" ></plantilla>";
}
else 
{
	echo $idiomas[$_SESSION['opcion_idioma']]['error_plantilla4'];
}
mysql_close($link);
?>