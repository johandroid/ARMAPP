function xGenerar_Datos_Graficas(i)
{
	var sSelect;
	var iPrimer;
	var sXMLOut='';
	var now = new Date();
	iPrimer = 0;
	sSelect = "#box"+(2*i)+"View option";
	if ($(sSelect).length > 0)
	{
		if (iPrimer != 1)
		{
			iPrimer = 1;
			sXMLOut = '&datosgraf=<xml>';
		}
		sXMLOut += '<graf>';
		for (var iI=0;iI<$(sSelect).length;iI++)
		{			
			sXMLOut += '<curve>';
			sXMLOut += '<data>'+$(sSelect)[iI].value.substring(0,19)+'</data>';
			sXMLOut += '<mag>'+$(sSelect)[iI].value.substring(19)+'</mag>';
			var sRadio = document.getElementsByName("graph"+(i)+"s"+(iI+1));
			sTipo = 0;
			for (var iRadio = 0; iRadio < sRadio.length; iRadio++)
			{
				if (sRadio[iRadio].checked)
				{
					sTipo=sRadio[iRadio].value;
				}
			}
			sXMLOut += '<tipo>'+sTipo+'</tipo>';
			sXMLOut += '</curve>';
		}
		sXMLOut += '</graf>';
	}
	if (sXMLOut.length > 0)
	{
		sXMLOut += '</xml>';
		sXMLOut+="&cliente_db="+top.document.getElementById("db_cliente").value+"&"+now.getTime();
		if((top.document.getElementById("Filtro_combo_Informe").selectedIndex == 0))
		{
			sXMLOut+="&fecha_begin="+top.document.getElementById('FechaInicial').value;
			sXMLOut+="&fecha_end="+top.document.getElementById('FechaFinal').value;
		}
		else
		{
			var timeout = top.document.getElementById('tiempoGrafica').value;
			var unidad = top.document.getElementById('selectTiempo').options[top.document.getElementById('selectTiempo').selectedIndex].id;
			switch (unidad)
			{
				case '0':
					timeout = timeout*60;
					break;
				case '1':
					timeout = timeout*60*60;
					break;
				case '2':
					timeout = timeout*24*60*60;
					break;
			}
			//var fecha = new Date();
			//sXMLOut+="&fecha_end="+tTimestamp2sDateTime(fecha);
			//fecha -= timeout;
			sXMLOut+="&fecha_end=0";
			sXMLOut+="&fecha_begin="+timeout;
			//sXMLOut+="&fecha_begin="+tTimestamp2sDateTime(fecha);
		}
		sXMLOut+="&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value;
	}
	return sXMLOut;
}
function xGenerar_Datos_Graficas_Zoom(i) //AMB 25/05/2102 Función específica para el zoom
{
	var sSelect;
	var iPrimer;
	var sXMLOut='';
	var now = new Date();
	iPrimer = 0;
	sSelect = "#box"+(2*i)+"View option";
	if ($(sSelect).length > 0)
	{
		if (iPrimer != 1)
		{
			iPrimer = 1;
			sXMLOut = '&datosgraf=<xml>';
		}
		sXMLOut += '<graf>';
		for (var iI=0;iI<$(sSelect).length;iI++)
		{			
			sXMLOut += '<curve>';
			sXMLOut += '<data>'+$(sSelect)[iI].value.substring(0,19)+'</data>';
			sXMLOut += '<mag>'+$(sSelect)[iI].value.substring(19)+'</mag>';
			var sRadio = document.getElementsByName("graph"+(i)+"s"+(iI+1));
			sTipo = 0;
			for (var iRadio = 0; iRadio < sRadio.length; iRadio++)
			{
				if (sRadio[iRadio].checked)
				{
					sTipo=sRadio[iRadio].value;
				}
			}
			sXMLOut += '<tipo>'+sTipo+'</tipo>';
			sXMLOut += '</curve>';
		}
		sXMLOut += '</graf>';
	}
	if (sXMLOut.length > 0)
	{
		sXMLOut += '</xml>';
		sXMLOut+="&cliente_db="+document.getElementById("db_cliente").value+"&"+now.getTime();
		if((document.getElementById("Filtro_combo_Informe").value == 0))
		{
			sXMLOut+="&fecha_begin="+document.getElementById('FechaInicial').value;
			sXMLOut+="&fecha_end="+document.getElementById('FechaFinal').value;
		}
		else
		{
			var timeout = document.getElementById('tiempoGrafica').value;
			var unidad = document.getElementById('selectTiempo').value;
			switch (unidad)
			{
				case '0':
					timeout = timeout*60000;
					break;
				case '1':
					timeout = timeout*60*60000;
					break;
				case '2':
					timeout = timeout*24*60*60000;
					break;
			}
			var fecha = new Date();
			sXMLOut+="&fecha_end="+tTimestamp2sDateTime(fecha);
			fecha -= timeout;
			
			sXMLOut+="&fecha_begin="+tTimestamp2sDateTime(fecha);
		}
		sXMLOut+="&instalacion_id="+document.getElementById("comboInstalaciones").value;
	}
	return sXMLOut;
}
function iComprobar_Grafica(iNumGrafica)
{
	if ($("#box"+(2*iNumGrafica)+"View option").length > 0)
	{
		return 0;
	}
	else
	{
		return 1;
	}
}
function iComprobar_Controles_Informe()
{
	var iCuenta = 0;

	for (var i=1;i<5;i++)
	{
		if (iComprobar_Grafica(i) == 0)
		//if ($("#box"+(2*i)+"View option").length > 0)
		{
			iCuenta++;
		}
	}
	if (iCuenta == 0)
	{
		alert(iObtener_Cadena_AJAX('error_graf1'));
		return 1;
	}
	if(iComprobar_Nombre(document.getElementById("titulo_g1").value) != 0)
	{
		alert(iObtener_Cadena_AJAX('error_graf2')+" 1 "+iObtener_Cadena_AJAX('error_graf3'));
		return 1;
	}
	if(iComprobar_Nombre(document.getElementById("titulo_g2").value) != 0)
	{
		alert(iObtener_Cadena_AJAX('error_graf2')+" 2 "+iObtener_Cadena_AJAX('error_graf3'));
		return 1;
	}
	if(iComprobar_Nombre(document.getElementById("titulo_g3").value) != 0)
	{
		alert(iObtener_Cadena_AJAX('error_graf2')+" 3 "+iObtener_Cadena_AJAX('error_graf3'));
		return 1;
	}
	if(iComprobar_Nombre(document.getElementById("titulo_g4").value) != 0)
	{
		alert(iObtener_Cadena_AJAX('error_graf2')+" 4 "+iObtener_Cadena_AJAX('error_graf3'));
		return 1;
	}
	if((top.document.getElementById("Filtro_combo_Informe").selectedIndex == 0))
	{
		if((top.document.getElementById("FechaInicial").value == ""))
		{
			alert(iObtener_Cadena_AJAX('error_graf6'));
			return 1;
		}
		if((top.document.getElementById("FechaFinal").value == ""))
		{
			alert(iObtener_Cadena_AJAX('error_graf7'));
			return 1;
		}
	}
	if((top.document.getElementById("Filtro_combo_Informe").selectedIndex == 1))
	{
		if((top.document.getElementById("tiempoGrafica").value == ""))
		{
			alert(iObtener_Cadena_AJAX('error_graf6'));
			return 1;
		}
		if((top.document.getElementById("tiempoIntervalo").value == ""))
		{
			alert(iObtener_Cadena_AJAX('error_graf7'));
			return 1;
		}
	}
	return 0;
}
function iBuscar_Num_Magnitudes(iGrafica)
{
	var sCadena1;
	var sCadena2;
	var iLong = $("#box"+(2*iGrafica)+"View option").length;
	iCuenta = 0;
	for (var k=0;k<(iLong-1);k++)
	{				
		sCadena1 = $("#box"+(2*iGrafica)+"View option").eq(k).attr('value').substring(19);
		for (var j=(k+1);j<iLong;j++)
		{
			sCadena2 = $("#box"+(2*iGrafica)+"View option").eq(j).attr('value').substring(19);
			if (sCadena1 != sCadena2)
			{
				iCuenta++;
			}
		}		
	}
	if (iCuenta == 0)
	{
		return 1;
	}
	else
	{
		switch (iLong)
		{
			case 4:
				if (iCuenta == 3)
				{
					return 2;
				}
				else
				{
					return iCuenta-2;
				}
				break;
			case 3:
				return iCuenta;
				break;
			case 2:
				return iCuenta+1;
				break;
			case 1:
			default:
				return 1;
				break;
		}
	}
}
function iBuscar_Nombres_Magnitudes(iGrafica)
{
	var j;
	var k;
	var sCadena1;
	var sCadena2;
	var iTotalMag=0;
	var saSalida = new Array();
	var iLong = $("#box"+(2*iGrafica)+"View option").length;
	for (k=0;k<iLong;k++)
	{
		sCadena1 = $("#box"+(2*iGrafica)+"View option").eq(k).attr('value').substring(19);
		if (k==0) 
		{
			saSalida[iTotalMag++] = sObtener_Nombre_Magnitud(sCadena1);
		}
		else
		{
			for (j=0;j<k;j++)
			{
				sCadena2 = $("#box"+(2*iGrafica)+"View option").eq(j).attr('value').substring(19);
				if (sCadena1 == sCadena2)
				{
					break;
				}
			}
			if (j==k)
			{
				saSalida[iTotalMag++] = sObtener_Nombre_Magnitud(sCadena1);
			}
		}
	}
	return saSalida;
}
function iComprobar_Magnitudes()
{
	var saMagnitudes = new Array();
	var iCuenta;
	var iLong;
	var sCadena1;

	for (var i=1;i<5;i++)
	{
		iCuentaMAG = 0;
		iLong = $("#box"+(2*i)+"View option").length;
		if (iLong > 2)
		{
			iCuenta = 0;
			for (var k=0;k<iLong;k++)
			{
				sCadena1 = $("#box"+(2*i)+"View option").eq(k).attr('value').substring(19);
				for (var j=0;j<iCuenta;j++)
				{
					if (sCadena1 == saMagnitudes[j])
					{
						break;
					}
				}
				if (j == iCuenta)
				{
					saMagnitudes[iCuenta++] = sCadena1;
				}
			}
		}
		if (iCuenta > 2)
		{
			return i;
		}
	}
	return 0;
}

