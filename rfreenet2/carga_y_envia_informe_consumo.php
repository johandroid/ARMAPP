<?
session_start();
ini_set('memory_limit','200M');
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/datos_email.inc';
include 'inc/funciones_aux.inc';

define('FPDF_FONTPATH','font/');
require("fpdf16/mysql_table.php");
require('mem_image/mem_image.php');
require('phplot/phplot.php');

$cliente = $_POST["IDCliente"];
$cliente_nombre = $_POST["NombreCliente"];
$Destino = $_POST["Destino"];
$idiomauser = $_POST['idiomauser'];
//echo $cliente.'__'.$cliente_nombre.'__'.$Destino.'__'.$idiomauser.'<br>';

$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_name_clientes, $link);

if (date(m) == 1)
{
	$mes_informe = 12;
}
else
{
	$mes_informe = date(m) -1;
}
$NombreMesActual=$idiomas[$idiomauser]['mes'.$mes_informe];

$query = "";
$cadena_actual=sprintf("%02u%04u",$mes_informe,date(Y));
$NombreTabla = "clientes_sms_".$cadena_actual;
//echo $NombreTabla.'<br>';
if (table_exists($NombreTabla, $link))
{
	$query = sprintf("select %s.rfreenet_texto_eventos_%s.evento_texto,clientes_datos.cliente_nombre,%s.instalacion_id,%s.instalacion_nombre,%s.sms_destino,%s.cliente_id,%s.sms_evento,%s.sms_fecha_out from 
	 %s inner join clientes_datos on (%s.cliente_id=clientes_datos.cliente_id) 
		 inner join clientes_suscriptores on (%s.gw_id = clientes_suscriptores.gw_id AND
                                                           %s.instalacion_id = clientes_suscriptores.instalacion_id)
		 inner join %s.rfreenet_texto_eventos_%s on (%s.rfreenet_texto_eventos_%s.evento_codigo=%s.sms_evento AND 
                   (%s.rfreenet_texto_eventos_%s.evento_tipo = clientes_suscriptores.gw_tipo OR %s.rfreenet_texto_eventos_%s.evento_tipo = -1))  
WHERE sms_enviado='1' AND %s.cliente_id='%s' ORDER BY sms_fecha_out DESC", $db_name_general, $idiomauser, $NombreTabla, $NombreTabla, $NombreTabla, $NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$db_name_general,$idiomauser,$db_name_general,$idiomauser,$NombreTabla,$db_name_general,$idiomauser,$db_name_general,$idiomauser,$NombreTabla,$cliente);
	//echo $query.'<br>';
	$result = mysql_query($query,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);

	//Clases y funciones *******************************************
	class PDF extends MEM_IMAGE
	{
		function Header()
		{
			$this->Image('images/balmart.jpg',15,12,15,15);
			$this->SetFont('Arial','I',10);
			$this->Cell(0,10,utf8_decode($GLOBALS['idiomas'][$GLOBALS['idiomauser']]['general00']),0,0,'C');
			$this->Ln();
			$this ->Cell(0,10,utf8_decode($GLOBALS['idiomas'][$GLOBALS['idiomauser']]['general127']),0,1,'C');
			$this->Ln(10);
			parent::Header();
		}
		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I',8);
			$this->Cell(0,10,utf8_decode($GLOBALS['idiomas'][$GLOBALS['idiomauser']]['general126'].' '.$this->PageNo()),0,0,'C');
		}
	}
	
	$pdf=new PDF();
	$pdf->Open();
	
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',20);
	$pdf ->Cell(0,60,'',0,1,'C');
	$pdf->SetFont('Arial','B',16);
	if ($cliente != 0)
	{
		$pdf ->Cell(0,20,utf8_decode($idiomas[$idiomauser]['general1'].': '.$cliente_nombre.' ('.$cliente.')'),0,1,'C');
	}
	$pdf ->Cell(0,20,utf8_decode($idiomas[$idiomauser]['general112']),0,1,'C');
	$pdf ->Cell(0,20,utf8_decode($idiomas[$idiomauser]['general157'].' '.$NombreMesActual.' '.date(Y)),0,1,'C');
	
	$pdf->AddPage();
	$pdf ->Ln(30);
	$pdf->SetFont('Arial','B',12);
	$pdf ->SetLeftMargin(40);
	$pdf ->Cell(0,20,utf8_decode($idiomas[$idiomauser]['general116']),0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf ->Cell(0,10,utf8_decode($idiomas[$idiomauser]['general1'].'.................................'.$cliente_nombre.' ('.$cliente.')'),0,1,'L');	
	$pdf ->Cell(0,20,utf8_decode($idiomas[$idiomauser]['general117'].'................................'.$NombreMesActual.' '.$idiomas[$idiomauser]['general156']).' '.date(Y),0,1,'L');
	$pdf ->Cell(0,20,utf8_decode($idiomas[$idiomauser]['general7'].'...........................'.$idiomas[$idiomauser]['general110']),0,1,'L');		
	
	$pdf->SetFont('Arial','B',10);
	if ($result)
	{
		$numero_sms = mysql_num_rows($result);		
		$pdf ->Cell(0,20,utf8_decode($idiomas[$idiomauser]['general122']).'...........................'.$numero_sms,0,1,'L');
		$pdf ->SetLeftMargin(10);
		$pdf->SetFont('Arial','B',12);
		$num_filas = 25;
		while ($row = mysql_fetch_array($result))
		{
			if ($num_filas == 25)
			{
				$num_filas = 0;
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',12);
		
				$pdf ->Cell(50,8,utf8_decode($idiomas[$idiomauser]['general7']),1,0,'C');
				$pdf ->Cell(70,8,utf8_decode($idiomas[$idiomauser]['general31']),1,0,'C');
				$pdf ->Cell(30,8,utf8_decode($idiomas[$idiomauser]['general123']),1,0,'C');
				$pdf ->Cell(40,8,utf8_decode($idiomas[$idiomauser]['general8']),1,0,'C');
				$pdf ->Ln();
			}
			
			$pdf->SetFont('Arial','',10);
	
			if ($row["instalacion_nombre"] == '')
			{
				$pdf ->Cell(50,8,utf8_decode($idiomas[$idiomauser]['general7'].' '.$row["instalacion_id"]),1,0,'C');
			}
			else
			{
				$pdf ->Cell(50,8,utf8_decode($row["instalacion_nombre"]),1,0,'C');
			}
			$pdf ->Cell(70,8,utf8_decode($row['texto']),1,0,'C');
			$pdf ->Cell(30,8,$row['sms_destino'],1,0,'C');
			$pdf ->Cell(40,8,$row['sms_fecha_out'],1,0,'C');
			$pdf ->Ln();
			$num_filas++;
		}
	}
	else
	{
		//echo "No se han encontrado resultados";
		$pdf ->Cell(0,20,utf8_decode($idiomas[$idiomauser]['general122']).'...........................'.$numero_sms,0,1,'C');
		$pdf ->SetLeftMargin(10);
		//$img = file_get_contents("images/sin_datos.jpg");
		//echo $img;
	}
	$pdf_filename='/var/www/rfreenet2/informes_sms/'.$idiomas[$idiomauser]['general124'].'_SMS_'.$cliente_nombre.'_'.pad_izquierda($mes_informe,2,"0").date(Y).'.pdf';
	//$pdfdoc=$pdf->Output($pdf_filename,'I');
	$pdfdoc=$pdf->Output($pdf_filename,'F');
	
	$Cadena_Final=utf8_decode($idiomas[$idiomauser]['general158']." ".$cliente_nombre." (".$cliente.") ".$idiomas[$idiomauser]['general159']." ".$NombreMesActual." ".$idiomas[$idiomauser]['general156']." ".date(Y));
	//echo $Cadena_Final;
	$subject=utf8_decode($idiomas[$idiomauser]['general160']." ".$cliente_nombre." (".$cliente.") ".$idiomas[$idiomauser]['general156']." ".$NombreMesActual." ".$idiomas[$idiomauser]['general156']." ".date(Y));
	//echo $subject;

	// send message
	if ($TLS == 1)
	{
		$cadena_seguridad = '-S smtp-use-starttls';
	}
	else
	{
		$cadena_seguridad = '';
	}
	//$cadena_mail = "echo ".escapeshellarg($Cadena_Final)." | mail -a $pdf_filename -r \"$email_source\" -s \"$subject\" $cadena_seguridad -S smtp=$smtp_servidor:$smtp_port -S smtp-auth-user=$smtp_user -S smtp-auth-password=\"$smtp_pw\" \"$Destino\"";
	$cadena_mail = "sendemail -a ".$pdf_filename." -f ".$email_source." -t ".$Destino." -s ".$smtp_servidor.":".$smtp_port." -xu ".$smtp_user." -xp ".$smtp_pw." -u \"".$subject."\" -m \"".$header_email.$Cadena_Final.$footer_email."\" > /dev/null";
	//echo `.$cadena_mail.`;
	//echo $cadena_mail;
	system($cadena_mail);
}
mysql_close($link);
?>
