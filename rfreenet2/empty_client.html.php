<?php session_start();
include 'inc/idiomas.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>RFreeNET Data</title>	
	<link rel="stylesheet" href="css/plantilla_css.css" type="text/css"/>
	<script type="text/javascript" src="js/funciones_principal.js?time=<?php echo(filemtime("js/funciones_principal.js"));?>"></script>
</head>

<body>
<form>
	<table border="0" width="100%">
		<tr>
			<td><br/><br/><br/><br/><br/></td>
		</tr>
		<tr>
			<td align="center" valign="bottom"  style="width:100%">
				<table border="0">
					<tr>
						<td style="width:20%"></td>
						<td style="width:60%" align="center"><span><?php echo $idiomas[$_SESSION['opcion_idioma']]['instala_text2'].'.'?></span></td>
						<td style="width:20%"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
</body>
</html>