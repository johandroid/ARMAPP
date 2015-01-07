<?php
session_start();
ini_set('memory_limit','500M');
ini_set('max_execution_time','300');
require_once('FirePHPCore/FirePHP.class.php'); 
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
include 'inc/idiomas.inc';

//set_time_limit(300);

$saEjeY1 = Array();
$saEjeY2 = Array();
$saEjeY1Aux = Array();
$saEjeY2Aux = Array();
$saEjeXFechas = Array();
$saEjeXHoras = Array();
$sNumDivsX = 0;
$sNumDivsY1 = 0;
$sNumDivsY2 = 0;

$saEjeTopX = Array();
$saEjeTopY1 = Array();
$saEjeTopY1Aux = Array();
$saEjeTopY2 = Array();
$saEjeTopY2Aux = Array();
$saEjeLeftX = Array();
$saEjeRightY1 = Array();
$saEjeRightY1Aux = Array();
$saEjeRightY2 = Array();
$saEjeRightY2Aux = Array();
$saEjeWidthX = Array();
$saEjeWidthY1 = Array();
$saEjeWidthY1Aux = Array();
$saEjeWidthY2 = Array();
$saEjeWidthY2Aux = Array();

$saColores = Array();
$saCurvas = Array();
$sNumCurvas = 0;

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF 
{
	function Header()
	{
		include 'inc/idiomas.inc';
	 	$this->Image('images/balmart.jpg',35,8,20,20);
		$this->SetFont('helvetica','',18);
		$this->Cell(0,6,'RFreeNET Green',0,1,'C');
		$this->Image('images/logo_green.jpg',165,8,20,20);
	}
	function Footer()
	{
		include 'inc/idiomas.inc';
		//Go to 1.5 cm from bottom
		$this->SetY(-15);
		//Select Arial italic 8
		$this->SetFont('helvetica','I',8);
		//Print centered page number
		$this->Cell(0,10,$idiomas[$_SESSION['opcion_idioma']]['general00'],0,0,'C');
		$this->Cell(-190,20,$idiomas[$_SESSION['opcion_idioma']]['general126'].' '.$this->PageNo(),0,0,'C');
	}
}

ob_start();
$mifirePHP = FirePHP::getInstance(true); 
//$mifirePHP->log('Creando LOG');

$grafica1 = $_POST["imagen1"];
$grafica1_text = $_POST["imagen1_div"];
$grafica1_title = $_POST["imagen1_title"];
//$mifirePHP->log('grafica1: '.$grafica1);
//echo $grafica1;
$grafica2 = $_POST["imagen2"];
$grafica2_text = $_POST["imagen2_div"];
$grafica2_title = $_POST["imagen2_title"];
$grafica3 = $_POST["imagen3"];
$grafica3_text = $_POST["imagen3_div"];
$grafica3_title = $_POST["imagen3_title"];
$grafica4 = $_POST["imagen4"];
$grafica4_text = $_POST["imagen4_div"];
$grafica4_title = $_POST["imagen4_title"];

// Remove the headers part (data:,) 
//$mifirePHP->log('Grafica 1:'.$grafica1);
if ($grafica1)
{
	$imagen1=base64_decode(substr($grafica1, strpos($grafica1, ",")+1));
	$im1 = imagecreatefromstring($imagen1);
}
//$mifirePHP->log('Grafica 2:'.$grafica2);
if ($grafica2)
{
	$imagen2=base64_decode(substr($grafica2, strpos($grafica2, ",")+1));
	$im2 = imagecreatefromstring($imagen2);
}
//$mifirePHP->log('Grafica 3:'.$grafica3);
if ($grafica3)
{
	$imagen3=base64_decode(substr($grafica3, strpos($grafica3, ",")+1));
	$im3 = imagecreatefromstring($imagen3);
}
//$mifirePHP->log('Grafica 4:'.$grafica4);
if ($grafica4)
{
	$imagen4=base64_decode(substr($grafica4, strpos($grafica4, ",")+1));
	$im4 = imagecreatefromstring($imagen4);
}

// Convertimos los tags html a minúscula
$grafica1_text=str_replace("div>","DIV>",$grafica1_text);
$grafica2_text=str_replace("div>","DIV>",$grafica2_text);
$grafica3_text=str_replace("div>","DIV>",$grafica3_text);
$grafica4_text=str_replace("div>","DIV>",$grafica4_text);
$grafica1_text=str_replace("<div","<DIV",$grafica1_text);
$grafica2_text=str_replace("<div","<DIV",$grafica2_text);
$grafica3_text=str_replace("<div","<DIV",$grafica3_text);
$grafica4_text=str_replace("<div","<DIV",$grafica4_text);

$grafica1_text=str_replace("<tr","<TR",$grafica1_text);
$grafica2_text=str_replace("<tr","<TR",$grafica2_text);
$grafica3_text=str_replace("<tr","<TR",$grafica3_text);
$grafica4_text=str_replace("<tr","<TR",$grafica4_text);
$grafica1_text=str_replace("tr>","TR>",$grafica1_text);
$grafica2_text=str_replace("tr>","TR>",$grafica2_text);
$grafica3_text=str_replace("tr>","TR>",$grafica3_text);
$grafica4_text=str_replace("tr>","TR>",$grafica4_text);

