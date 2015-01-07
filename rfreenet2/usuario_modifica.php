<?
session_start();
include 'inc/datos_db.inc';
include 'inc/idiomas.inc';
$link = mysql_connect($db_host, $db_user, $db_pass);
$usuario_id = $_GET["usuario_id"];
$usuario_nombre = $_GET["usuario_nombre"];
$usuario_pw = $_GET["usuario_pw"];
$usuario_perfil = $_GET["usuario_perfil"];
$usuario_email = $_GET["usuario_email"];
$usuario_cliente_id = $_GET['cliente_id'];

mysql_select_db($db_name_clientes, $link);

$query = sprintf("SELECT usuario_id FROM clientes_usuarios WHERE usuario_nombre='%s'", $usuario_nombre);
//echo '<br>'.$query.'<br>';
$modificando=1;
$result = mysql_query($query,$link);
if ($result)
{
	if($row = mysql_fetch_array($result))
	{
		//echo '<br>'.$row[0].' vs '.$usuario_id.'<br>';
		if ($row[0]!=$usuario_id)
		{
			echo "    ".$idiomas[$_SESSION['opcion_idioma']]['general161']." ".$usuario_nombre.".\r\n     ".$idiomas[$_SESSION['opcion_idioma']]['general162'].".";
			$modificando=0;
		}
		else
		{
			//echo '<br>ERROR en result<br>';
			$modificando=1;
		}
	}
	mysql_free_result($result);
}
if ($modificando==1)
{
	$query = sprintf("UPDATE clientes_usuarios SET usuario_nombre='%s',usuario_password=MD5('%s'),usuario_perfil='%s',usuario_email='%s',cliente_id='%s' where usuario_id='%s'", $usuario_nombre, $usuario_pw, $usuario_perfil, $usuario_email, $usuario_cliente_id, $usuario_id);
	//echo '<br>'.$query.'<br>';
	$result = mysql_query($query,$link);
	if ($result)
	{
		echo $idiomas[$_SESSION['opcion_idioma']]['general32']." ".$usuario_nombre." ".$idiomas[$_SESSION['opcion_idioma']]['general174'];
	}
	else
	{
		echo $idiomas[$_SESSION['opcion_idioma']]['error_user10']." ".$usuario_nombre;
	}
}
mysql_close($link);
?>