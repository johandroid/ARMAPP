function cargar_tipo_utcs(sComboUTC)
{
	var xmlHttpUTC;
	xmlHttpUTC= GetXmlHttpObject();
	var url = "carga_tipo_utcs.php";
	//alert(url);
	xmlHttpUTC.open("GET",url,false);
	xmlHttpUTC.send(null);
	
	var doc=xmlHttpUTC.responseText;
	var xmlrespuesta = parsear_xml(doc);
	var vvx=xmlrespuesta.getElementsByTagName("utc");
	document.getElementById(sComboUTC).length=0;
	for(i=0;i<vvx.length;i++)
	{
		if (xmlrespuesta.getElementsByTagName("utc")[i].attributes[1].nodeValue.length == 0)
		{
			insertarOptionCombo(sComboUTC,xmlrespuesta.getElementsByTagName("utc")[i].attributes[0].nodeValue, iObtener_Cadena_AJAX('general255')+' '+xmlrespuesta.getElementsByTagName("utc")[i].attributes[0].nodeValue);
		}
		else
		{
			insertarOptionCombo(sComboUTC,xmlrespuesta.getElementsByTagName("utc")[i].attributes[0].nodeValue, xmlrespuesta.getElementsByTagName("utc")[i].attributes[1].nodeValue);
		}
	}	
}

function vCambiar_Magnitudes()
{
	var xmlHttpMagnitudes;
	xmlHttpMagnitudes= GetXmlHttpObject();
	var url = "carga_magnitudes.php?analizador_id="+document.getElementById("tipo_dispositivo").options[document.getElementById("tipo_dispositivo").selectedIndex].id;

	xmlHttpMagnitudes.open("GET",url,false);
	xmlHttpMagnitudes.send(null);
	
	if (xmlHttpMagnitudes.readyState==4)
	{
		var doc=xmlHttpMagnitudes.responseText;
		document.getElementById("tipo_magnitudes").innerHTML = sGenerar_Magnitudes(doc,"magnitudes", 1);
		document.getElementById("tipo_notsms").innerHTML = sGenerar_Magnitudes(doc,"magnitudesSMS", 0);
		document.getElementById("tipo_notemail").innerHTML = sGenerar_Magnitudes(doc,"magnitudesEMAIL", 0);
	}
}

function sGenerar_Magnitudes(doc, sAp, iCheck)
{
	var xmlrespuesta = parsear_xml(doc);
	var vvx=xmlrespuesta.getElementsByTagName("magnitud");
	var div_magnitudes = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >";
	for(i=0;i<vvx.length;i++)
	{
		if(i%3 == 0)
		{
			div_magnitudes += "<tr style=\"width:100%\">";
		}
		div_magnitudes += "<td style=\"width:29%\"><span class=\"texto_parametros\">";
		if (xmlrespuesta.getElementsByTagName("magnitud")[i].attributes[0].nodeValue.length != 0)
		{
			div_magnitudes += xmlrespuesta.getElementsByTagName("magnitud")[i].attributes[0].nodeValue;
		}
		else
		{
			div_magnitudes += iObtener_Cadena_AJAX('sensor_no');
		}
		switch (iCheck)
		{
			case 1:
				sCheck = "checked=\"checked\"";
				
				break;
			default:
				sCheck = "";
				break;
		}
		switch (xmlrespuesta.getElementsByTagName("magnitud")[i].attributes[1].nodeValue)
		{
			case "1":
				sCadenaHab = "";
				break;
			default:
				if (iCheck == 0)
				{
					sCadenaHab="disabled=\"disabled\"";
				}
				else
				{
					sCadenaHab = "";
				}
				break;
		}
		
		div_magnitudes += "</span></td><td style=\"width:4%\"><input type=\"checkbox\" "+sCadenaHab+" name=\""+sAp+"\" value=\""+i+"\" "+sCheck+"\"/></td>";
		if(i%3 == 2)
		{
			div_magnitudes += "</tr>";
		}
	}
	if(i%3 == 0)
	{
		div_magnitudes += "</tr><table>";
	}
	else if(i%3 == 2)
	{
		div_magnitudes += "<td style=\"width:29%\"></td><td style=\"width:4%\"></td></tr><table>";
	}
	else
	{
		div_magnitudes += "<td style=\"width:29%\"></td><td style=\"width:4%\"></td><td style=\"width:29%\"></td><td style=\"width:4%\"></td></tr><table>";
	}
	return div_magnitudes;
}

