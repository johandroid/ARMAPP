<?php
	session_start();
	include 'inc/idiomas.inc';
	include 'inc/datos_db.inc';
	include 'inc/datos_email.inc';
	include 'inc/funciones_db.inc';
	
	$usuario_mod=$_GET['usuario'];
	
	$link = mysql_connect($db_host, $db_user, $db_pass);	
	
	mysql_select_db($db_name_clientes, $link);
	
	$password_read=generarPassword(12);
	echo $password_read.'<br>';
	$query = sprintf("UPDATE clientes_usuarios SET usuario_password=MD5('%s') WHERE usuario_nombre='%s'", $password_read,$usuario_mod);
	echo $query.'<br>';
	$result = mysql_query($query,$link);
	if(!$result)
	{
		echo "ERROR";
	}
	else
	{
		$query = sprintf("SELECT usuario_email FROM clientes_usuarios WHERE usuario_nombre='%s'", $usuario_mod);
		echo $query.'<br>';
		$result = mysql_query($query,$link);
		if(!$result)
		{
			echo "ERROR";
		}
		else
		{
			if($row = mysql_fetch_array($result))
			{
				$email_subject = $idiomas[$_SESSION['opcion_idioma']]['login_text2'];
				//$email_subject = utf8_decode('é');
				$email_target2 = $row['usuario_email'];
		
				if ($TLS == 1)
				{
					$cadena_seguridad = '-S smtp-use-starttls';
				}
				
				$Cadena_Final=$idiomas[$_SESSION['opcion_idioma']]['login_text3']." ".$usuario_mod.".<br/>".$idiomas[$_SESSION['opcion_idioma']]['login_text4']." ".$password_read.".<br/>".$idiomas[$_SESSION['opcion_idioma']]['login_text5'].".";
				//echo $Cadena_Final.'<br>';
				$cadena_mail = "sendemail -f ".$email_source." -t ".$email_target2." -s ".$smtp_servidor.":".$smtp_port." -xu ".$smtp_user." -xp ".$smtp_pw." -u \"".$email_subject."\" -m \"".$header_email.$Cadena_Final.$footer_email."\" > /dev/null";
				
				//echo "<script>alert(\"".$cadena_mail."\");</script>";
				//echo $cadena_mail.'<br>';
				system($cadena_mail);
				//mail('carmelo.garcia@balmart.es','Ole','tricotrin');
			}
			else
			{
				echo "ERROR";
			}
		}
	}
	mysql_close($link);
?>
