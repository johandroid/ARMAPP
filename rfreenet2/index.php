<?php
	session_start(); //continuamos session o la creamos si no hay
if($_POST['movil']!=1){
	//session_destroy(); //nos cargamos la sesion por si acaso
	//session_start(); //y volvemos a iniciar la sesion una limpieza absoluta
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	include 'inc/funciones_indice.inc';
	$nombre=$_POST['usuario'];
	$password=$_POST['pass'];
	if ($_POST['idioma_sesion']) 
	{
		$_SESSION['opcion_idioma']=$_POST['idioma_sesion'];
	}
	else if ($_GET['opcion_idioma'])
	{
		$_SESSION['opcion_idioma']=$_GET['opcion_idioma'];
	}
	else if ($_SERVER["SERVER_NAME"] == $url_hanna)
	{
		$_SESSION['opcion_idioma']=$idioma_hanna;
	}
	else
	{
		$_SESSION['opcion_idioma']='es';
	}
	$_SESSION['autentificado_rf2'] = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<?php
	if($_SERVER["SERVER_NAME"]==$url_hanna)
	{
		echo "<title>WATER WEB MANAGER 2.0</title>\n";
	}
	else
	{
		echo "<title>GREEN WEB MANAGER 2.0</title>\n";
	}
?>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
<?php
	if($_SERVER["SERVER_NAME"]==$url_hanna)
	{
		echo "<link href='images/favicon_hanna.ico' type='image/x-icon' rel='shortcut icon'/>\n";
	}
	else
	{
		echo "<link href='images/favicon.ico' type='image/x-icon' rel='shortcut icon'/>\n";
	}
?>
<script type="text/javascript" src="js/funciones_ajax.js?time=<?php echo(filemtime("js/funciones_ajax.js"));?>"></script>
<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript">
	function OnPWForgotten()
	{
		var xmlHttpFG;
		if (document.getElementById('usuario').value == '')
		{
			alert('<?php echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['error_login1']);?>');
		}
		else
		{
			if (confirm(iObtener_Cadena_AJAX('general01')+" "+document.getElementById('usuario').value + "?"))
			{
				xmlHttpFG= GetXmlHttpObject();
				var url = "enviar_pw_olvidado.php?usuario="+document.getElementById('usuario').value;
				$('#imagen_esperaFP').attr("class", 'mostrado');
				xmlHttpFG.onreadystatechange=function()
				{
					if (xmlHttpFG.readyState==4)
					{
						$('#imagen_esperaFP').attr("class", 'escondido');
						if (xmlHttpFG.responseText!='ERROR')
						{
							alert("<?php echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['login_text1']);?>");
						}
					}
				}
				xmlHttpFG.open("GET",url,true);
				xmlHttpFG.send(null);
			}
		}
	}
	function vOnLogin()
	{
		document.getElementById('bLoginButton').value="entrar";
	}
</script>
</head>
<body class="Fondo_Web">
<form action="index.php" name="index" method="post">
<?php
include 'inc/datos_db.inc';
//include 'inc/funciones_indice.inc';

if ($_POST["logout"])
{
	session_unset(); //liberamos las variables
	session_destroy(); //nos cargamos la sesion por si acaso
	//session_start(); //y volvemos a iniciar la sesion una limpieza absoluta
	?><script>window.location='index.php';</script><?php
}

if ($_POST["entrar"])
{
	$link = mysql_connect($db_host, $db_user, $db_pass);
	mysql_select_db($db_name_clientes, $link);
	$query = "SELECT * from clientes_usuarios where usuario_nombre='".$_POST['usuario']."'";

	$result = mysql_query($query,$link);
	$usuario = null;
	$pass = null;

	if ($result)
	{

		if($row=mysql_fetch_array($result))
		{

			$pass= $row['usuario_password'];
	   		//echo "<br>password almacenado: ".$pass;
	   		//echo "<br>password introducido: ".md5($_POST['pass']);
			$usuario = $row['usuario_nombre'];

			if($pass == md5($_POST['pass']))
			{
	 			$_SESSION['autentificado_rf2']= 1;				
				$_SESSION['usuario']= $_POST['usuario'];
				$_SESSION['id_usuario']= $row['usuario_id'];
				$_SESSION['perfil']= $row['usuario_perfil'];
				$_SESSION['id_cliente']= $row['cliente_id'];
				$_SESSION['opcion_idioma']=$_POST['idioma_sesion'];

				if (hexdec($_SESSION['id_cliente']) > 0)
				{
					// Y extraemos el resto de info importante del cliente
					$query = "SELECT * from clientes_datos where cliente_id='".$_SESSION['id_cliente']."'";
					$result = mysql_query($query,$link);
					
					if($row=mysql_fetch_array($result))
					{
						$_SESSION['cliente_db']=$row['cliente_db'];

						echo "<script>window.location='inicio.php';</script>";
					}
					else
					{
						?>
						<script>alert('<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_client_login'];?>');</script>
						<?php
						echo "<script>window.location='index.php'</script>";
					}
				}
				else
				{					
					echo "<script>window.location='inicio.php';</script>";
				}
			}
			else
			{
			?>
				<script>alert('<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_password_login'];?>');</script>
			<?php
			}
		}
		else
		{
			?>
			<script>alert('<?php echo $idiomas[$_SESSION['opcion_idioma']]['error_username_login'];?>');</script>
			<?php
		}
		mysql_free_result($result);
	}	
	mysql_close($link);
}
?>
<table style="width:1020px;height:616px" align="center" border="1" cellpadding="0" cellspacing="0" id="Tabla_01" class="Fondo_Tabla">
	<tr style="height:138px">
		<td align="left" width="225">
<?php 
				if($_SERVER["SERVER_NAME"]==$url_hanna)
				{
					echo '<img src="images/hanna_logo.jpg" width="222" height="138" alt="Balmart"/>';
				}
				else
				{

					echo '<img src="images/logo.jpg" width="222" height="138" alt="Balmart"/>';
				}
?>
		</td>
		<td align="left">
<?php 
				if($_SERVER["SERVER_NAME"]==$url_hanna)
				{
					echo '<img src="images/hanna_banner.jpg" width="790" height="138" alt="Green Web Manager 2.0"/>';
				}
				else
				{
					echo '<img src="images/banner.jpg" width="790" height="138" alt="Green Web Manager 2.0"/>';
				}
?>	
		</td>
	</tr>
	<tr style="height:38px">
		<td style="text-align:center">
			<img src="images/flags/spain.png" width="20" height="20" alt="Espa&#241;ol" onclick="vCambiarIdioma(0,'es');"/>
			<img src="images/flags/united_kingdom.png" width="20" height="20" alt="Franc&eacute;s" onclick="vCambiarIdioma(0,'en');"/>
			<img src="images/flags/france.png" width="20" height="20" alt="Franc&eacute;s" onclick="vCambiarIdioma(0,'fr');"/>
		</td>
	  	<td align="left" valign="top" style="font-family:Arial, Helvetica"></td>
	</tr>
	<tr style="height:28px">
	  	<td>&nbsp;</td>
	  	<td style="color:#FFF; background-color:#999"></td>
	</tr>
	<tr height="497px">
		<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; background-color:#999"></td>
	  	<td align="left" valign="middle">&nbsp;
		  	<table border="0" width="100%" cellspacing="0">
				<tr>
					<td style="width:20%"></td>
					<td style="width:30%" align="center">
						<span class="texto_login"> <?php echo $idiomas[$_SESSION['opcion_idioma']]['general32'];?></span>
					</td>
					<td style="width:30%" align="center">
						<input type="text" name="usuario" id="usuario" value="<?php echo $_POST['usuario'];?>"/>
					</td>
					<td style="width:20%"></td>
				</tr>
				<tr>
					<td style="width:20%"><br/></td>
					<td style="width:30%"><br/></td>
					<td style="width:30%"><br/></td>
					<td style="width:20%"><br/></td>
				</tr>
				<tr>
					<td style="width:20%"></td>
					<td style="width:30%" align="center" id="td_pass2">
						<span class="texto_login"> <?php echo $idiomas[$_SESSION['opcion_idioma']]['general33'];?></span>
					</td>
					<td style="width:30%" align="center">
						<input type="password" name="pass" id="pass"/>
					</td>
					<td style="width:20%"></td>
				</tr>
				<tr>
					<td style="width:20%"><br/></td>
					<td style="width:30%"><br/></td>
					<td style="width:30%"><br/></td>
					<td style="width:20%"><br/></td>
				</tr>
				<tr>
					<td style="width:20%"></td>
					<td style="width:30%" align="center">
						<input type="submit" id="bLoginButton" value="<?php echo $idiomas[$_SESSION['opcion_idioma']]['general35'];?>" name="entrar" class="boton_fino" onclick="vOnLogin()"/>
						<input type="hidden" value="<?echo $_SESSION['cliente_db']?>" id="db_cliente"/>
						<input type="hidden" value="<?echo $_SESSION['opcion_idioma']?>" name="idioma_sesion"/>
					</td>
					<td style="width:30%" align="center">
						<a onclick="OnPWForgotten()" style="text-decoration:underline;font-family:Arial, Helvetica, sans-serif; text-align:center; font-size:12px;"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general36'];?></a>
						<img id="imagen_esperaFP" src="images/wait_circle.gif" class="escondido"/>
					</td>					
					<td style="width:20%"></td>
				</tr>
			</table>
	  	</td>
	</tr>
	<tr height="14px">
		<td colspan="2" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; background-color:#999">&nbsp;
			<?php
			if($_SERVER["SERVER_NAME"]==$url_hanna)
			{
				//echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general00']);
			}
			else
			{
				?>&copy;<?php
				echo utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general00']);
			}
			?>
		</td>		
    </tr>
</table>
</form>
<script type="text/javascript">
	document.getElementById('usuario').focus();
 </script>
</body>
</html>
<?php }
if ($_POST['movil']==1)
{
    if($_POST['usuario']=="Johan") {
        $resultadoSession = array('sesion' => 'ok');
    } else {
        $resultadoSession = array('sesion' => $_POST['usuario']);
    }
    echo json_encode($resultadoSession);
}