function iComprobar_Valores_UTC()
{
	if (document.getElementById('nombre_disp').value.length > 20)
	{
		alert(iObtener_Cadena_AJAX("error_utc1"));
		return -1;
	}
	else if (iComprobar_Nombre(document.getElementById('nombre_disp').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc2"));
		return -1;
	}
	if (document.getElementById('selectGateways').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc3"));
		return -1;
	}
	if (iComprobar_KEY(document.getElementById('direccion_485').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc4"));
		return -1;
	}
	if (document.getElementById('tipo_dispositivo').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc5"));
		return -1;
	}
	if (document.getElementById('HMR').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw80"));
		return -1;
	}
	return 0;
}

function sPrepararCadenaMagnitudes(sEntrada)
{
	var vector_magnitudes = document.getElementsByName(sEntrada);
	var sCadenaMagnitudes = "";
	for (i=0; i< vector_magnitudes.length; i++)
	{
		//alert(vector_magnitudes[i].value);
		if(vector_magnitudes[i].checked == true)
			sCadenaMagnitudes += "1";
		else
			sCadenaMagnitudes += "0";
	}
	return sCadenaMagnitudes;
}

function vAsignaMagnitudes(sCadenaMagnitudes,sEntrada)
{
	var vector_magnitudes = document.getElementsByName(sEntrada);
	for (i=0; i< vector_magnitudes.length; i++)
	{
		magnitud = sCadenaMagnitudes.substr(i,1);
		if(magnitud == 1)
			vector_magnitudes[i].checked = true;
		else
			vector_magnitudes[i].checked = false;
	}
	return sCadenaMagnitudes;
}

function vMarkAll()
{
	var atabsi = tabbar.getActiveTab();
	switch (tabbar.getActiveTab())
	{
		case 'u1':
			sEntrada = 'magnitudes';
			break;
		case 'u2':
			sEntrada = 'magnitudesSMS';
			break;
		case 'u3':
			sEntrada = 'magnitudesEMAIL';
			break;
		default:
			return;
			break;
	}
	var tbTab = document.getElementsByName(sEntrada);
	for (i=0; i< tbTab.length; i++)
	{
		if (tbTab[i].disabled == false)
		{
			tbTab[i].checked = true;
		}
	}
}
function vUnMarkAll()
{
	var atabsi = tabbar.getActiveTab();
	switch (tabbar.getActiveTab())
	{
		case 'u1':
			sEntrada = 'magnitudes';
			break;
		case 'u2':
			sEntrada = 'magnitudesSMS';
			break;
		case 'u3':
			sEntrada = 'magnitudesEMAIL';
			break;
		default:
			return;
			break;
	}
	var tbTab = document.getElementsByName(sEntrada);
	for (i=0; i< tbTab.length; i++)
	{
		if (tbTab[i].disabled == false)
		{
			tbTab[i].checked = false;
		}
	}
}

function iComprobar_Parametros_UTC()
{
	if (iComprobar_Entero_Rango(document.getElementById('tiempo_medida').value,2,3,90) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc6"));
		return -1;
	}
	if (iComprobar_Entero_Rango( Math.round(document.getElementById('setpoint').value*100),3,10,490) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc7"));
		return -1;
	}
	if (document.getElementById('delta').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc8"));
		return -1;
	}
	if (document.getElementById('habilita_punto_bajo').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc9"));
		return -1;
	}
	if (document.getElementById('habilita_tiempo_maximo').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc9"));
		return -1;
	}
	if (document.getElementById('habilita_alarma_alta_cloro').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc9"));
		return -1;
	}
	if (document.getElementById('habilita_alarma_baja_cloro').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc9"));
		return -1;
	}
	if (iComprobar_Entero_Rango( Math.round(document.getElementById('punto_bajo').value*100),3,0,100) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc10"));
		return -1;
	}
	if (iComprobar_Entero_Rango(document.getElementById('tiempo_maximo').value,3,30,720) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc11"));
		return -1;
	}
	if (iComprobar_Entero_Rango( Math.round(document.getElementById('alarma_alta_cloro').value*100),3,0,500) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc12"));
		return -1;
	}
	if (iComprobar_Entero_Rango( Math.round(document.getElementById('alarma_baja_cloro').value*100),3,0,500) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_utc13"));
		return -1;
	}
	return 0;
}

function sCargar_GW_UTC(sUTCID)
{
	var xmlHttpgrReadNode;
	var url = "cargar_gw_UTC.php?cliente_db="+top.document.getElementById("db_cliente").value+"&utc_id="+sUTCID;
	xmlHttpgrReadNode= GetXmlHttpObject();
	xmlHttpgrReadNode.open("GET",url,false);
	xmlHttpgrReadNode.send(null);
	if (xmlHttpgrReadNode.responseText.substring(0,5) != "ERROR")
	{
		return xmlHttpgrReadNode.responseText;
	}
	else
	{
		alert(xmlHttpgrReadNode.responseText);
	}	
}