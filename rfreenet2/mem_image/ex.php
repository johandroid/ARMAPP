<?php
require('mem_image.php');

$pdf=new MEM_IMAGE();
$pdf->AddPage();

//Create a GD graphic
$im=imagecreate(200, 150);
$bgcolor=imagecolorallocate($im, 255, 255, 255);
$bordercolor=imagecolorallocate($im, 0, 0, 0);
$color1=imagecolorallocate($im, 255, 0, 0);
$color2=imagecolorallocate($im, 0, 255, 0);
$color3=imagecolorallocate($im, 0, 0, 255);
imagefilledrectangle($im, 0, 0, 199, 149, $bgcolor);
imagerectangle($im, 0, 0, 199, 149, $bordercolor);
imagefilledrectangle($im, 30, 100, 60, 148, $color1);
imagefilledrectangle($im, 80, 80, 110, 148, $color2);
imagefilledrectangle($im, 130, 40, 160, 148, $color3);
//Output it
$pdf->GDImage($im, 50, 25, 40);
imagedestroy($im);

//Load an image in a global variable
$logo=file_get_contents('logo.jpg');
//Output it (requires PHP>=4.3.2 and FPDF>=1.52)
$pdf->Image('var://logo', 120, 28, 0, 0, 'JPEG');

$pdf->Output();
?>