//Returns contents of a canvas as a png based data url, with the specified
//background color
function canvasToImage(canvasaux)
{
	/*
	var data;
	var w = canvasaux.width;
	var h = canvasaux.height;
	var context = canvasaux.getContext("2d");	

	//get the current ImageData for the canvas.
	data = context.getImageData(0, 0, w, h);

	//store the current globalCompositeOperation
	var compositeOperation = context.globalCompositeOperation;

	//set to draw behind current content
	context.globalCompositeOperation = "destination-over";

	//set background color
	context.fillStyle = "rgb(255,255,255)";
	//context.fillStyle = "rgb(0,0,0)";
	//context.fillStyle = "#FFFFFF";

	//draw background / rect on entire canvas
	context.fillRect(0,0,w,h);
*/
	//get the image data from the canvas
	var imageData = canvasaux.toDataURL("image/png");
/*
	//clear the canvas
	//context.clearRect(0,0,w,h);

	//restore it with original / cached ImageData
	context.putImageData(data, 0,0);		

	//reset the globalCompositeOperation to what it was
	context.globalCompositeOperation = compositeOperation;
*/
	//return the Base64 encoded data url string
	return imageData;
}

function vDescargarPDF()
{
	var canvas1;
	var canvas2;
	var canvas3;
	var canvas4;
	
	if ($("#box2View option").length > 0)
	{
		canvas1 = plot[1].getCanvas();
		document.saveform.imagen1.value = canvasToImage(canvas1);
		document.saveform.imagen1_div.value = document.getElementById('caja_grafica1').innerHTML;
		document.saveform.imagen1_title.value = document.getElementById('titulo_g1').value;
	}
	if ($("#box4View option").length > 0)
	{
		canvas2 = plot[2].getCanvas();
		document.saveform.imagen2.value = canvasToImage(canvas2);
		document.saveform.imagen2_div.value = document.getElementById('caja_grafica2').innerHTML;
		document.saveform.imagen2_title.value = document.getElementById('titulo_g2').value;
	}
	if ($("#box6View option").length > 0)
	{
		canvas3 = plot[3].getCanvas();
		document.saveform.imagen3.value = canvasToImage(canvas3);
		document.saveform.imagen3_div.value = document.getElementById('caja_grafica3').innerHTML;
		document.saveform.imagen3_title.value = document.getElementById('titulo_g3').value;
	}	
	if ($("#box8View option").length > 0)
	{
		canvas4 = plot[4].getCanvas();
		document.saveform.imagen4.value = canvasToImage(canvas4);
		document.saveform.imagen4_div.value = document.getElementById('caja_grafica4').innerHTML;
		document.saveform.imagen4_title.value = document.getElementById('titulo_g4').value;
	}
	return true;
}