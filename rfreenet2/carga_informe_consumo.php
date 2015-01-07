<?
ini_set('memory_limit','100M');
session_start();
include 'inc/idiomas.inc';
include 'inc/datos_db.inc';
include 'inc/funciones_aux.inc';

define('FPDF_FONTPATH','font/');
require("fpdf16/mysql_table.php");
require('mem_image/mem_image.php');
require('phplot/phplot.php');

include ('PHPexcel/PHPExcel.php');
include('PHPexcel/PHPExcel/Writer/Excel5.php');
include ('PHPexcel/PHPExcel/IOFactory.php');

$min_filas_tabla = 7;
$cifras_num_sms = 12;

$cliente = $_GET["cliente_id"];
$cliente_nombre = $_GET["cliente_nombre"];
$instalacion = $_GET["instalacion_id"];
$instalacion_nombre = $_GET["instalacion_nombre"];
$fecha_begin = $_GET["fecha_begin"];
$fecha_end = $_GET["fecha_end"];
$tipo_informe = $_GET["tipo_informe"];

$link = mysql_connect($db_host, $db_user, $db_pass);

mysql_select_db($db_name_clientes, $link);

$query = "";

//$NombreTabla="cliente_eventos_".date(mY);
if($fecha_begin !=0 && $fecha_end!=0)
{
	//echo "Fecha inicio ".$fecha_begin." Fecha fin ".$fecha_end."<br>";
	list($fecha_begin_ex,$hora_init_ex)= explode (" ",$fecha_begin);
	list($fecha_end_ex,$hora_end_ex)= explode (" ",$fecha_end);
	
	list($anyo_begin,$mes_begin,$pipo)= explode ("-",$fecha_begin_ex);
	list($anyo_end,$mes_end,$pipo)= explode("-",$fecha_end_ex);		
}
else
{
	$mes_begin = date(m);
	$mes_end = date(m);
	$anyo_begin = date(Y);
	$anyo_end = date(Y);
}	

//echo "Mes inicio ".intval($mes_begin)." Mes fin ".intval($mes_end)."<br>";
//echo "Anyo inicio ".intval($anyo_begin)." Anyo fin ".intval($anyo_end)."<br>";

$query_final = "select * from (";
$i=0;	
//echo $query_final."<br>";
if(($fecha_begin ==0) || ($fecha_end==0))
{
	if ($mes_begin == 1)
	{
		$mes_begin = 12;
		$mes_end=intval($mes_end);
		$anyo_begin=intval($anyo_begin)-1;
		$anyo_end=intval($anyo_end);
	}
	else
	{
		$mes_begin=intval($mes_begin)-1;
		$mes_end=intval($mes_end);
		$anyo_begin=intval($anyo_begin);
		$anyo_end=intval($anyo_end);
	}	
}
else
{
	$mes_begin=intval($mes_begin);
	$mes_end=intval($mes_end);
	$anyo_begin=intval($anyo_begin);
	$anyo_end=intval($anyo_end);
}
//echo "Mes inicio ".$mes_begin." Mes fin ".$mes_end."<br>";
//echo "Anyo inicio ".$anyo_begin." Anyo fin ".$anyo_end."<br>";
$mes_actual=$mes_begin;
$anyo_actual=$anyo_begin;

$cadena_inicial=sprintf("%02u%04u",$mes_actual,$anyo_begin);
$cadena_final=sprintf("%02u%04u",$anyo_actual,$anyo_end);
$cadena_actual=$cadena_inicial;
$primero = 1;

