<?
session_start();
ini_set('memory_limit','200M');
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/datos_email.inc';
include 'inc/funciones_aux.inc';
include 'inc/funciones_db.inc';

define('FPDF_FONTPATH','font/');
require("fpdf16/mysql_table.php");
require('mem_image/mem_image.php');
require('phplot/phplot.php');

$cliente_db = $_POST["BDCliente"];
//$email_on[0] = $_POST["Email1ON"];
$email = $_POST["Email1"];
$email_idioma = $_POST["Email1Idioma"];
/*$email_on[1] = $_POST["Email2ON"];
$email[1] = $_POST["Email2"];
$email_idioma[1] = $_POST["Email2Idioma"];*/
$gw_off = $_POST["GWOFF"];
$utr_off = $_POST["UTROFF"];
$utc_off = $_POST["UTCOFF"];
$gw_bat = $_POST["GWBat"];
$utr_bat = $_POST["UTRBat"];
$utr_cob = $_POST["UTRCob"];
//echo $cliente.'__'.$cliente_nombre.'__'.$Destino.'__'.$idiomauser.'<br>';

$link = mysql_connect($db_host, $db_user, $db_pass);
//echo "Hi\r\n";
mysql_select_db($cliente_db, $link);

$fecha_actual = date_create();
//echo "Fecha actual ".date_format($fecha_actual, 'Y-m-d H:i:s')."\r\n";
$ts_actual = date_timestamp_get($fecha_actual);
$timestamp_inicio_diario = strtotime("-1 day",$ts_actual);

$fecha_inicio = date("Y-m-d 00:00:00",$timestamp_inicio_diario);
$fecha_fin = date("Y-m-d 23:59:59",$timestamp_inicio_diario);

//echo "Fecha inicio ".$fecha_inicio." y fin ".$fecha_fin."\r\n";

//echo " Meses ".$NombreMesActual[0]." ".$NombreMesActual[1]."\r\n";
$query = "";
$cadena_actual=sprintf("%02u%04u",date("m",$timestamp_inicio_diario),date("Y",$timestamp_inicio_diario));
//echo $cadena_actual."\r\n";
$NombreTabla = "cliente_eventos_".$cadena_actual;