$grafica1_text=str_replace("<td","<TD",$grafica1_text);
$grafica2_text=str_replace("<td","<TD",$grafica2_text);
$grafica3_text=str_replace("<td","<TD",$grafica3_text);
$grafica4_text=str_replace("<td","<TD",$grafica4_text);
$grafica1_text=str_replace("td>","TD>",$grafica1_text);
$grafica2_text=str_replace("td>","TD>",$grafica2_text);
$grafica3_text=str_replace("td>","TD>",$grafica3_text);
$grafica4_text=str_replace("td>","TD>",$grafica4_text);

$grafica1_text=str_replace("tbody>","TBODY>",$grafica1_text);
$grafica2_text=str_replace("tbody>","TBODY>",$grafica2_text);
$grafica3_text=str_replace("tbody>","TBODY>",$grafica3_text);
$grafica4_text=str_replace("tbody>","TBODY>",$grafica4_text);

$grafica1_text=str_replace("<table","<TABLE",$grafica1_text);
$grafica2_text=str_replace("<table","<TABLE",$grafica2_text);
$grafica3_text=str_replace("<table","<TABLE",$grafica3_text);
$grafica4_text=str_replace("<table","<TABLE",$grafica4_text);
$grafica1_text=str_replace("table>","TABLE>",$grafica1_text);
$grafica2_text=str_replace("table>","TABLE>",$grafica2_text);
$grafica3_text=str_replace("table>","TABLE>",$grafica3_text);
$grafica4_text=str_replace("table>","TABLE>",$grafica4_text);

$grafica1_text=str_replace("width:","WIDTH:",$grafica1_text);
$grafica2_text=str_replace("width:","WIDTH:",$grafica2_text);
$grafica3_text=str_replace("width:","WIDTH:",$grafica3_text);
$grafica4_text=str_replace("width:","WIDTH:",$grafica4_text);
$grafica1_text=str_replace("right:","RIGHT:",$grafica1_text);
$grafica2_text=str_replace("right:","RIGHT:",$grafica2_text);
$grafica3_text=str_replace("right:","RIGHT:",$grafica3_text);
$grafica4_text=str_replace("right:","RIGHT:",$grafica4_text);
$grafica1_text=str_replace("top:","TOP:",$grafica1_text);
$grafica2_text=str_replace("top:","TOP:",$grafica2_text);
$grafica3_text=str_replace("top:","TOP:",$grafica3_text);
$grafica4_text=str_replace("top:","TOP:",$grafica4_text);
$grafica1_text=str_replace("left:","LEFT:",$grafica1_text);
$grafica2_text=str_replace("left:","LEFT:",$grafica2_text);
$grafica3_text=str_replace("left:","LEFT:",$grafica3_text);
$grafica4_text=str_replace("left:","LEFT:",$grafica4_text);

// Eliminamos los canvas del html
$sCadenaReplace=substr($grafica1_text, 0, strpos($grafica1_text,"<DIV"));
$grafica1_div=str_replace($sCadenaReplace,"",$grafica1_text);
$sCadenaReplace=substr($grafica2_text, 0, strpos($grafica2_text,"<DIV"));
$grafica2_div=str_replace($sCadenaReplace,"",$grafica2_text);
$sCadenaReplace=substr($grafica3_text, 0, strpos($grafica3_text,"<DIV"));
$grafica3_div=str_replace($sCadenaReplace,"",$grafica3_text);
$sCadenaReplace=substr($grafica4_text, 0, strpos($grafica4_text,"<DIV"));
$grafica4_div=str_replace($sCadenaReplace,"",$grafica4_text);

//TCPDF
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Carmelo Garcia');
$pdf->SetTitle('RFreeNET Charts 2011');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

$pdf->AddPage();
$pdf->SetFont('times', 'B', 20);
$pdf->Cell(0,60,'',0,1,'C');
$pdf->Cell(0,20,$idiomas[$_SESSION['opcion_idioma']]['grafica_text1'],0,1,'C');
$pdf->SetFont('times','B',16);
$pdf->Cell(0,20,$idiomas[$_SESSION['opcion_idioma']]['grafica_text2'],0,1,'C');

//$pdf->AddPage();
//$pdf->SetFont('helvetica','N',9);
//$pdf->Write(0, $grafica1_text, '', 0, 'J', true, 0, false, true, 0);
//$pdf->AddPage();
//$pdf->SetFont('helvetica','N',9);
//$pdf->Write(0, $grafica1_div, '', 0, 'J', true, 0, false, true, 0);

// -------------------------------------------------------------------
//			BUCLE DE GENERACIÓN DE GRÁFICAS
//-------------------------------------------------------------------

