function onTickEstado(cbEste,iEstado,iNumber)
{
	if (cbEste == true) 
	{
		document.getElementById(iEstado+iNumber).checked = false;
	}
}
function sObtener_Sensores_Telemando(sDevice)
{
	var sUrlSensor;
	var xmlHttpgrInstSensor;
	sUrlSensor = "carga_sensores_telemando.php?cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&sdevice="+sDevice;
	xmlHttpgrInstSensor= GetXmlHttpObject();
	xmlHttpgrInstSensor.open("GET",sUrlSensor,false);
	xmlHttpgrInstSensor.send(null);
	if (xmlHttpgrInstSensor.responseText.substring(0,5)=='ERROR')
	{
		alert(xmlHttpgrInstSensor.responseText);
		return '';
	}
	else
	{
		return xmlHttpgrInstSensor.responseText;
	}
}
function sObtener_Eventos_Telemando(sDevice, sSensorIN)
{
	var sUrlSensor;
	var xmlHttpgrInstSensor;
	sUrlSensor = "carga_eventos_telemando.php?cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&sdevice="+sDevice+"&sSensorIN="+sSensorIN;
	xmlHttpgrInstSensor= GetXmlHttpObject();
	xmlHttpgrInstSensor.open("GET",sUrlSensor,false);
	xmlHttpgrInstSensor.send(null);
	if (xmlHttpgrInstSensor.responseText.substring(0,5)=='ERROR')
	{
		alert(xmlHttpgrInstSensor.responseText);
		return '';
	}
	else
	{
		return xmlHttpgrInstSensor.responseText;
	}
}
function sObtener_Salidas_Telemando(sDevice)
{
	var sUrlSensor;
	var xmlHttpgrInstSensor;
	sUrlSensor = "carga_salidas_telemando.php?cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&sdevice="+sDevice;
	xmlHttpgrInstSensor= GetXmlHttpObject();
	xmlHttpgrInstSensor.open("GET",sUrlSensor,false);
	xmlHttpgrInstSensor.send(null);
	if (xmlHttpgrInstSensor.responseText.substring(0,5)=='ERROR')
	{
		alert(xmlHttpgrInstSensor.responseText);
		return '';
	}
	else
	{
		return xmlHttpgrInstSensor.responseText;
	}
}
function onDevInChange(iNum, sGWID)
{
	if (document.getElementById('devin'+iNum).selectedIndex >= 0)
	{
		sContenido = sObtener_Sensores_Telemando(sGWID+document.getElementById('devin'+iNum).options[document.getElementById('devin'+iNum).selectedIndex].value);
		if (sContenido != '')
		{
			document.getElementById('in'+iNum).length = 0;
			select_innerHTML(document.getElementById('in'+iNum), sContenido);
			onInChange(iNum, sGWID);
		}
	}
}
function onInChange(iNum, sGWID)
{
	if ((document.getElementById('devin'+iNum).selectedIndex >= 0) && (document.getElementById('in'+iNum).selectedIndex >= 0))
	{
		sContenidoE = sObtener_Eventos_Telemando(sGWID+document.getElementById('devin'+iNum).options[document.getElementById('devin'+iNum).selectedIndex].value, document.getElementById('in'+iNum).options[document.getElementById('in'+iNum).selectedIndex].value);
		if (sContenidoE != '')
		{
			document.getElementById('evento'+iNum).length = 0;
			select_innerHTML(document.getElementById('evento'+iNum), sContenidoE);
		}
	}
}
function onDevOutChange(iNum, sGWID)
{
	if (document.getElementById('devout'+iNum).selectedIndex >= 0)
	{
		sContenido = sObtener_Salidas_Telemando(sGWID+document.getElementById('devout'+iNum).options[document.getElementById('devout'+iNum).selectedIndex].value);
		if (sContenido != '')
		{
			document.getElementById('out'+iNum).length = 0;
			select_innerHTML(document.getElementById('out'+iNum), sContenido);
		}
	}
}
function vLeerTMDB(sGWID)
{
	var sUrl;
	var xmlHttpgrInstSensor;
	sUrl = "carga_params_telemando.php?cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&gw_id="+sGWID;
	xmlHttpgrInstSensor= GetXmlHttpObject();
	xmlHttpgrInstSensor.open("GET",sUrl,false);
	xmlHttpgrInstSensor.send(null);
	if (xmlHttpgrInstSensor.responseText.substring(0,5)=='ERROR')
	{
		alert(xmlHttpgrInstSensor.responseText);
	}
	else
	{
		Rellenar_Telemando(xmlHttpgrInstSensor.responseText, sGWID);
	}
}
function vLimpiar_TM()
{
	for(iCn=1;iCn<11;iCn++)
	{
		$('#on'+iCn).removeAttr("checked");
		$('#off'+iCn).removeAttr("checked");
		$('#devin'+iCn).prop("selectedIndex",-1);
		$('#in'+iCn).prop("selectedIndex",-1);
		$('#evento'+iCn).prop("selectedIndex",-1);
		$('#devout'+iCn).prop("selectedIndex",-1);
		$('#out'+iCn).prop("selectedIndex",-1);
	}
}
function Rellenar_Telemando(sParamsTM, sGWID)
{
	var sPrincipal;
	var sNombres;
	var sValores;
	var sNParam;
	var sVParam;
	var iContador;

	vLimpiar_TM();
	sPrincipal=parsear_xml(sParamsTM);
	if (sPrincipal != null)
	{
		sNombres=sPrincipal.getElementsByTagName("nombre");
		sValores=sPrincipal.getElementsByTagName("valor");
		for(iContador=0;iContador<sNombres.length;iContador++)
		{
			sNParam=sNombres[iContador].childNodes[0].nodeValue;
			sVParam=sValores[iContador].childNodes[0].nodeValue;
			if ($('#'+sNParam))
			{
				if ((sNParam.substring(0,2) == 'on') || (sNParam.substring(0,3) == 'off'))
				{
					if (sVParam == 0)
					{
						$('#'+sNParam).removeAttr("checked");
					}
					else
					{
						$('#'+sNParam).attr("checked","checked");
					}
				}
				else if ($('#'+sNParam+' option').length > 0)
				{
					if ((sNParam.length>5) && ((sNParam.substring(0,5) == 'devin') || (sNParam.substring(0,5) == 'devou')))
					{
						$('#'+sNParam+' option[value="'+sVParam+'"]').attr("selected", "selected");
						if (sNParam.substring(0,5) == 'devin')
						{
							onDevInChange(sNParam.substring(5), sGWID);
						}
						else if (sNParam.substring(0,5) == 'devou')
						{
							onDevOutChange(sNParam.substring(6), sGWID);
						}
					}
					else if (parseInt(sVParam, 16) != 0)
					{
						$('#'+sNParam+' option[value="'+sVParam+'"]').attr("selected", "selected");
						if (sNParam.substring(0,2) == 'in')
						{
							onInChange(sNParam.substring(2), sGWID);
						}
					}
					else
					{
						$('#'+sNParam).prop("selectedIndex",-1);
					}
				}
				else
				{
					$('#'+sNParam).prop("selectedIndex",-1);
				}
			}
		}
	}
}