if (table_exists($NombreTabla, $link))
{
	$query_where = "";
	$inicio = 0;
	if($gw_off==1)
	{
		if($inicio==0)
		{
			$query_where .= " WHERE (";
			$inicio = 1;
		}
		else
		{
			$query_where .= " OR";
		}
		
		$query_where .= " evento_codigo='016'";
	}
	if($utr_off==1)
	{
		if($inicio==0)
		{
			$query_where .= " WHERE (";
			$inicio = 1;
		}
		else
		{
			$query_where .= " OR";
		}
		
		$query_where .= " evento_codigo='006'";
	}
	if($utc_off==1)
	{
		if($inicio==0)
		{
			$query_where .= " WHERE (";
			$inicio = 1;
		}
		else
		{
			$query_where .= " OR";
		}
		
		$query_where .= " evento_codigo='020'";
	}
	if($gw_bat==1)
	{
		if($inicio==0)
		{
			$query_where .= " WHERE (";
			$inicio = 1;
		}
		else
		{
			$query_where .= " OR";
		}
		
		$query_where .= " evento_codigo='008'";
	}
	if($utr_bat==1)
	{
		if($inicio==0)
		{
			$query_where .= " WHERE (";
			$inicio = 1;
		}
		else
		{
			$query_where .= " OR";
		}
		
		$query_where .= " evento_codigo='007'";
	}
	if($utr_cob==1)
	{
		if($inicio==0)
		{
			$query_where .= " WHERE (";
			$inicio = 1;
		}
		else
		{
			$query_where .= " OR";
		}
		
		$query_where .= " evento_codigo='009'";
	}
	if($inicio==0)
	{
		$query_where .= " WHERE";
		$inicio = 1;
	}
	else
	{
		$query_where .= ") AND ";
	}
	
	$query_where .= " (evento_fecha>='".$fecha_inicio."' AND evento_fecha<='".$fecha_fin."')";
	
	$query_basica = sprintf("SELECT * FROM %s as cliente_eventos %s ORDER BY evento_fecha ASC", $NombreTabla, $query_where);
		
	$query_final = sprintf("select cliente_eventos1.gw_id AS gw_id,
									cliente_eventos1.evento_codigo AS evento_codigo,
								   cliente_eventos1.instalacion_id as instalacion_id,
								   cliente_instalaciones.instalacion_nombre as instalacion_nombre,
								   cliente_eventos1.nodo_mac AS nodo_mac, 
								   cliente_eventos1.nodo_ip AS nodo_ip, 
								   IF (((cliente_eventos1.nodo_ip = '000') OR (cliente_eventos1.nodo_ip = '001')), '000',cliente_eventos1.nodo_mac) AS nodo_mac,
								   IF (((cliente_eventos1.nodo_ip = '000') OR (cliente_eventos1.nodo_ip = '001')), cliente_gateways.gw_nombre, 
								   		IF(((cliente_eventos1.evento_codigo > 299) AND (cliente_eventos1.evento_codigo<400)),
								   		cliente_analizadores.analizador_nombre,cliente_nodos.nodo_nombre)) AS nombre,
								   cliente_eventos1.evento_codigo AS evento_codigo,
								   %s.rfreenet_texto_eventos_es.evento_texto AS texto_es,
								   %s.rfreenet_texto_eventos_en.evento_texto AS texto_en,
								   %s.rfreenet_texto_eventos_fr.evento_texto AS texto_fr,
								   cliente_eventos1.evento_fecha AS fecha  
							   from cliente_instalaciones inner join (cliente_analizadores right join 
							   		(cliente_nodos right join 
							   	    (%s.rfreenet_texto_eventos_es 
							   	    right join (%s.rfreenet_texto_eventos_en
							   	    right join (%s.rfreenet_texto_eventos_fr 
							   	    right join (cliente_gateways 
							   	    right join (%s) as cliente_eventos1 on 
							   	    (cliente_gateways.gw_id = cliente_eventos1.gw_id)) on 
							   	    (cliente_eventos1.evento_codigo = %s.rfreenet_texto_eventos_fr.evento_codigo  AND 
							   	    						(%s.rfreenet_texto_eventos_fr.evento_tipo = cliente_gateways.gw_tipo OR
                                                             %s.rfreenet_texto_eventos_fr.evento_tipo = -1))) on
							   	    (cliente_eventos1.evento_codigo = %s.rfreenet_texto_eventos_en.evento_codigo AND 
							   	    								 (%s.rfreenet_texto_eventos_en.evento_tipo = cliente_gateways.gw_tipo OR
                                                             		  %s.rfreenet_texto_eventos_en.evento_tipo = -1))) on
							   	    (cliente_eventos1.evento_codigo = %s.rfreenet_texto_eventos_es.evento_codigo  AND 
					   	   										 	 (%s.rfreenet_texto_eventos_es.evento_tipo = cliente_gateways.gw_tipo OR
                                                            		  %s.rfreenet_texto_eventos_es.evento_tipo = -1))) on 							   	    
							   	    (cliente_nodos.nodo_mac = cliente_eventos1.nodo_mac AND cliente_nodos.gw_id=cliente_eventos1.gw_id)) on 
							   	    (cliente_eventos1.nodo_mac=cliente_analizadores.analizador_id AND 
							   	    cliente_eventos1.evento_codigo>299 AND cliente_eventos1.evento_codigo<400)) on 
							   	    (cliente_eventos1.instalacion_id = cliente_instalaciones.instalacion_id)
							   ORDER BY fecha ASC", $db_name_general, $db_name_general, $db_name_general, $db_name_general, $db_name_general, $db_name_general, $query_basica,
							     				    $db_name_general, $db_name_general, $db_name_general, $db_name_general, $db_name_general, $db_name_general, 
							     				    $db_name_general, $db_name_general, $db_name_general);
		
	//$query = sprintf("select %s.rfreenet_texto_eventos_%s.evento_texto,clientes_datos.cliente_nombre,%s.instalacion_id,%s.instalacion_nombre,%s.sms_destino,%s.cliente_id,%s.sms_evento,%s.sms_fecha_out from ((%s inner join clientes_datos on %s.cliente_id=clientes_datos.cliente_id) inner join %s.rfreenet_texto_eventos_%s on %s.rfreenet_texto_eventos_%s.evento_codigo=%s.sms_evento)  WHERE sms_enviado='1' AND %s.cliente_id='%s' ORDER BY sms_fecha_out DESC", $db_name_general, $idiomauser, $NombreTabla, $NombreTabla, $NombreTabla, $NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$db_name_general,$idiomauser,$db_name_general,$idiomauser,$NombreTabla,$NombreTabla,$cliente);
	//echo $query_final."\r\n";
	$result = mysql_query($query_final,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);
		
	$cliente_nombre = substr($cliente_db,8);

	

	//echo $cliente_nombre."\r\n";
	//echo utf8_decode($idiomas[$email_idioma]['general00']);

	//Clases y funciones *******************************************
	class PDF extends MEM_IMAGE
	{
		function Header()
		{
			
			$this->Image('images/balmart.jpg',15,12,15,15);
			$this->SetFont('Arial','I',10);
			
			$this->Cell(0,10,utf8_decode($GLOBALS['idiomas'][$GLOBALS['email_idioma']]['general00']),0,0,'C');
			$this->Ln();
			$this ->Cell(0,10,utf8_decode($GLOBALS['idiomas'][$GLOBALS['email_idioma']]['general127']),0,1,'C');
			$this->Ln(10);
			parent::Header();
		}
		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I',8);
			$this->Cell(0,10,utf8_decode($GLOBALS['idiomas'][$GLOBALS['email_idioma']]['general126'].' '.$this->PageNo()),0,0,'C');
		}
	}
	
	$pdf=new PDF();
	$pdf->Open();
	
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',20);
	$pdf ->Cell(0,60,'',0,1,'C');
	$pdf->SetFont('Arial','B',16);
	$pdf ->Cell(0,20,utf8_decode($idiomas[$email_idioma]['general1'].': '.$cliente_nombre),0,1,'C');
	
	$pdf ->Cell(0,20,$idiomas[$email_idioma]['general332'],0,1,'C');
	$pdf ->Cell(0,20,utf8_decode($idiomas[$email_idioma]['general137'].': '.date("Y-m-d",$timestamp_inicio_diario)),0,1,'C');
	
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',10);
	//$pdf->Cell(0,10,'',0,1,'C');
	//$pdf->Cell(15,10,'',0,0,'C');
	$pdf->Cell(40,10,utf8_decode($idiomas[$email_idioma]['general7']),1,0,'C');
	$pdf->Cell(40,10,utf8_decode($idiomas[$email_idioma]['general128']),1,0,'C');
	$pdf->Cell(40,10,utf8_decode($idiomas[$email_idioma]['general31']),1,0,'C');
	$pdf->Cell(35,10,utf8_decode($idiomas[$email_idioma]['general333']),1,0,'C');
	$pdf->Cell(35,10,utf8_decode($idiomas[$email_idioma]['general334']),1,1,'C');
	$pdf->SetFont('Arial','B',9);
	$i=0;
	if($result)
	{
		while ($row = mysql_fetch_array($result))
		{
			if($i==22)
			{
				$i=0;
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',10);
				//$pdf->Cell(15,10,'',0,0,'C');
				$pdf->Cell(40,10,utf8_decode($idiomas[$email_idioma]['general7']),1,0,'C');
				$pdf->Cell(40,10,utf8_decode($idiomas[$email_idioma]['general128']),1,0,'C');
				$pdf->Cell(40,10,utf8_decode($idiomas[$email_idioma]['general31']),1,0,'C');
				$pdf->Cell(35,10,utf8_decode($idiomas[$email_idioma]['general333']),1,0,'C');
				$pdf->Cell(35,10,utf8_decode($idiomas[$email_idioma]['general334']),1,1,'C');
				$pdf->SetFont('Arial','B',9);
			}
			//$pdf->Cell(15,10,'',0,0,'C');
			$pdf->Cell(40,10,utf8_decode($row['instalacion_nombre']),1,0,'C');
			if($row['nombre']=="")
			{
				switch($row['evento_codigo'])
				{
					case '006':
					case '007':
					case '009':
						$pdf->Cell(40,10,utf8_decode($idiomas[$email_idioma]['general21']." ".$row['nodo_mac']),1,0,'C');
						break;
					case '020':
						$pdf->Cell(40,10,utf8_decode($idiomas[$email_idioma]['general255']." ".$row['nodo_ip']),1,0,'C');
						break;
					case '016':
					case '008':
					default:
						$pdf->Cell(40,10,utf8_decode($idiomas[$email_idioma]['general20']." ".$row['gw_id']),1,0,'C');
						break;
				}
			}
			else 
			{
				$pdf->Cell(40,10,utf8_decode($row['nombre']),1,0,'C');
			}
			
			$pdf->Cell(40,10,utf8_decode($row['texto_'.$email_idioma]),1,0,'C');
			$timezone = sObtener_TimeZone_Instalacion($cliente_db, $row['instalacion_id']);
			$fecha_instal = sObtener_Fecha_Desde_String($cliente_db, $row['instalacion_id'], $row['fecha'], $timezone);
			$pdf->Cell(35,10,utf8_decode($fecha_instal),1,0,'C');
			$pdf->Cell(35,10,utf8_decode($row['fecha']),1,1,'C');
			
		}
	}			
			
	$pdf_filename='/var/www/rfreenet2/informes_diarios/'.$idiomas[$email_idioma]['general124'].'_'.$cliente_nombre.'_'.date("Y-m-d",$timestamp_inicio_diario)."_".$email_idioma.'.pdf';
	//$pdfdoc=$pdf->Output($pdf_filename,'I');
	$pdfdoc=$pdf->Output($pdf_filename,'F');
	
	$Cadena_Final=$idiomas[$email_idioma]['general332']." (".utf8_decode($idiomas[$email_idioma]['general1'])." ".$cliente_nombre.") ".date("Y-m-d",$timestamp_inicio_diario);
	//echo $Cadena_Final."\r\n";
	
		//$subject=$idiomas[$idiomauser]['general160']." ".$cliente_nombre." (".$cliente.") ".$idiomas[$idiomauser]['general156']." ".$NombreMesActual." ".$idiomas[$idiomauser]['general156']." ".date(Y);
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
	//$cadena_mail = "echo ".escapeshellarg($Cadena_Final)." | mail -a $pdf_filename -r \"$email_source\" -s \"$Cadena_Final\" $cadena_seguridad -S smtp=$smtp_servidor:$smtp_port -S smtp-auth-user=$smtp_user -S smtp-auth-password=\"$smtp_pw\" \"$email\"";
	$cadena_mail = "sendemail -a ".$pdf_filename."-f ".$email_source." -t ".$email." -s ".$smtp_servidor.":".$smtp_port." -xu ".$smtp_user." -xp ".$smtp_pw." -u \"".$email_subject."\" -m \"".$header_email.$Cadena_Final.$footer_email."\" > /dev/null";
	//echo `.$cadena_mail.`;
	//echo $cadena_mail;
	system($cadena_mail);

}
mysql_close($link);
?>