for ($iNumGraf = 0; $iNumGraf<4;$iNumGraf++)
{
	$sNumDivsX = 0;
	$sNumDivsY1 = 0;
	$sNumDivsY2 = 0;
	$sNumCurvas = 0;

	//$mifirePHP->log('Grafica '.$grafica4.' START');
	switch ($iNumGraf)
	{		
		case 1:
			$grafica_div = $grafica2_div;
			$grafica = $grafica2;
			$grafica_title = $grafica2_title;
			$imagen_draw = $imagen2;
			break;
		case 2:
			$grafica_div = $grafica3_div;
			$grafica = $grafica3;
			$grafica_title = $grafica3_title;
			$imagen_draw = $imagen3;
			break;
		case 3:
			$grafica_div = $grafica4_div;
			$grafica = $grafica4;
			$grafica_title = $grafica4_title;
			$imagen_draw = $imagen4;
			break;		
		case 0:
		default:
			$grafica_div = $grafica1_div;
			$grafica = $grafica1;
			$grafica_title = $grafica1_title;
			$imagen_draw = $imagen1;
			break;
	}	
	
	if ($grafica)
	{
		//$mifirePHP->log('Grafica '.$iNumGraf.' DRAW');
		//$mifirePHP->log('DIV '.$grafica_div);
		//$mifirePHP->log('TITLE '.$grafica_title);
		//$mifirePHP->log('CONTENT '.$grafica);
		// Extraemos las componentes del eje X1 para montar la tabla HTML
		//$pdf->AddPage();
		$sCadenaTemp=substr($grafica_div, 0, strpos($grafica_div,"xAxis"));
		if ($sCadenaTemp)
		{
			$sCadenaDiv=str_replace($sCadenaTemp,"",$grafica_div);
			//$mifirePHP->log('Paso a: '.$sCadenaTemp);
			$sCadenaTemp=substr($sCadenaDiv, 0, strpos($sCadenaDiv,"<DIV"));
			$sCadenaDiv=str_replace($sCadenaTemp,"",$sCadenaDiv);
			//$mifirePHP->log('Paso b: '.$sCadenaTemp);
			// Ahora extraemos todas las componentes del eje y las almacenamos
			$sCadenaEjeX1=substr($sCadenaDiv, 0, strpos($sCadenaDiv,"</DIV></DIV>")+12);
			$sCadenaDiv = str_replace($sCadenaEjeX1,"",$sCadenaDiv);
			//$mifirePHP->log('Eje X: '.$sCadenaEjeX1);
			//$mifirePHP->log('Resto: '.$sCadenaDiv);
			$sNumDivsX = 0;
			$sContinuar = 1;
			while ($sContinuar == 1)
			{	
				if (strpos($sCadenaEjeX1,"/DIV>"))
				{
					$sCadenaLinea=substr($sCadenaEjeX1, strpos($sCadenaEjeX1,"<DIV"), strpos($sCadenaEjeX1,"/DIV>")+5);
					if ((!$sCadenaLinea) || (strcmp($sCadenaLinea, '</DIV>') == 0)) 
					{
						//$mifirePHP->log('FIN EJE X');
						break;
					}
					//$pdf->Write(0, 'X-LINE '.$sNumDivsX.' = '.$sCadenaLinea, '', 0, 'J', true, 0, false, true, 0);
					//$mifirePHP->log('Linea X-'.$sNumDivsX.': '.$sCadenaLinea);
					$sCadenaEjeX1=str_replace($sCadenaLinea,"",$sCadenaEjeX1);
					//Extraemos componentes de eje X (fecha y hora)
					$sCadenaTexto=substr($sCadenaLinea, strpos($sCadenaLinea,">")+1, strpos($sCadenaLinea,"/DIV>")-strpos($sCadenaLinea,">")-2);
					//$mifirePHP->log('Paso '.$sNumDivsX.': '.$sCadenaTexto);
					//$mifirePHP->log('Cadena de long '.(strpos($sCadenaEjeX1,"/DIV>")-strpos($sCadenaEjeX1,">")+1));
					//$pdf->Write(0, 'Cadena '.$sNumDivsX.' = '.$sCadenaTexto, '', 0, 'J', true, 0, false, true, 0);
					list($saEjeXFechas[$sNumDivsX], $saEjeXHoras[$sNumDivsX])=explode(" ",$sCadenaTexto);
					// Extraemos dimensiones de celdas
					$saEjeWidthX[$sNumDivsX]=substr($sCadenaLinea, strpos($sCadenaLinea,"WIDTH")+6, strpos($sCadenaLinea,"px",strpos($sCadenaLinea,"WIDTH"))-strpos($sCadenaLinea,"WIDTH")-6);
					//$pdf->Write(0, 'X-WIDTH '.$sNumDivsX.' = '.$saEjeWidthX[$sNumDivsX], '', 0, 'J', true, 0, false, true, 0);
					//$mifirePHP->log('Width '.$sNumDivsX.' = '.$saEjeWidthX[$sNumDivsX]);
					$saEjeTopX[$sNumDivsX]=substr($sCadenaLinea, strpos($sCadenaLinea,"TOP")+4, strpos($sCadenaLinea,"px",strpos($sCadenaLinea,"TOP"))-strpos($sCadenaLinea,"TOP")-4);
					//$pdf->Write(0, 'X-TOP '.$sNumDivsX.' = '.$saEjeTopX[$sNumDivsX], '', 0, 'J', true, 0, false, true, 0);
					//$mifirePHP->log('Top '.$sNumDivsX.' = '.$saEjeTopX[$sNumDivsX]);
					$saEjeLeftX[$sNumDivsX]=substr($sCadenaLinea, strpos($sCadenaLinea,"LEFT")+5, strpos($sCadenaLinea,"px",strpos($sCadenaLinea,"LEFT"))-strpos($sCadenaLinea,"LEFT")-5);
					//$pdf->Write(0, 'LEFT '.$sNumDivsX.' = '.$saEjeLeftX[$sNumDivsX], '', 0, 'J', true, 0, false, true, 0);
					//$mifirePHP->log('Left '.$sNumDivsX.' = '.$saEjeLeftX[$sNumDivsX]);
					$sNumDivsX++;
					//$mifirePHP->log('Resto: '.$sCadenaEjeX1);
				}
				else
				{
					$sContinuar = 0;
				}
			}
		}
		//else
		//{
		//	$mifirePHP->log('NO HAY EJE X');
		//}
		
		// Extraemos las componentes del eje Y1 para montar la tabla HTML
		//$pdf->AddPage();
		$sCadenaTemp=substr($grafica_div, 0, strpos($grafica_div,"y1Axis"));
		if ($sCadenaTemp)
		{
			$sCadenaDiv=str_replace($sCadenaTemp,"",$grafica_div);
			//$mifirePHP->log('Paso a: '.$sCadenaTemp);
			$sCadenaTemp=substr($sCadenaDiv, 0, strpos($sCadenaDiv,"<DIV"));
			$sCadenaDiv=str_replace($sCadenaTemp,"",$sCadenaDiv);
			//$mifirePHP->log('Paso b: '.$sCadenaTemp);
			// Ahora extraemos todas las componentes del eje y las almacenamos
			$sCadenaEjeY1=substr($sCadenaDiv, 0, strpos($sCadenaDiv,"</DIV></DIV>")+12);
			$sCadenaDiv = str_replace($sCadenaEjeY1,"",$sCadenaDiv);
			//$mifirePHP->log('Eje Y1: '.$sCadenaEjeY1);
			//$mifirePHP->log('Resto: '.$sCadenaDiv);
			$sNumDivsY1 = 0;
			$sContinuar = 1;
			while ($sContinuar == 1)
			{
				if (strpos($sCadenaEjeY1,"/DIV>"))
				{
					$sCadenaLinea=substr($sCadenaEjeY1, strpos($sCadenaEjeY1,"<DIV"), strpos($sCadenaEjeY1,"/DIV>")+5);
					if ((!$sCadenaLinea) || (strcmp($sCadenaLinea, '</DIV>') == 0))
					{
						//$mifirePHP->log('FIN EJE Y1');
						break;
					}
					//$pdf->Write(0, 'Y1-LINE '.$sNumDivsX.' = '.$sCadenaLinea, '', 0, 'J', true, 0, false, true, 0);
					//$mifirePHP->log('Linea Y1-'.$sNumDivsY1.': '.$sCadenaLinea);
					$sCadenaEjeY1=str_replace($sCadenaLinea,"",$sCadenaEjeY1);
					//Extraemos componentes de eje Y1 (fecha y hora)
					$sCadenaTexto=substr($sCadenaLinea, strpos($sCadenaLinea,">")+1, strpos($sCadenaLinea,"/DIV>")-strpos($sCadenaLinea,">")-2);
					//$mifirePHP->log('Paso '.$sNumDivsY1.': '.$sCadenaTexto);
					//$mifirePHP->log('Cadena de long '.(strpos($sCadenaEjeY1,"/DIV>")-strpos($sCadenaEjeY1,">")+1));
					//$pdf->Write(0, 'Cadena '.$sNumDivsY1.' = '.$sCadenaTexto, '', 0, 'J', true, 0, false, true, 0);
					$saEjeY1Aux[$sNumDivsY1] = $sCadenaTexto;
					// Extraemos dimensiones de celdas
					$saEjeWidthY1Aux[$sNumDivsY1]=substr($sCadenaLinea, strpos($sCadenaLinea,"WIDTH")+6, strpos($sCadenaLinea,"px",strpos($sCadenaLinea,"WIDTH"))-strpos($sCadenaLinea,"WIDTH")-6);
					//$pdf->Write(0, 'Y1-WIDTH '.$sNumDivsY1.' = '.$saEjeWidthY1Aux[$sNumDivsY1], '', 0, 'J', true, 0, false, true, 0);
					//$mifirePHP->log('Width '.$sNumDivsY1.' = '.$saEjeWidthY1Aux[$sNumDivsY1]);
					$saEjeRightY1Aux[$sNumDivsY1]=substr($sCadenaLinea, strpos($sCadenaLinea,"RIGHT:")+6, strpos($sCadenaLinea,"px",strpos($sCadenaLinea,"RIGHT:"))-strpos($sCadenaLinea,"RIGHT:")-6);
					//$pdf->Write(0, 'Y1-RIGHT '.$sNumDivsY1.' = '.$saEjeRightY1Aux[$sNumDivsY1], '', 0, 'J', true, 0, false, true, 0);
					//$mifirePHP->log('Right '.$sNumDivsY1.' = '.$saEjeRightY1Aux[$sNumDivsY1]);
					$saEjeTopY1Aux[$sNumDivsY1]=substr($sCadenaLinea, strpos($sCadenaLinea,"TOP")+4, strpos($sCadenaLinea,"px",strpos($sCadenaLinea,"TOP"))-strpos($sCadenaLinea,"TOP")-4);
					//$pdf->Write(0, 'Y1-TOP '.$sNumDivsY1.' = '.$saEjeTopY1Aux[$sNumDivsY1], '', 0, 'J', true, 0, false, true, 0);
					//$mifirePHP->log('Top '.$sNumDivsY1.' = '.$saEjeTopY1Aux[$sNumDivsY1]);
					$sNumDivsY1++;
					//$mifirePHP->log('Resto: '.$sCadenaEjeY1);
				}
				else
				{
					$sContinuar = 0;
				}
			}
			// Y le damos la vuelta al vector
			for($i=0;$i<$sNumDivsY1;$i++)
			{
				$saEjeY1[$i] = $saEjeY1Aux[$sNumDivsY1-$i-1];
				$saEjeWidthY1[$i] = $saEjeWidthY1Aux[$sNumDivsY1-$i-1];
				$saEjeRightY1[$i] = $saEjeRightY1Aux[$sNumDivsY1-$i-1];
				$saEjeTopY1[$i] = $saEjeTopY1Aux[$sNumDivsY1-$i-1];
			}
		}
		//else
		//{
		//	$mifirePHP->log('NO HAY EJE Y1');
		//}
		
		// Extraemos las componentes del eje Y2 para montar la tabla HTML
		//$pdf->AddPage();
		$sCadenaTemp=substr($grafica_div, 0, strpos($grafica_div,"y2Axis"));
		if ($sCadenaTemp)
		{
			$sCadenaDiv=str_replace($sCadenaTemp,"",$grafica_div);
			//$mifirePHP->log('Paso a: '.$sCadenaTemp);
			$sCadenaTemp=substr($sCadenaDiv, 0, strpos($sCadenaDiv,"<DIV"));
			$sCadenaDiv=str_replace($sCadenaTemp,"",$sCadenaDiv);
			//$mifirePHP->log('Paso b: '.$sCadenaTemp);
			// Ahora extraemos todas las componentes del eje y las almacenamos
			$sCadenaEjeY2=substr($sCadenaDiv, 0, strpos($sCadenaDiv,"</DIV></DIV>")+12);
			$sCadenaDiv = str_replace($sCadenaEjeY2,"",$sCadenaDiv);
			//$mifirePHP->log('Eje Y2: '.$sCadenaEjeY2);
			//$mifirePHP->log('Resto: '.$sCadenaDiv);
			$sNumDivsY2 = 0;
			$sContinuar = 1;
			while ($sContinuar == 1)
			{	
				if (strpos($sCadenaEjeY2,"/DIV>"))
				{
					$sCadenaLinea=substr($sCadenaEjeY2, strpos($sCadenaEjeY2,"<DIV"), strpos($sCadenaEjeY2,"/DIV>")+5);
					if ((!$sCadenaLinea) || (strcmp($sCadenaLinea, '</DIV>') == 0)) 
					{
						//$mifirePHP->log('FIN EJE Y2');
						break;
					}
					//$pdf->Write(0, 'Y2-LINE '.$sNumDivsX.' = '.$sCadenaLinea, '', 0, 'J', true, 0, false, true, 0);
					//$mifirePHP->log('Linea '.$sNumDivsY2.': '.$sCadenaLinea);
					$sCadenaEjeY2=str_replace($sCadenaLinea,"",$sCadenaEjeY2);
					//Extraemos componentes de eje Y2 (fecha y hora)
					$sCadenaTexto=substr($sCadenaLinea, strpos($sCadenaLinea,">")+1, strpos($sCadenaLinea,"/DIV>")-strpos($sCadenaLinea,">")-2);
					//$mifirePHP->log('Paso '.$sNumDivsY2.': '.$sCadenaTexto);
					//$mifirePHP->log('Cadena de long '.(strpos($sCadenaEjeY2,"/DIV>")-strpos($sCadenaEjeY2,">")+1));
					//$pdf->Write(0, 'Cadena '.$sNumDivsY2.' = '.$sCadenaTexto, '', 0, 'J', true, 0, false, true, 0);
					$saEjeY2Aux[$sNumDivsY2] = $sCadenaTexto;
					// Extraemos dimensiones de celdas
					$saEjeWidthY2Aux[$sNumDivsY2]=substr($sCadenaLinea, strpos($sCadenaLinea,"WIDTH")+6, strpos($sCadenaLinea,"px",strpos($sCadenaLinea,"WIDTH"))-strpos($sCadenaLinea,"WIDTH")-6);
					//$pdf->Write(0, 'Y2-WIDTH '.$sNumDivsY2.' = '.$saEjeWidthY2[$sNumDivsY2], '', 0, 'J', true, 0, false, true, 0);
					//$mifirePHP->log('Width '.$sNumDivsY2.' = '.$saEjeWidthY2[$sNumDivsY2]);
					$saEjeRightY2Aux[$sNumDivsY2]=substr($sCadenaLinea, strpos($sCadenaLinea,"RIGHT:")+6, strpos($sCadenaLinea,"px",strpos($sCadenaLinea,"RIGHT:"))-strpos($sCadenaLinea,"RIGHT:")-6);
					//$pdf->Write(0, 'Y2-RIGHT '.$sNumDivsY2.' = '.$saEjeRightY2Aux[$sNumDivsY2], '', 0, 'J', true, 0, false, true, 0);
					//$mifirePHP->log('Right '.$sNumDivsY2.' = '.$saEjeRightY2Aux[$sNumDivsY2]);
					$saEjeTopY2Aux[$sNumDivsY2]=substr($sCadenaLinea, strpos($sCadenaLinea,"TOP")+4, strpos($sCadenaLinea,"px",strpos($sCadenaLinea,"TOP"))-strpos($sCadenaLinea,"TOP")-4);
					//$pdf->Write(0, 'Y2-TOP '.$sNumDivsY2.' = '.$saEjeTopY2Aux[$sNumDivsY2], '', 0, 'J', true, 0, false, true, 0);
					//$mifirePHP->log('Top '.$sNumDivsY2.' = '.$saEjeTopY2Aux[$sNumDivsY2]);
					$sNumDivsY2++;
					//$mifirePHP->log('Resto: '.$sCadenaEjeY2);
				}
				else
				{
					$sContinuar = 0;
				}
			}
			
			// Y le damos la vuelta al vector
			for($i=0;$i<$sNumDivsY2;$i++)
			{
				$saEjeY2[$i] = $saEjeY2Aux[$sNumDivsY2-$i-1];
				$saEjeWidthY2[$i] = $saEjeWidthY2Aux[$sNumDivsY2-$i-1];
				$saEjeRightY2[$i] = $saEjeRightY2Aux[$sNumDivsY2-$i-1];
				$saEjeTopY2[$i] = $saEjeTopY2Aux[$sNumDivsY2-$i-1];
			}
		}
		//else
		//{
		//	$mifirePHP->log('NO HAY EJE Y2');
		//}
		
		// Y finalmente extraemos la leyenda
		//$pdf->AddPage();
		//$pdf->SetFont('helvetica','N',9);
		//$pdf->Write(0, 'DIV = '.$grafica_div, '', 0, 'J', true, 0, false, true, 0);
		$sCadenaTemp=substr($grafica_div, 0, strpos($grafica_div,"<DIV",strpos($grafica_div,"legend")));
		if ($sCadenaTemp)
		{
			$sCadenaDiv=str_replace($sCadenaTemp,"",$grafica_div);
			//$pdf->Write(0, 'REPLACE = '.$sCadenaDiv, '', 0, 'J', true, 0, false, true, 0);
			//$mifirePHP->log('Paso a: '.$sCadenaTemp);
			$sCadenaLeyenda=substr($sCadenaDiv, strpos($sCadenaDiv,"<TABLE"), strpos($sCadenaDiv,"</TABLE>")+8-strpos($sCadenaDiv,"<TABLE"));
			//$pdf->Write(0, 'TABLA = '.$sCadenaLeyenda, '', 0, 'J', true, 0, false, true, 0);
			$sCadenaDiv=str_replace($sCadenaLeyenda,"",$sCadenaDiv);
			//$pdf->Write(0, 'QUEDA = '.$sCadenaDiv, '', 0, 'J', true, 0, false, true, 0);
			//$mifirePHP->log('Legend: '.$sCadenaLeyenda);
			//$mifirePHP->log('Resto: '.$sCadenaDiv);
		}
		//else
		//{
		//	$mifirePHP->log('NO HAY LEYENDA');
		//}
		
		// De la leyenda, extraemos nombres y colores
		//$pdf->AddPage();
		//$pdf->SetFont('helvetica','N',9);
		//$mifirePHP->log('Extrayendo de: '.$sCadenaLeyenda);
		$sNumCurvas = 0;
		$sContinuar = 1;
		$sCadenaTemp = $sCadenaLeyenda;
		while ($sContinuar == 1)
		{	
			if (strpos($sCadenaTemp,"/TD>"))
			{
				//$pdf->Write(0, 'INIT '.$sNumCurvas.' = '.$sCadenaTemp, '', 0, 'J', true, 0, false, true, 0);
				$sCadenaLinea=substr($sCadenaTemp, strpos($sCadenaTemp,"<TR"), strpos($sCadenaTemp,"/TR>") - strpos($sCadenaTemp,"<TR")+4);	
				if ((!$sCadenaLinea) || (strcmp($sCadenaLinea,'<TAB') == 0)) 
				{
					//$mifirePHP->log('FIN LEYENDA');
					break;
				}
				$sCadenaLineaTemp = $sCadenaLinea;
				//$mifirePHP->log('Linea '.$sNumCurvas.': '.$sCadenaLineaTemp);
				//$pdf->Write(0, 'FILA '.$sNumCurvas.' = '.$sCadenaLineaTemp, '', 0, 'J', true, 0, false, true, 0);
				// Extraigo la celda del color
				$sCadenaTexto=substr($sCadenaLineaTemp, strpos($sCadenaLineaTemp,"<TBODY>")+4, strpos($sCadenaLineaTemp,"</TD>")-strpos($sCadenaLineaTemp,"<TBODY>")+1);
				//$pdf->Write(0, 'CELDA COLOR '.$sNumCurvas.' = '.$sCadenaTexto, '', 0, 'J', true, 0, false, true, 0);
				//$mifirePHP->log('Color '.$sNumCurvas.': '.$sCadenaTexto);
				// Guardo la cadena de color
				$saColores[$sNumCurvas]=substr($sCadenaTexto, strpos($sCadenaTexto,"rgb",strpos($sCadenaTexto,"5px")), strpos($sCadenaTexto,")",strpos($sCadenaTexto,"rgb",strpos($sCadenaTexto,"5px")))-strpos($sCadenaTexto,"rgb",strpos($sCadenaTexto,"5px"))+1);
				//$pdf->Write(0, 'COLOR '.$sNumCurvas.' = '.$saColores[$sNumCurvas], '', 0, 'J', true, 0, false, true, 0);
				//$mifirePHP->log('Color '.$sNumCurvas.': '.$saColores[$sNumCurvas]);
				// Y elimino la celda de la linea
				$sCadenaLineaTemp=str_replace($sCadenaTexto,"",$sCadenaLineaTemp);			
				//$mifirePHP->log('Resto Linea: '.$sCadenaLineaTemp);
				
				// Extraigo la celda del titulo
				$sCadenaTexto=substr($sCadenaLineaTemp, strpos($sCadenaLineaTemp,"<TBODY>")+4, strpos($sCadenaLineaTemp,"</TD>")-strpos($sCadenaLineaTemp,"<TBODY>")+1);
				//$mifirePHP->log('Texto Celda'.$sNumCurvas.': '.$sCadenaTexto);
				//$pdf->Write(0, 'CELDA NOMBRE '.$sNumCurvas.' = '.$sCadenaTexto, '', 0, 'J', true, 0, false, true, 0);
				// Guardo la cadena de color
				//$pdf->Write(0, '> en '.strpos($sCadenaTexto,">").'  y </td> en '.strpos($sCadenaTexto,"</TD>"), '', 0, 'J', true, 0, false, true, 0);
				$saCurvas[$sNumCurvas]=substr($sCadenaTexto, strpos($sCadenaTexto,">")+1, strpos($sCadenaTexto,"</TD>")-strpos($sCadenaTexto,">")-1);
				//$pdf->Write(0, 'CURVA '.$sNumCurvas.' = '.$saCurvas[$sNumCurvas], '', 0, 'J', true, 0, false, true, 0);
				//$mifirePHP->log('Texto '.$sNumCurvas.': '.$saCurvas[$sNumCurvas]);
				
				// Elimino la linea del total de la leyenda
				$sCadenaTemp=str_replace($sCadenaLinea,"",$sCadenaTemp);
				$sNumCurvas++;
				//$mifirePHP->log('Resto Total: '.$sCadenaTemp);
				//$pdf->Write(0, 'RESTO '.$sNumCurvas.' = '.$sCadenaTemp, '', 0, 'J', true, 0, false, true, 0);
			}
			else
			{
				$sContinuar = 0;
			}
		}
		
		// Y le damos la vuelta al vector
		for($i=0;$i<$sNumDivsY2;$i++)
		{
			$saEjeY2[$i] = $saEjeY2Aux[$sNumDivsY2-$i-1];
		}
		
		//$mifirePHP->log('Title: '.$grafica_title);
		//$mifirePHP->log('X: '.$sNumDivsX);
		//$mifirePHP->log('Y1: '.$sNumDivsY1);
		//$mifirePHP->log('Y2: '.$sNumDivsY2);

		$iAnchoEjeY1 = 158;
		$iAnchoEjeY2 = 140;
		$iAnchoPrimeraCeldaX=$iAnchoEjeY1;
		$iAltoCelda = ($saEjeTopY1[1]-$saEjeTopY1[0])/1.42;
		//$mifirePHP->log('Alto Celda FINAL=> '.$saEjeTopY1[1].' - '.$saEjeTopY1[0].' = '.$iAltoCelda);
		$iAltoPrimeraFila=18;
		$iAltoUltimaFila=3;
		$iAnchoCeldaImagen=($saEjeLeftX[$sNumDivsX-1]-$saEjeLeftX[0]+($saEjeLeftX[1]-$saEjeLeftX[0]))/1.42;
		//$mifirePHP->log('Ancho Imagen=> '.$iAnchoCeldaImagen);
				
		$sTablaGraf = '<table cellspacing="0" cellpadding="0" border="0">';
		if ($sNumDivsY2 > 0)
		{
			$sTablaGraf .= '<tr><td align="right" width="'.$iAnchoEjeY1.'px" height="'.$iAltoPrimeraFila.'px"></td><td colspan="'.$sNumDivsX.'" align="center" height="'.$iAltoPrimeraFila.'px" width="'.$iAnchoCeldaImagen.'px">'.$grafica_title.'</td><td align="right" width="'.$iAnchoEjeY2.'px" height="'.$iAltoPrimeraFila.'px"></td></tr>';
		}
		else
		{
			$sTablaGraf .= '<tr><td align="right" width="'.$iAnchoEjeY1.'px" height="'.$iAltoPrimeraFila.'px"></td><td colspan="'.$sNumDivsX.'" align="center" height="'.$iAltoPrimeraFila.'px" width="'.$iAnchoCeldaImagen.'px">'.$grafica_title.'</td></tr>';
		}
		for($i=0;$i<$sNumDivsY1;$i++)
		{
			$sTablaGraf.='<tr>';
			if ($i < ($sNumDivsY1-1))
			{
				$sTablaGraf.='<td align="right" height="'.$iAltoCelda.'px">'.$saEjeY1[$i].'</td>';
			}
			else
			{
				$sTablaGraf.='<td align="right" width="'.$iAnchoEjeY1.'px" height="2mm"><br/>'.$saEjeY1[$i].'</td>';
			}
			if ($i == 0)
			{
				$sTablaGraf.='<td colspan="'.$sNumDivsX.'" rowspan="'.$sNumDivsY1.'" align="right"><br/></td>';	
			}
			if ($sNumDivsY2 > 0)
			{
				if ($i < ($sNumDivsY2-1))
				{
					$sTablaGraf.='<td align="left" width="'.$iAnchoEjeY2.'px" height="'.$iAltoCelda.'px">&nbsp;&nbsp;&nbsp;&nbsp;'.$saEjeY2[$i].'</td>';
				}
				else
				{
					$sTablaGraf.='<td align="left" width="'.$iAnchoEjeY2.'px" height="'.$iAltoUltimaFila.'px"><br/>&nbsp;&nbsp;&nbsp;&nbsp;'.$saEjeY2[$i].'</td>';
				}
			}
			$sTablaGraf.='</tr>';
		}

		$sTablaGraf.='<tr>';
		$sTablaGraf.='<td colspan="'.($sNumDivsX+2).'">';
		$sTablaGraf .= '<table width="100%" border="0">';
		$sTablaGraf.='<tr>';		
		
		$AnchoPrimeraCeldaXXX=$iAnchoPrimeraCeldaX+($saEjeLeftX[0]/1.42)-(($saEjeLeftX[1]-$saEjeLeftX[0])/(2*1.42));
		//$mifirePHP->log('Ancho Celda One '.$AnchoPrimeraCeldaXXX);
		$sTablaGraf.='<td width="'.$AnchoPrimeraCeldaXXX.'px"></td>';
		for ($i=0;$i<$sNumDivsX;$i++)
		{
			if ($i<($sNumDivsX-1))
			{
				$iAnchoCeldaX=($saEjeLeftX[$i+1]-$saEjeLeftX[$i])/1.42;
			}
			else
			{
				$iAnchoCeldaX=($saEjeLeftX[$i]-$saEjeLeftX[$i-1])/1.42;
			}
			$sTablaGraf.='<td align="center" width="'.$iAnchoCeldaX.'">'.$saEjeXFechas[$i].'</td>';
		}
		$sTablaGraf.='</tr>';
		$sTablaGraf.='<tr>';
		$sTablaGraf.='<td width="'.$AnchoPrimeraCeldaXXX.'px"></td>';
		for ($i=0;$i<$sNumDivsX;$i++)
		{			
			if ($i<($sNumDivsX-1))
			{
				$iAnchoCeldaX=($saEjeLeftX[$i+1]-$saEjeLeftX[$i])/1.42;
			}
			else
			{
				$iAnchoCeldaX=($saEjeLeftX[$i]-$saEjeLeftX[$i-1])/1.42;
			}
			$sTablaGraf.='<td align="center" width="'.$iAnchoCeldaX.'">'.$saEjeXHoras[$i].'</td>';
		}
		$sTablaGraf.='</tr>';
		$sTablaGraf .= '</table>';
		$sTablaGraf.='</td>';
		$sTablaGraf.='</tr>';
		$sTablaGraf .= '</table>';
	
		$pdf->AddPage();
		$pdf->Cell(0,10,'',0,1,'C');
		$pdf->setJPEGQuality(75);
		$pdf->Image('@'.$imagen_draw, 52, 42, '110mm', '70mm');
		
		$pdf->SetFont('helvetica','N',7);
		//$pdf->Write(0, $grafica_div, '', 0, 'J', true, 0, false, true, 0);
		//$pdf->writeHTML($grafica_div, true, 0, true, 0);
		$pdf->writeHTML($sTablaGraf, true, 0, true, 0);
		
		// Dibujamos el div de la leyenda
		$pdf->SetFont('helvetica','N',5);
		$leyenda_final='<table border="0" cellpadding="1" cellspacing="1"><tr>';
		$leyenda_final.='<td width="50mm"></td>';
		for ($i=0;$i<$sNumCurvas;$i++)
		{
			$leyenda_final.='<td width="12" align="center" style="background-color:'.$saColores[$i].';color:#777777;"></td>';
			$leyenda_final.='<td width="120" align="left">'.$saCurvas[$i].'</td>';
			$leyenda_final.='<td width="20"></td>';
			if (($i==1) && ($sNumCurvas > 2))
			{
				$leyenda_final.='</tr><tr><td colspan="7"></td></tr><tr><td width="50mm"></td>';		
			}
		}
		$leyenda_final.='</tr></table>';
		//$pdf->Write(0, $leyenda_final, '', 0, 'J', true, 0, false, true, 0);
		$pdf->writeHTML($leyenda_final, true, 0, true, 0);
		//$mifirePHP->log('Grafica '.$grafica4.' STOP');
		
		//$pdf->AddPage();
		//$pdf->Write(0, $sTablaGraf, '', 0, 'J', true, 0, false, true, 0);
	}
}

//$pdf->AddPage();
//$pdf->writeHTML($sCadenaLeyenda, true, 0, true, 0);

//Close and output PDF document
$pdf->Output('RFreeNET_Charts.pdf', 'D');
?>