while($cadena_actual!='FIN')
{
	$NombreTabla = "clientes_sms_".$cadena_actual;
	$queryaux='';
	if (table_exists($NombreTabla, $link)) 
	{

		if($primero!=1)
		{
			$query_final .= " UNION ";
			//echo $query_final."<br>";
			$queryaux = "";
		}
		//echo $query_final."<br>";		
		//echo $NombreTabla.'<br>';
		$query = sprintf("(select %s.rfreenet_texto_eventos_%s.evento_texto,clientes_datos.cliente_nombre,%s.instalacion_id,%s.instalacion_nombre,%s.sms_destino,%s.cliente_id,%s.sms_evento,%s.sms_fecha_out 
		 from %s inner join clientes_datos on (%s.cliente_id=clientes_datos.cliente_id) 
		 inner join clientes_suscriptores on (%s.gw_id = clientes_suscriptores.gw_id AND
                                                           %s.instalacion_id = clientes_suscriptores.instalacion_id)
		 inner join %s.rfreenet_texto_eventos_%s on (%s.rfreenet_texto_eventos_%s.evento_codigo=%s.sms_evento AND 
                   (%s.rfreenet_texto_eventos_%s.evento_tipo = clientes_suscriptores.gw_tipo OR %s.rfreenet_texto_eventos_%s.evento_tipo = -1))
		 WHERE sms_enviado='1' ", $db_name_general,$_SESSION['opcion_idioma'], $NombreTabla, $NombreTabla, $NombreTabla, $NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$NombreTabla,$db_name_general,$_SESSION['opcion_idioma'],$db_name_general,$_SESSION['opcion_idioma'],$NombreTabla,$db_name_general,$_SESSION['opcion_idioma'],$db_name_general,$_SESSION['opcion_idioma']);
				
		if ($cliente != 0)
		{
			$queryaux .= " AND ".$NombreTabla.".cliente_id='".$cliente."' ";
		}
		if ($instalacion != 0)
		{
			 $queryaux .= " AND instalacion_id='".$instalacion."' ";
		}
		if ($fecha_begin != 0)
		{
			$queryaux .= " AND sms_fecha_out>='".$fecha_begin."' ";
		}
		if ($fecha_end != 0)
		{
			$queryaux .= " AND sms_fecha_out<='".$fecha_end."' ";
		}
		
		$query.=$queryaux;
		$query.=")";
		$query_final.=$query;
		//echo $query_final."<br>";
		$primero = 0;
	}
	
	if ($anyo_actual<$anyo_end)
	{
		//echo 'ActualY='.$anyo_actual.' ENDY='.$anyo_end.'<br>';
		if ($mes_actual<12)
		{
			$mes_actual++;
		}
		else
		{
			$mes_actual=1;
			$anyo_actual++;
		}
		$cadena_actual=sprintf("%02u%04u", $mes_actual, $anyo_actual);
		//echo $cadena_actual.'<br>';
	}
	else if ($anyo_actual==$anyo_end)
	{
		//echo 'ActualM='.$mes_actual.' ENDM='.$mes_end.'<br>';
		if ($mes_actual<$mes_end)
		{
			$mes_actual++;
			$cadena_actual=sprintf("%02u%04u", $mes_actual, $anyo_actual);
		}
		else
		{
			$cadena_actual='FIN';
		}
		//echo $cadena_actual.'<br>';
	}
}
if (($query_final != "") && ($primero != 1))
{
	$query_final .= ") AS tabla_final ORDER BY tabla_final.sms_fecha_out DESC";	
	//echo $query_final.'<br>';
	$result = mysql_query($query_final,$link);// or die('DIE:'.mysql_error()."<br>".$query_final);
}
else
{
	$num_total_filas= $min_filas_tabla;
	//echo pad_izquierda($num_total_filas,$cifras_num_sms,'0');
	$result = false;
}

$fecha_actual = strftime('%Y-%m-%d %T', time());

if ($tipo_informe=="PDF")
{
	//Clases y funciones *******************************************
	class PDF extends MEM_IMAGE
	{
		function Header()
		{
			include 'inc/idiomas.inc';
			$this->Image('images/balmart.jpg',35,8,20,20);
			$this->SetFont('helvetica','',18);
			$this->Cell(0,6,'RFreeNET Green',0,1,'C');
			$this->Image('images/logo_green.jpg',165,8,20,20);
			//parent::Header();
		}
		function Footer()
		{
			include 'inc/idiomas.inc';
			$this->SetY(-15);
			$this->SetFont('Arial','I',8);
			$this->Cell(0,10,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general126']).' '.$this->PageNo(),0,0,'C');
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
		$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general1'].': '.$cliente_nombre.' ('.$cliente.')'),0,1,'C');
	}
	$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general112']),0,1,'C');
	if ($fecha_begin != 0)
	{
		if ($fecha_end != 0)
		{
			$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general113'].' '.$fecha_begin.' - '.$fecha_end),0,1,'C');
		}
		else
		{
			$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general113'].' '.$fecha_begin.' - '.$fecha_actual),0,1,'C');
		}
	}
	else
	{
		if ($fecha_end != 0)
		{
			$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general114'].' '.$fecha_end),0,1,'C');
		}
		else
		{
			$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general115'].' '.$fecha_actual),0,1,'C');
		}
	}
	
	
	$pdf->AddPage();
	$pdf ->Ln(30);
	$pdf->SetFont('Arial','B',12);
	$pdf ->SetLeftMargin(40);
	$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general116']),0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf ->Cell(0,10,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general1'].'.................................'.$cliente_nombre.' ('.$cliente.')'),0,1,'L');	
	if ($fecha_begin != 0)
	{
		if ($fecha_end != 0)
		{
			$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general117'].'................................'.$fecha_begin.' a '.$fecha_end),0,1,'L');
		}
		else
		{
			$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general117'].'................................'.$idiomas[$_SESSION['opcion_idioma']]['general118'].' '.$fecha_begin.' '.$idiomas[$_SESSION['opcion_idioma']]['general119'].' '.$fecha_actual),0,1,'L');
		}
	}
	else
	{
		if ($fecha_end != 0)
		{
			$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general117'].'................................ '.$idiomas[$_SESSION['opcion_idioma']]['general119'].' '.$fecha_end),0,1,'L');
		}
		else
		{
			$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general117'].'................................'.$idiomas[$_SESSION['opcion_idioma']]['general120'].' '.$fecha_actual),0,1,'L');
		}
	}	
	if ($instalacion != 0)
	{
		if ($instalacion_nombre != "")
		{
			$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general7'].'...........................'.$instalacion_nombre.' ('.$instalacion.')'),0,1,'L');
		}
		else
		{
			$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general7'].'...........................'.$idiomas[$_SESSION['opcion_idioma']]['general7'].' '.$instalacion),0,1,'L');
		}
	}
	else
	{
		$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general7'].'...........................'.$idiomas[$_SESSION['opcion_idioma']]['general121']),0,1,'L');		
	}
	
	$pdf->SetFont('Arial','B',10);
	if ($result)
	{
		$numero_sms = mysql_num_rows($result);		
		$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general122'].' SMS...........................'.$numero_sms),0,1,'L');
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
				$pdf ->Ln(30);
		
				$pdf ->Cell(50,8,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general7']),1,0,'C');
				$pdf ->Cell(70,8,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general31']),1,0,'C');
				$pdf ->Cell(30,8,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general123']),1,0,'C');
				$pdf ->Cell(40,8,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general8']),1,0,'C');
				$pdf ->Ln();
			}
			
			$pdf->SetFont('Arial','',10);

			if ($row["instalacion_nombre"] == '')
			{
				$pdf ->Cell(50,8,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general7'].' '.$row["instalacion_id"]),1,0,'C');
			}
			else
			{
				$pdf ->Cell(50,8,utf8_decode($row["instalacion_nombre"]),1,0,'C');
			}
			$pdf ->Cell(70,8,utf8_decode($row['evento_texto']),1,0,'C');
			$pdf ->Cell(30,8,utf8_decode($row['sms_destino']),1,0,'C');
			$pdf ->Cell(40,8,utf8_decode($row['sms_fecha_out']),1,0,'C');
			$pdf ->Ln();
			$num_filas++;
		}
	}
	else
	{
		//echo "No se han encontrado resultados";
		$pdf ->Cell(0,20,utf8_decode($idiomas[$_SESSION['opcion_idioma']]['general122'].' SMS...........................'.$numero_sms),0,1,'C');
		$pdf ->SetLeftMargin(10);
		//$img = file_get_contents("images/sin_datos.jpg");
		//echo $img;
	}
	$pdf->Output($idiomas[$_SESSION['opcion_idioma']]['general124'].'_SMS_'.$cliente_nombre,'I');
}
else if ($tipo_informe=="CSV")
{
	$datos = "ID ".$idiomas[$_SESSION['opcion_idioma']]['general1'].";".$idiomas[$_SESSION['opcion_idioma']]['general1'].";".$idiomas[$_SESSION['opcion_idioma']]['general7'].";ID ".$idiomas[$_SESSION['opcion_idioma']]['general7'].";".$idiomas[$_SESSION['opcion_idioma']]['general31'].";".$idiomas[$_SESSION['opcion_idioma']]['general123'].";".$idiomas[$_SESSION['opcion_idioma']]['general8'].";\r\n";
	
	if ($result)
	{
		while ($row = mysql_fetch_array($result))
		{
			if ($cliente != 0)
			{
				if ($cliente_nombre == "")
				{
					$datos .= " ".$cliente."; ".$idiomas[$_SESSION['opcion_idioma']]['general1']." ".$cliente."; ";
				}
				else
				{
					$datos .= " ".$cliente."; ".$cliente_nombre."; ";
				}
			}
			else
			{
				$datos .= " ".$row["cliente_id"]."; ".$row["cliente_nombre"]."; ";
			}
			if ($instalacion != 0)
			{
				if ($instalacion_nombre == "")
				{
					$datos .= " ".$idiomas[$_SESSION['opcion_idioma']]['general7']." ".$row["instalacion_id"].";".$instalacion.";";
				}
				else
				{
					$datos .= $instalacion_nombre."; ".$instalacion.";";	
				}
			}
			else
			{
				$datos .= $row["instalacion_nombre"]."; ".$row['instalacion_id'].";";
			}
			$datos .= $row['evento_texto']."; ".$row['sms_destino'].";".$row['sms_fecha_out'].";\r\n";
		}
		header('Content-Type: application/x-octet-stream');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Last-Modified: '.date('D, d M Y H:i:s'));
		header('Content-Disposition: attachment; filename="'.$idiomas[$_SESSION['opcion_idioma']]['general124'].'_SMS_'.$cliente_nombre.'_.csv"');
		header("Content-Length: ".strlen($datos));
		echo utf8_decode($datos);
	}
	else
	{
		$datos ='';
	}
}
else
{
	echo '<script>alert("'.$idiomas[$_SESSION['opcion_idioma']]['general116'].'");</script>';
}

mysql_close($link);
?>
