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
	<table border="0" width="100%">
		<tr>
			<td colspan="5"><br/></td>
		</tr>
		<tr>
			<td colspan="5"><br/></td>
		</tr>
		<tr>
			<td colspan="5"><br/></td>
		</tr>
		<tr>
			<td style="width:10%"></td>
			<td style="width:20%" class="bottom_tborder" align="left">
				<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general4']?>:</span>
			</td>
			<td style="width:40%"></td>
			<td style="width:20%"></td>
			<td style="width:10%"></td>
		</tr>
		<tr>
			<td style="width:10%"></td>
			<td colspan="3">
				<span class="texto_valores"><?php echo '  '.$idiomas[$_SESSION['opcion_idioma']]['general210']?>.'.'</span>
			</td>
			<td style="width:10%"></td>
		</tr>
		<tr>
			<td style="width:10%"></td>
			<td colspan="3">
				<span class="texto_valores"><?php echo '  '.$idiomas[$_SESSION['opcion_idioma']]['general211']?>.'.'</span>
			</td>
			<td style="width:10%"></td>
		</tr>
		<tr>
			<td colspan="5"><br/></td>
		</tr>
		<tr>
			<td colspan="5"><br/></td>
		</tr>
		<tr>
			<td colspan="5"><br/></td>
		</tr>
		<tr>
			<td style="width:10%"></td>
			<td style="width:20%" class="bottom_tborder" align="left">
				<span class="texto_parametros"><?php echo $idiomas[$_SESSION['opcion_idioma']]['general3']?>:</span>
			</td>
			<td style="width:40%"></td>
			<td style="width:20%"></td>
			<td style="width:10%"></td>
		</tr>
		<tr>
			<td style="width:10%"></td>
			<td colspan="3">
				<span class="texto_valores"><?php echo '  '.$idiomas[$_SESSION['opcion_idioma']]['general212']?>.'.'</span>
			</td>
			<td style="width:10%"></td>
		</tr>
		<tr>
			<td colspan="5"><br/></td>
		</tr>
	</table>
</body>
</html>