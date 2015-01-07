function Rellenar_Funciones_Logicas_GW(combo_entrada)
{
	document.getElementById(combo_entrada).length = 0;
	insertarOptionCombo(combo_entrada,combo_entrada+"0","OFF");
	insertarOptionCombo(combo_entrada,combo_entrada+"1","S1 & S2");
	insertarOptionCombo(combo_entrada,combo_entrada+"2","S1 & S3");
	insertarOptionCombo(combo_entrada,combo_entrada+"3","S2 & S3");
	insertarOptionCombo(combo_entrada,combo_entrada+"4","S1 & S2 & S3");
	insertarOptionCombo(combo_entrada,combo_entrada+"5","S1 | S2");
	insertarOptionCombo(combo_entrada,combo_entrada+"6","S1 | S3");
	insertarOptionCombo(combo_entrada,combo_entrada+"7","S3 | S3");
	insertarOptionCombo(combo_entrada,combo_entrada+"8","S1 | S2 | S3");
	document.getElementById(combo_entrada).selectedIndex = -1;
}

function Rellenar_Todos_Tipos_Sensor_GW(caVersionHWIN, caVersionSWIN)
{
	var sCadenaXML = '';
	sCadenaXML += "&sCadenaXML[]=" + "sensor_no";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type4";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type5";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type1";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type6";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type2";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type21";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type9";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type86";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_anem_davis";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_vel_davis";
	sCadenaXML += "&sCadenaXML[]=" + "general337";
	sCadenaXML += "&sCadenaXML[]=" + "general338";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type92";
	xObtener_XML_AJAX(sCadenaXML, sRellena_TS_GW, caVersionHWIN, caVersionSWIN);
}
function sRellena_TS_GW(sEntradaXML, caVersionHWIN, caVersionSWIN, iNumSen)
{
	var xSalida = eval('(' + sEntradaXML + ')');
	for (sI=1;sI<10;sI++)
	{
		Rellenar_Tipos_Sensor_GW("TS"+sI, xSalida, caVersionHWIN, caVersionSWIN);	
	}
}
function Rellenar_Tipos_Sensor_GW(combo_entrada, xEntrada, caVersionHWIN, caVersionSWIN)
{
	iNumSen = parseInt(combo_entrada.substring(2,3));
	document.getElementById(combo_entrada).length = 0;
	insertarOptionCombo(combo_entrada,"0",xEntrada["sensor_no"]);
	insertarOptionCombo(combo_entrada,"2",xEntrada["sensor_type4"]+" (A3)");
	insertarOptionCombo(combo_entrada,"3",xEntrada["sensor_type5"]+" 1 (D0) (0: "+xEntrada["general337"]+")");
	insertarOptionCombo(combo_entrada,"4",xEntrada["sensor_type5"]+" 2 (D1) (0: "+xEntrada["general337"]+")");
	insertarOptionCombo(combo_entrada,"5",xEntrada["sensor_type5"]+" 3 (D2) (0: "+xEntrada["general337"]+")");
	insertarOptionCombo(combo_entrada,"6",xEntrada["sensor_type5"]+" 4 (D3) (0: "+xEntrada["general337"]+")");
	insertarOptionCombo(combo_entrada,"7",xEntrada["sensor_type1"]+" (A4)");
	insertarOptionCombo(combo_entrada,"8",xEntrada["sensor_type6"]+" (P1)");
	insertarOptionCombo(combo_entrada,"9",xEntrada["sensor_anem_davis"]);
	insertarOptionCombo(combo_entrada,"10",xEntrada["sensor_vel_davis"]+" (A1)");
	insertarOptionCombo(combo_entrada,"11",xEntrada["sensor_type2"]+" (A2)");
	insertarOptionCombo(combo_entrada,"12",xEntrada["sensor_type21"]+" (A3)");
	insertarOptionCombo(combo_entrada,"13",xEntrada["sensor_type9"]+" 2 (P2)");
	insertarOptionCombo(combo_entrada,"14",xEntrada["sensor_type9"]+" 3 (P3)");
	insertarOptionCombo(combo_entrada,"15",xEntrada["sensor_type9"]+" 4 (P4)");
	insertarOptionCombo(combo_entrada,"16",xEntrada["sensor_type86"] + " (A3)");
	insertarOptionCombo(combo_entrada,"17",xEntrada["sensor_type5"]+" 1B (D0) (0: "+xEntrada["general338"]+")");
	insertarOptionCombo(combo_entrada,"18",xEntrada["sensor_type5"]+" 2B (D1) (0: "+xEntrada["general338"]+")");
	insertarOptionCombo(combo_entrada,"19",xEntrada["sensor_type5"]+" 3B (D2) (0: "+xEntrada["general338"]+")");
	insertarOptionCombo(combo_entrada,"20",xEntrada["sensor_type5"]+" 4B (D3) (0: "+xEntrada["general338"]+")");
	if (parseInt(caVersionSWIN) > 1001)
	{
		insertarOptionCombo(combo_entrada,"21",xEntrada["sensor_type4"]+" (A1)");
		insertarOptionCombo(combo_entrada,"22",xEntrada["sensor_type4"]+" (A2)");
		insertarOptionCombo(combo_entrada,"23",xEntrada["sensor_type4"]+" (A4)");
		if (parseInt(caVersionHWIN) > 11)
		{
			insertarOptionCombo(combo_entrada,"24",xEntrada["sensor_type4"]+" (A5)");
			insertarOptionCombo(combo_entrada,"25",xEntrada["sensor_type4"]+" (A6)");
			insertarOptionCombo(combo_entrada,"26",xEntrada["sensor_type4"]+" (A7)");
		}
		if ((parseInt(caVersionSWIN) >= 1100) && (iNumSen < 4))
		{
			insertarOptionCombo(combo_entrada,"27",xEntrada["sensor_type92"] + " 1");
			insertarOptionCombo(combo_entrada,"28",xEntrada["sensor_type92"] + " 2");
			insertarOptionCombo(combo_entrada,"29",xEntrada["sensor_type92"] + " 3");
		}
	}
	document.getElementById(combo_entrada).selectedIndex = 0;
}
function sRellena_TS_GW_LOWA(sEntradaXML, caVersionHWIN, caVersionSWIN)
{
	var xSalida = eval('(' + sEntradaXML + ')');
	Rellenar_Tipos_Sensor_GW_Low_Analog("A0K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Analog("A1K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Analog("A2K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Analog("A3K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Analog("A4K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Analog("A5K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Analog("A6K", xSalida);
}
function Rellenar_Todos_Tipos_Sensor_GW_LOWA()
{
	var sCadenaXML = '';
	sCadenaXML += "&sCadenaXML[]=" + "sensor_no";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type84";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type85";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type1";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_vel_davis";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type2";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type21";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type13";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type16";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type21";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type3";
	xObtener_XML_AJAX(sCadenaXML, sRellena_TS_GW_LOWA, "00", "0000");
}
function Rellenar_Tipos_Sensor_GW_Low_Analog(combo_entrada, xEntrada)
{
	document.getElementById(combo_entrada).length = 0;
	if(combo_entrada == "A0K" || combo_entrada == "A1K" || combo_entrada == "A2K")
	{
		insertarOptionCombo(combo_entrada,"0",xEntrada["sensor_no"]);
		insertarOptionCombo(combo_entrada,"35",xEntrada["sensor_type84"]);
		insertarOptionCombo(combo_entrada,"36",xEntrada["sensor_type85"]);		
	}
	else
	{
		insertarOptionCombo(combo_entrada,"0",xEntrada["sensor_no"]);
		//insertarOptionCombo(combo_entrada,"6",xEntrada["sensor_type14"]);	
		insertarOptionCombo(combo_entrada,"30",xEntrada["sensor_type1"]);
		insertarOptionCombo(combo_entrada,"33",xEntrada["sensor_vel_davis"]);
		insertarOptionCombo(combo_entrada,"31",xEntrada["sensor_type2"]);
		insertarOptionCombo(combo_entrada,"32",xEntrada["sensor_type21"]);
		insertarOptionCombo(combo_entrada,"37","ECHO-5");
    	insertarOptionCombo(combo_entrada,"38","ECHO-10");
    	insertarOptionCombo(combo_entrada,"39","ECHO-20");
    	insertarOptionCombo(combo_entrada,"40","10HS");
    	insertarOptionCombo(combo_entrada,"41","LM61");
    	insertarOptionCombo(combo_entrada,"42","DSFW "+xEntrada["sensor_type13"]);
    	insertarOptionCombo(combo_entrada,"43",xEntrada["sensor_type16"] + " 107");
    	insertarOptionCombo(combo_entrada,"44",xEntrada["sensor_type21"] + " SRS100");
    	insertarOptionCombo(combo_entrada,"45","HI 98143 pH");
    	insertarOptionCombo(combo_entrada,"46","HI 98143 "+xEntrada["sensor_type3"]);    			
	}
	document.getElementById(combo_entrada).selectedIndex = -1;
}
function sRellena_TS_GW_LOWD(sEntradaXML, caVersionHWIN, caVersionSWIN)
{
	var xSalida = eval('(' + sEntradaXML + ')');
	//alert(xSalida["sensor_anem_davis"]);
	Rellenar_Tipos_Sensor_GW_Low_Digital("D0K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("D1K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("D2K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("D3K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("D4K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("D5K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("D6K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("D7K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("D8K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("D9K", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("DAK", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("DBK", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("DBK", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("DCK", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("DDK", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("DEK", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Digital("DFK", xSalida);
}
function Rellenar_Todos_Tipos_Sensor_GW_LOWD()
{
	var sCadenaXML = '';
	sCadenaXML += "&sCadenaXML[]=" + "sensor_no";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type6";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_anem_davis";
	sCadenaXML += "&sCadenaXML[]=" + "sensor_type9";
	//alert(sCadenaXML);
	xObtener_XML_AJAX(sCadenaXML, sRellena_TS_GW_LOWD, "00", "0000");
}
function Rellenar_Tipos_Sensor_GW_Low_Digital(combo_entrada, xEntrada)
{
	document.getElementById(combo_entrada).length = 0;
	insertarOptionCombo(combo_entrada,"0",xEntrada["sensor_no"]);
	insertarOptionCombo(combo_entrada,"8",xEntrada["sensor_type6"]+" (P2)");
	insertarOptionCombo(combo_entrada,"34",xEntrada["sensor_anem_davis"]);
	insertarOptionCombo(combo_entrada,"13",xEntrada["sensor_type9"]);	
	document.getElementById(combo_entrada).selectedIndex = -1;
}
function sRellena_TS_GW_ALI(sEntradaXML, caVersionHWIN, caVersionSWIN)
{
	var xSalida = eval('(' + sEntradaXML + ')');
	//alert(xSalida["sensor_anem_davis"]);
	Rellenar_Tipos_Sensor_GW_Low_Alimentacion("A0P", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Alimentacion("A1P", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Alimentacion("A2P", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Alimentacion("A3P", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Alimentacion("A4P", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Alimentacion("A5P", xSalida);
	Rellenar_Tipos_Sensor_GW_Low_Alimentacion("A6P", xSalida);
}
function Rellenar_Todos_Tipos_Sensor_GW_LOWALI()
{
	var sCadenaXML = '';
	sCadenaXML += "&sCadenaXML[]=" + "alimentacion_no";
	sCadenaXML += "&sCadenaXML[]=" + "alimentacion_18";
	sCadenaXML += "&sCadenaXML[]=" + "alimentacion_3";
	sCadenaXML += "&sCadenaXML[]=" + "alimentacion_5";
	//alert(sCadenaXML);
	xObtener_XML_AJAX(sCadenaXML, sRellena_TS_GW_ALI, "00", "0000");
}
function Rellenar_Tipos_Sensor_GW_Low_Alimentacion(combo_entrada, xEntrada)
{
	document.getElementById(combo_entrada).length = 0;
	if(combo_entrada == 'A0P' || combo_entrada == 'A1P' || combo_entrada == 'A2P')
	{
		insertarOptionCombo(combo_entrada,"0", xEntrada["alimentacion_no"]);
		insertarOptionCombo(combo_entrada,"4", xEntrada["alimentacion_18"]);
	}
	else
	{
		insertarOptionCombo(combo_entrada,"0", xEntrada["alimentacion_no"]);
		insertarOptionCombo(combo_entrada,"1", xEntrada["alimentacion_3"]);
		insertarOptionCombo(combo_entrada,"3", xEntrada["alimentacion_5"]);	
	}
	document.getElementById(combo_entrada).selectedIndex = -1;
}

function Rellenar_Tipos_Sensor_GW_LowT(combo_entrada,tipo)
{
	document.getElementById(combo_entrada).length = 0;
	insertarOptionCombo(combo_entrada,"000","Ninguno");
	switch(tipo)
	{
		case 1:
			insertarOptionCombo(combo_entrada,"H01","Entrada Digital NA");
			insertarOptionCombo(combo_entrada,"H02","Entrada Digital NC");
			break;
		case 2:
			insertarOptionCombo(combo_entrada,"AN1","Analógico");
			break;
		case 3:
			insertarOptionCombo(combo_entrada,"H03","Salida Relé");
			break;
		case 4:
			insertarOptionCombo(combo_entrada,"H04","Salida Digital Nivel Alto");
			insertarOptionCombo(combo_entrada,"H05","Salida Digital Nivel Bajo");
			break;
	}
	document.getElementById(combo_entrada).selectedIndex = -1;
}
function Rellenar_Tipos_Alimentacion_GW_LowT(combo_entrada)
{
	document.getElementById(combo_entrada).length = 0;
	insertarOptionCombo(combo_entrada,combo_entrada+"0","Sin Alimentación");
	insertarOptionCombo(combo_entrada,combo_entrada+"1","Alimentación 3V");
	insertarOptionCombo(combo_entrada,combo_entrada+"2","Alimentación 3V6");
	insertarOptionCombo(combo_entrada,combo_entrada+"3","Alimentación 5V");
	insertarOptionCombo(combo_entrada,combo_entrada+"4","Alimentación 12V");
	document.getElementById(combo_entrada).selectedIndex = -1;
}

function Rellenar_CombosOnOff_GW_LowT(combo_entrada)
{
	document.getElementById(combo_entrada).length = 0;
	insertarOptionCombo(combo_entrada,combo_entrada+"0","Offline");
	insertarOptionCombo(combo_entrada,combo_entrada+"1","Online");
	document.getElementById(combo_entrada).selectedIndex = -1;
}
function Rellenar_CombosHab_GW_LowT(combo_entrada)
{
	document.getElementById(combo_entrada).length = 0;
	insertarOptionCombo(combo_entrada,combo_entrada+"0","No habilitada");
	insertarOptionCombo(combo_entrada,combo_entrada+"1","Habilitada");
	document.getElementById(combo_entrada).selectedIndex = -1;
}
function Rellenar_CombosOperador_GW_LowT(combo_entrada)
{
	document.getElementById(combo_entrada).length = 0;
	insertarOptionCombo(combo_entrada,combo_entrada+"0","Ninguno");
	insertarOptionCombo(combo_entrada,combo_entrada+"1","Movistar");
	insertarOptionCombo(combo_entrada,combo_entrada+"2","Vodafone");
	insertarOptionCombo(combo_entrada,combo_entrada+"3","Orange");
	document.getElementById(combo_entrada).selectedIndex = -1;
}
function Rellenar_CombosHora_GW_LowT(combo_entrada)
{
	document.getElementById(combo_entrada).length = 0;
	for(i=0;i<24;i++)
	{
		insertarOptionCombo(combo_entrada,combo_entrada+i,(i<10)?'0'+i:i);
	}
	document.getElementById(combo_entrada).selectedIndex = -1;
}
function Rellenar_CombosMinuto_GW_LowT(combo_entrada)
{
	document.getElementById(combo_entrada).length = 0;
	for(i=0;i<60;i++)
	{
		insertarOptionCombo(combo_entrada,combo_entrada+i,(i<10)?'0'+i:i);
	}
	document.getElementById(combo_entrada).selectedIndex = -1;
}
//////////////////////////////////////////////////// FIN LOWT ///////////////////////////////////////////////////////

function OnClickMAXS1()
{
	if (document.getElementById('MAXS1T').checked)
	{
		document.getElementById('MAXS1O1').disabled="";
		document.getElementById('MAXS1O2').disabled="";
		document.getElementById('MAXS1O3').disabled="";
	}
	else
	{
		document.getElementById('MAXS1O1').checked=false;
		document.getElementById('MAXS1O2').checked=false;
		document.getElementById('MAXS1O3').checked=false;
		document.getElementById('MAXS1O1').disabled="disabled";
		document.getElementById('MAXS1O2').disabled="disabled";
		document.getElementById('MAXS1O3').disabled="disabled";
	}
}
function OnClickMINS1()
{
	if (document.getElementById('MINS1T').checked)
	{
		document.getElementById('MINS1O1').disabled="";
		document.getElementById('MINS1O2').disabled="";
		document.getElementById('MINS1O3').disabled="";
	}
	else
	{
		document.getElementById('MINS1O1').checked=false;
		document.getElementById('MINS1O2').checked=false;
		document.getElementById('MINS1O3').checked=false;
		document.getElementById('MINS1O1').disabled="disabled";
		document.getElementById('MINS1O2').disabled="disabled";
		document.getElementById('MINS1O3').disabled="disabled";
	}
}
function OnClickMAXS2()
{
	if (document.getElementById('MAXS2T').checked)
	{
		document.getElementById('MAXS2O1').disabled="";
		document.getElementById('MAXS2O2').disabled="";
		document.getElementById('MAXS2O3').disabled="";
	}
	else
	{
		document.getElementById('MAXS2O1').checked=false;
		document.getElementById('MAXS2O2').checked=false;
		document.getElementById('MAXS2O3').checked=false;
		document.getElementById('MAXS2O1').disabled="disabled";
		document.getElementById('MAXS2O2').disabled="disabled";
		document.getElementById('MAXS2O3').disabled="disabled";
	}
}
function OnClickMINS2()
{
	if (document.getElementById('MINS2T').checked)
	{
		document.getElementById('MINS2O1').disabled="";
		document.getElementById('MINS2O2').disabled="";
		document.getElementById('MINS2O3').disabled="";
	}
	else
	{
		document.getElementById('MINS2O1').checked=false;
		document.getElementById('MINS2O2').checked=false;
		document.getElementById('MINS2O3').checked=false;
		document.getElementById('MINS2O1').disabled="disabled";
		document.getElementById('MINS2O2').disabled="disabled";
		document.getElementById('MINS2O3').disabled="disabled";
	}
}
function OnClickMAXS3()
{
	if (document.getElementById('MAXS3T').checked)
	{
		document.getElementById('MAXS3O1').disabled="";
		document.getElementById('MAXS3O2').disabled="";
		document.getElementById('MAXS3O3').disabled="";
	}
	else
	{
		document.getElementById('MAXS3O1').checked=false;
		document.getElementById('MAXS3O2').checked=false;
		document.getElementById('MAXS3O3').checked=false;
		document.getElementById('MAXS3O1').disabled="disabled";
		document.getElementById('MAXS3O2').disabled="disabled";
		document.getElementById('MAXS3O3').disabled="disabled";
	}
}
function OnClickMINS3()
{
	if (document.getElementById('MINS3T').checked)
	{
		document.getElementById('MINS3O1').disabled="";
		document.getElementById('MINS3O2').disabled="";
		document.getElementById('MINS3O3').disabled="";
	}
	else
	{
		document.getElementById('MINS3O1').checked=false;
		document.getElementById('MINS3O2').checked=false;
		document.getElementById('MINS3O3').checked=false;
		document.getElementById('MINS3O1').disabled="disabled";
		document.getElementById('MINS3O2').disabled="disabled";
		document.getElementById('MINS3O3').disabled="disabled";
	}
}

function OnClickActuacion(sCheckActivar,sCheckS1,sCheckS2,sCheckS3)
{
	if (document.getElementById(sCheckActivar).checked)
	{
		document.getElementById(sCheckS1).disabled="";
		document.getElementById(sCheckS2).disabled="";
		document.getElementById(sCheckS3).disabled="";
	}
	else
	{
		document.getElementById(sCheckS1).checked=false;
		document.getElementById(sCheckS2).checked=false;
		document.getElementById(sCheckS3).checked=false;
		document.getElementById(sCheckS1).disabled="disabled";
		document.getElementById(sCheckS2).disabled="disabled";
		document.getElementById(sCheckS3).disabled="disabled";
	}
}

function iComprobar_Valores()
{
	if (document.getElementById('NGW').value.length > 20)
	{
		alert(iObtener_Cadena_AJAX("error_gw1"));
		return -1;
	}
	else if (iComprobar_Nombre(document.getElementById('NGW').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw2"));
		return -1;
	}
	if (document.getElementById('KEY').value.length > 0)
	{
		if (iComprobar_KEY(document.getElementById('KEY').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw3"));
			return -1;
		}
	}
	if (document.getElementById('IPP').value.length > 0)
	{
		if (iComprobar_IP(document.getElementById('IPP').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw5"));
			return -1;
		}
	}
	if (document.getElementById('MSK').value.length > 0)
	{
		if (iComprobar_IP(document.getElementById('MSK').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw6"));
			return -1;
		}
	}
	if (document.getElementById('PDE').value.length > 0)
	{
		if (iComprobar_IP(document.getElementById('PDE').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw7"));
			return -1;
		}
	}
	if (document.getElementById('TPP').value.length > 0)
	{
		if (iComprobar_Entero(document.getElementById('TPP').value,3) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw8"));
			return -1;
		}
	}
	if (document.getElementById('ITC').value.length > 0)
	{
		if (iComprobar_Entero(document.getElementById('ITC').value,3) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw9"));
			return -1;
		}
	}
	if (document.getElementById('ITP').value.length > 0)
	{
		if (iComprobar_Entero(document.getElementById('ITP').value,5) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw35"));
			return -1;
		}
	}
	if (document.getElementById('IPX').value.length > 0)
	{
		if (iComprobar_IP(document.getElementById('IPX').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw12"));
			return -1;
		}
	}
	if (document.getElementById('IPY').value.length > 0)
	{
		if (iComprobar_IP(document.getElementById('IPY').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw13"));
			return -1;
		}
	}
	if (document.getElementById('PRX').value.length > 0)
	{
		if (iComprobar_Port(document.getElementById('PRX').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw14"));
			return -1;
		}
	}
	if (document.getElementById('PRY').value.length > 0)
	{
		if (iComprobar_Port(document.getElementById('PRY').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw15"));
			return -1;
		}
	}
	if (document.getElementById('PGT').value.length > 0)
	{
		if (iComprobar_Port(document.getElementById('PGT').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw16"));
			return -1;
		}
	}
	if (document.getElementById('PGU').value.length > 0)
	{
		if (iComprobar_Port(document.getElementById('PGU').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw17"));
			return -1;
		}
	}
	if (document.getElementById('IPW').value.length > 0)
	{
		if (iComprobar_IP(document.getElementById('IPW').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw19"));
			return -1;
		}
	}
	if (document.getElementById('IPZ').value.length > 0)
	{
		if (iComprobar_IP(document.getElementById('IPZ').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw20"));
			return -1;
		}
	}
	if (document.getElementById('GSX').value.length > 0)
	{
		if (iComprobar_Entero(document.getElementById('GSX').value,11) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw21"));
			return -1;
		}
	}
	if (document.getElementById('GSY').value.length > 0)
	{
		if (iComprobar_Entero(document.getElementById('GSY').value,11) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw22"));
			return -1;
		}			
	}
	for (iContador = 1; iContador < 10; iContador++)
	{
		if (document.getElementById('T'+iContador+'M').value.length > 0)
		{
			if (iComprobar_Entero(document.getElementById('T'+iContador+'M').value,9) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw25")+" "+iContador);
				return -1;
			}
		}
		if (document.getElementById('T'+iContador+'S').value.length > 0)
		{
			if (iComprobar_Entero(document.getElementById('T'+iContador+'S').value,9) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw26")+" "+iContador);
				return -1;
			}
		}
		if (document.getElementById('P'+iContador+'X').value.length > 0)
		{
			if (iComprobar_Decimal(document.getElementById('P'+iContador+'X').value,9) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw27")+" "+iContador);
				return -1;
			}
		}
		if (document.getElementById('P'+iContador+'N').value.length > 0)
		{
			if (iComprobar_Decimal(document.getElementById('P'+iContador+'N').value,9) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw28")+" "+iContador);
				return -1;
			}
		}
		
		iTSTemp = iObtener_TSGW_Select("TS"+iContador);
		if (iTSTemp == 14)
		{
			if (document.getElementById('M'+iContador+'X').length > 0)
			{	
				if (iComprobar_Decimal(document.getElementById('M'+iContador+'X').value,4) == -1)
				{
					alert(iObtener_Cadena_AJAX("error_gw75")+" "+(iContador+1));
					return -1;
				}
			}
			if (document.getElementById('M'+iContador+'N').length > 0)
			{
				if (iComprobar_Decimal(document.getElementById('M'+iContador+'N').value,4) == -1)
				{
					alert(iObtener_Cadena_AJAX("error_gw76")+" "+(iContador+1));
					return -1;
				}
			}				
			if(document.getElementById('P'+iContador+'X').value.length > 0 &&
			  (document.getElementById('M'+iContador+'X').value.length == 0 
			  || document.getElementById('M'+iContador+'N').value.length == 0))
			{
					alert(iObtener_Cadena_AJAX("error_gw78"));
					return -1;				
			}
			if(document.getElementById('P'+iContador+'N').value.length > 0 &&
			  (document.getElementById('M'+iContador+'X').value.length == 0 
			  || document.getElementById('M'+iContador+'N').value.length == 0))
			{
					alert(iObtener_Cadena_AJAX("error_gw78"));
					return -1;				
			}
			if (document.getElementById('SN'+iContador).value.length > 20)
			{
				alert(iObtener_Cadena_AJAX("error_gw1"));
				return -1;
			}
			else if (iComprobar_Nombre(document.getElementById('SN'+iContador).value) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_graf3"));
				return -1;
			}
		}		
	}
	return 0;
}
function iComprobar_Valores_low()
{
	if (document.getElementById('NGW').value.length > 20)
	{
		alert(iObtener_Cadena_AJAX("error_gw1"));
		return -1;
	}
	else if (iComprobar_Nombre(document.getElementById('NGW').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw2"));
		return -1;
	}
	if (document.getElementById('CTA').value.length > 0)
	{	
		if (iComprobar_Entero(document.getElementById('CTA').value,5) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw9"));
			return -1;
		}
	}
	if (document.getElementById('CIS').value.length > 0)
	{	
		if (iComprobar_IP(document.getElementById('CIS').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw12"));
			return -1;
		}
	}
	if (document.getElementById('CID').value.length > 0)
	{		
		if (iComprobar_IP(document.getElementById('CID').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw13"));
			return -1;
		}
	}
	if (document.getElementById('CIP').value.length > 0)
	{	
		if (iComprobar_Port(document.getElementById('CIP').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw73"));
			return -1;
		}
	}	
	if (document.getElementById('CIT').value.length > 0)
	{	
		if (iComprobar_Port(document.getElementById('CIT').value) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw74"));
			return -1;
		}
	}			
	for (iContador = 0; iContador < 10; iContador++)
	{
		if(iContador < 3)
		{
			if (document.getElementById('M'+iContador+'X').length > 0)
			{	
				if (iComprobar_Entero(document.getElementById('M'+iContador+'X').value,5) == -1)
				{
					alert(iObtener_Cadena_AJAX("error_gw75")+" "+(iContador+1));
					return -1;
				}
			}
			if (document.getElementById('M'+iContador+'N').length > 0)
			{
				if (iComprobar_Entero(document.getElementById('M'+iContador+'N').value,5) == -1)
				{
					alert(iObtener_Cadena_AJAX("error_gw76")+" "+(iContador+1));
					return -1;
				}
			}				
			if(document.getElementById('A'+iContador+'U').value.length > 0 &&
			  (document.getElementById('M'+iContador+'X').value.length == 0 || document.getElementById('M'+iContador+'N').value.length == 0 || document.getElementById('M'+iContador+'X').value.length == 0))
			{
					alert(iObtener_Cadena_AJAX("error_gw78"));
					return -1;				
			}	
			if(document.getElementById('A'+iContador+'L').value.length > 0 &&
			  (document.getElementById('M'+iContador+'X').value.length == 0 || document.getElementById('M'+iContador+'N').value.length == 0 || document.getElementById('M'+iContador+'X').value.length == 0))
			{
					alert(iObtener_Cadena_AJAX("error_gw78"));
					return -1;				
			}				
		}	
		if(iContador < 7)
		{
			if(iContador < 3)
			{
				sPrefijo = 'S';
				iNumSensor = iContador;
			}
			else
			{
				sPrefijo = 'A';
				iNumSensor = iContador-3;
			}
			if (document.getElementById('A'+iContador+'T').value.length > 0)
			{			
				if (iComprobar_Entero(document.getElementById('A'+iContador+'T').value,9) == -1)
				{
					alert(iObtener_Cadena_AJAX("error_gw37")+" "+sPrefijo+(iNumSensor+1));
					return -1;
				}
			}
			if (document.getElementById('A'+iContador+'W').value.length > 0)
			{				
				if (iComprobar_Entero(document.getElementById('A'+iContador+'W').value,9) == -1)
				{
					alert(iObtener_Cadena_AJAX("error_gw38")+" "+sPrefijo+(iNumSensor+1));
					return -1;
				}
			}
			if (document.getElementById('A'+iContador+'M').value.length > 0)
			{				
				if (iComprobar_Entero(document.getElementById('A'+iContador+'M').value,9) == -1)
				{
					alert(iObtener_Cadena_AJAX("error_gw39")+" "+sPrefijo+(iNumSensor+1));
					return -1;
				}
			}
			if (document.getElementById('A'+iContador+'N').value.length > 0)
			{			
				if (iComprobar_Entero(document.getElementById('A'+iContador+'N').value,9) == -1)
				{
					alert(iObtener_Cadena_AJAX("error_gw40")+" "+sPrefijo+(iNumSensor+1));
					return -1;
				}
			}
			if (document.getElementById('A'+iContador+'U').value.length > 0)
			{			
				if (iComprobar_Decimal(document.getElementById('A'+iContador+'U').value,9) == -1)
				{
					alert(iObtener_Cadena_AJAX("error_gw42")+" "+sPrefijo+(iNumSensor+1));
					return -1;
				}
			}
			if (document.getElementById('A'+iContador+'L').value.length > 0)
			{			
				if (iComprobar_Decimal(document.getElementById('A'+iContador+'L').value,9) == -1)
				{
					alert(iObtener_Cadena_AJAX("error_gw43")+" "+sPrefijo+(iNumSensor+1));
					return -1;
				}
			}
			//AMB 13/09/12 Comprobamos que el tiempo de warming no sea mayor que el de medida
			if (parseInt(document.getElementById('A'+iContador+'T').value) != 0 && parseInt(document.getElementById('A'+iContador+'T').value)*60 <= parseInt(document.getElementById('A'+iContador+'W').value))
			{
				alert(iObtener_Cadena_AJAX("error_gw77")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
			if((document.getElementById('A'+iContador+'U').value.length > 0) &&
			   (document.getElementById('A'+iContador+'K').value.length == 0))
			{
					alert(iObtener_Cadena_AJAX("error_gw79"));
					return -1;				
			}			
			if((document.getElementById('A'+iContador+'L').value.length > 0) &&
			   (document.getElementById('A'+iContador+'K').value.length == 0))
			{
					alert(iObtener_Cadena_AJAX("error_gw79"));
					return -1;				
			}							
		}
		if(iContador < 9)
		{
			sPrefijo = 'C';
			iNumSensor = iContador;
		}
		else
		{
			sPrefijo = 'D';
			iNumSensor = iContador-2;
		}			
		if (document.getElementById('D'+iContador+'T').value.length > 0)
		{		
			if (iComprobar_Entero(document.getElementById('D'+iContador+'T').value,9) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw49")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
		}
		if (document.getElementById('D'+iContador+'U').value.length > 0)
		{		
			if (iComprobar_Decimal(document.getElementById('D'+iContador+'U').value,9) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw50")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
		}
	}
	if (document.getElementById('DAT').value.length > 0)
	{		
		if (iComprobar_Entero(document.getElementById('DAT').value,9) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw49")+" A");
			return -1;
		}
	}
	if (document.getElementById('DAU').value.length > 0)
	{		
		if (iComprobar_Decimal(document.getElementById('DAU').value,9) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw50")+" A");
			return -1;
		}
	}
	if (document.getElementById('DBT').value.length > 0)
	{		
		if (iComprobar_Entero(document.getElementById('DBT').value,9) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw49")+" B");
			return -1;
		}
	}
	if (document.getElementById('DBU').value.length > 0)
	{		
		if (iComprobar_Decimal(document.getElementById('DBU').value,9) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw50")+" B");
			return -1;
		}
	}
	if (document.getElementById('DCT').value.length > 0)
	{		
		if (iComprobar_Entero(document.getElementById('DCT').value,9) == -1)
		{
			//alert(iObtener_Cadena_AJAX("error_gw49")+" C");
			alert(iObtener_Cadena_AJAX("error_gw49")+" 1");
			return -1;
		}
	}
	if (document.getElementById('DCU').value.length > 0)
	{		
		if (iComprobar_Decimal(document.getElementById('DCU').value,9) == -1)
		{
			//alert(iObtener_Cadena_AJAX("error_gw50")+" C");
			alert(iObtener_Cadena_AJAX("error_gw50")+" 1");
			return -1;
		}
	}
	if (document.getElementById('DDT').value.length > 0)
	{		
		if (iComprobar_Entero(document.getElementById('DDT').value,9) == -1)
		{
			//alert(iObtener_Cadena_AJAX("error_gw49")+" D");
			alert(iObtener_Cadena_AJAX("error_gw49")+" 2");
			return -1;
		}
	}
	if (document.getElementById('DDU').value.length > 0)
	{		
		if (iComprobar_Decimal(document.getElementById('DDU').value,9) == -1)
		{
			//alert(iObtener_Cadena_AJAX("error_gw50")+" D");
			alert(iObtener_Cadena_AJAX("error_gw50")+" 2");
			return -1;
		}
	}
	if (document.getElementById('DET').value.length > 0)
	{		
		if (iComprobar_Entero(document.getElementById('DET').value,9) == -1)
		{
			//alert(iObtener_Cadena_AJAX("error_gw49")+" E");
			alert(iObtener_Cadena_AJAX("error_gw49")+" 3");
			return -1;
		}
	}
	if (document.getElementById('DEU').value.length > 0)
	{				
		if (iComprobar_Decimal(document.getElementById('DEU').value,9) == -1)
		{
			//alert(iObtener_Cadena_AJAX("error_gw50")+" E");
			alert(iObtener_Cadena_AJAX("error_gw50")+" 3");
			return -1;
		}
	}
	if (document.getElementById('DFT').value.length > 0)
	{		
		if (iComprobar_Entero(document.getElementById('DFT').value,9) == -1)
		{
			//alert(iObtener_Cadena_AJAX("error_gw49")+" F");
			alert(iObtener_Cadena_AJAX("error_gw49")+" 4");
			return -1;
		}
	}
	if (document.getElementById('DFU').value.length > 0)
	{		
		if (iComprobar_Decimal(document.getElementById('DFU').value,9) == -1)
		{
			//alert(iObtener_Cadena_AJAX("error_gw50")+" F");
			alert(iObtener_Cadena_AJAX("error_gw50")+" 4");
			return -1;
		}
	}
	return 0;
}
function iComprobar_Todos_Valores()
{
	if (document.getElementById('NGW').value.length > 20)
	{
		alert(iObtener_Cadena_AJAX("error_gw1"));
		return -1;
	}
	else if (iComprobar_Nombre(document.getElementById('NGW').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw2"));
		return -1;
	}
	if (iComprobar_KEY(document.getElementById('KEY').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw3"));
		return -1;
	}
	if (document.getElementById('DHP').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw4"));
		return -1;
	}
	if (iComprobar_IP(document.getElementById('IPP').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw5"));
		return -1;
	}
	if (iComprobar_IP(document.getElementById('MSK').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw6"));
		return -1;
	}
	if (iComprobar_IP(document.getElementById('PDE').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw7"));
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('TPP').value,3) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw8"));
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('ITC').value,3) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw9"));
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('ITP').value,5) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw35"));
		return -1;
	}
	if (document.getElementById('HPS').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw10"));
		return -1;
	}	
	if (document.getElementById('TCH').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw11"));
		return -1;
	}
	
	if (document.getElementById('MTP').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw34"));
		return -1;
	}
	
	if (iComprobar_IP(document.getElementById('IPX').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw12"));
		return -1;
	}
	if (iComprobar_IP(document.getElementById('IPY').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw13"));
		return -1;
	}
	if (iComprobar_Port(document.getElementById('PRX').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw14"));
		return -1;
	}
	if (iComprobar_Port(document.getElementById('PRY').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw15"));
		return -1;
	}
	if (iComprobar_Port(document.getElementById('PGT').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw16"));
		return -1;
	}
	if (iComprobar_Port(document.getElementById('PGU').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw17"));
		return -1;
	}
	if (document.getElementById('GPH').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw18"));
		return -1;
	}
	if (iComprobar_IP(document.getElementById('IPW').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw19"));
		return -1;
	}
	if (iComprobar_IP(document.getElementById('IPZ').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw20"));
		return -1;
	}
	if (document.getElementById('GSH').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw23"));
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('GSX').value,11) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw21"));
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('GSY').value,11) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw22"));
		return -1;
	}			

	for (iContador = 1; iContador < 10; iContador++)
	{
		iTSTemp = iObtener_TSGW_Select("TS"+iContador);
		if (iTSTemp == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw24")+" "+iContador);
			return -1;
		}
		
		if (iComprobar_Entero(document.getElementById('T'+iContador+'M').value,9) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw25")+" "+iContador);
			return -1;
		}
		if (iComprobar_Entero(document.getElementById('T'+iContador+'S').value,9) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw26")+" "+iContador);
			return -1;
		}
		if (iComprobar_Decimal(document.getElementById('P'+iContador+'X').value,9) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw27")+" "+iContador);
			return -1;
		}
		if (iComprobar_Decimal(document.getElementById('P'+iContador+'N').value,9) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw28")+" "+iContador);
			return -1;
		}
		
		if (document.getElementById("EH"+iContador).selectedIndex==-1)
		{
			alert(iObtener_Cadena_AJAX("error_gw29")+" "+iContador);
			return -1;
		}
		
		if (document.getElementById("SH"+iContador).selectedIndex==-1)
		{
			alert(iObtener_Cadena_AJAX("error_gw30")+" "+iContador);
			return -1;
		}
		iTSTemp = iObtener_TSGW_Select("TS"+iContador);
		if (iTSTemp == 14)
		{
			if (document.getElementById('M'+iContador+'X').length > 0)
			{	
				if (iComprobar_Decimal(document.getElementById('M'+iContador+'X').value,4) == -1)
				{
					alert(iObtener_Cadena_AJAX("error_gw75")+" "+(iContador+1));
					return -1;
				}
			}
			if (document.getElementById('M'+iContador+'N').length > 0)
			{
				if (iComprobar_Decimal(document.getElementById('M'+iContador+'N').value,4) == -1)
				{
					alert(iObtener_Cadena_AJAX("error_gw76")+" "+(iContador+1));
					return -1;
				}
			}				
			if(document.getElementById('P'+iContador+'N').value.length > 0 &&
			  (document.getElementById('M'+iContador+'X').value.length == 0 
			  || document.getElementById('M'+iContador+'N').value.length == 0))
			{
					alert(iObtener_Cadena_AJAX("error_gw78"));
					return -1;				
			}
			if(document.getElementById('P'+iContador+'X').value.length > 0 &&
			  (document.getElementById('M'+iContador+'X').value.length == 0 
			  || document.getElementById('M'+iContador+'N').value.length == 0))
			{
					alert(iObtener_Cadena_AJAX("error_gw78"));
					return -1;				
			}	
		}		
	}
	if (document.getElementById('HMR').selectedIndex == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw80"));
		return -1;
	}
	return 0;
}
function iComprobar_Todos_Valores_Low()
{
	if (document.getElementById('NGW').value.length > 20)
	{
		alert(iObtener_Cadena_AJAX("error_gw1"));
		return -1;
	}
	else if (iComprobar_Nombre(document.getElementById('NGW').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw2"));
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('CTA').value,5) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw9"));
		return -1;
	}
	if (iComprobar_IP(document.getElementById('CIS').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw12"));
		return -1;
	}
	if (iComprobar_IP(document.getElementById('CID').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw13"));
		return -1;
	}
	if (iComprobar_Port(document.getElementById('CIP').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw73"));
		return -1;
	}
	if (iComprobar_Port(document.getElementById('CIT').value) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw74"));
		return -1;
	}
				

	for (iContador = 0; iContador < 10; iContador++)
	{
		if(iContador < 3)
		{
			if (iComprobar_Entero(document.getElementById('M'+iContador+'X').value,5) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw75")+" "+(iContador+1));
				return -1;
			}
			if (iComprobar_Entero(document.getElementById('M'+iContador+'N').value,5) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw76")+" "+(iContador+1));
				return -1;
			}			
		}
		if(iContador < 7)
		{
			if(iContador < 3)
			{
				sPrefijo = 'S';
				iNumSensor = iContador;
			}
			else
			{
				sPrefijo = 'A';
				iNumSensor = iContador-3;
			}			
			// Primero de todo, guardamos el tipo de sensor
			if (document.getElementById("A"+iContador+"K").selectedIndex==-1)
			{
				alert(iObtener_Cadena_AJAX("error_gw36")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
			
			if (iComprobar_Entero(document.getElementById('A'+iContador+'T').value,9) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw37")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
			if (iComprobar_Entero(document.getElementById('A'+iContador+'W').value,9) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw38")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
			if (iComprobar_Entero(document.getElementById('A'+iContador+'M').value,9) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw39")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
			if (iComprobar_Entero(document.getElementById('A'+iContador+'N').value,9) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw40")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
			if (document.getElementById("A"+iContador+"P").selectedIndex==-1)
			{
				alert(iObtener_Cadena_AJAX("error_gw41")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
			if (iComprobar_Decimal(document.getElementById('A'+iContador+'U').value,9) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw42")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
			if (iComprobar_Decimal(document.getElementById('A'+iContador+'L').value,9) == -1)
			{
				alert(iObtener_Cadena_AJAX("error_gw43")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
			
			if (document.getElementById("EH"+iContador).selectedIndex==-1)
			{
				alert(iObtener_Cadena_AJAX("error_gw44")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
			
			if (document.getElementById("SH"+iContador).selectedIndex==-1)
			{
				alert(iObtener_Cadena_AJAX("error_gw45")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}
			//AMB 13/09/12 Comprobamos que el tiempo de warming no sea mayor que el de medida
			if (parseInt(document.getElementById('A'+iContador+'T').value) != 0 && parseInt(document.getElementById('A'+iContador+'T').value)*60 <= parseInt(document.getElementById('A'+iContador+'W').value))
			{
				alert(iObtener_Cadena_AJAX("error_gw77")+" "+sPrefijo+(iNumSensor+1));
				return -1;
			}				
		}
		else
		{
			if (document.getElementById("EH"+iContador).selectedIndex==-1)
			{
				alert(iObtener_Cadena_AJAX("error_gw46")+" "+(iNumSensor-7));
				return -1;
			}
			
			if (document.getElementById("SH"+iContador).selectedIndex==-1)
			{
				alert(iObtener_Cadena_AJAX("error_gw47")+" "+(iNumSensor-7));
				return -1;
			}
		}
		if(iContador < 2)
		{
			sPrefijo = 'C';
			iNumSensor = iContador+1;
		}
		else
		{
			sPrefijo = 'D';
			iNumSensor = iContador-2;
		}			
		if (document.getElementById("D"+iContador+"K").selectedIndex==-1)
		{
			alert(iObtener_Cadena_AJAX("error_gw48")+" "+sPrefijo+iNumSensor);
			return -1;
		}
		
		if (iComprobar_Entero(document.getElementById('D'+iContador+'T').value,9) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw49")+" "+sPrefijo+iNumSensor);
			return -1;
		}
		if (iComprobar_Decimal(document.getElementById('D'+iContador+'U').value,9) == -1)
		{
			alert(iObtener_Cadena_AJAX("error_gw50")+" "+sPrefijo+iNumSensor);
			return -1;
		}
			
	}
	
	if (document.getElementById("DAK").selectedIndex==-1)
	{
		alert(iObtener_Cadena_AJAX("error_gw48")+" A");
		return -1;
	}
	
	if (iComprobar_Entero(document.getElementById('DAT').value,9) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw49")+" A");
		return -1;
	}
	if (iComprobar_Decimal(document.getElementById('DAU').value,9) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw50")+" A");
		return -1;
	}
	
	if (document.getElementById("DBK").selectedIndex==-1)
	{
		alert(iObtener_Cadena_AJAX("error_gw48")+" B");
		return -1;
	}
	
	if (iComprobar_Entero(document.getElementById('DBT').value,9) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw49")+" B");
		return -1;
	}
	if (iComprobar_Decimal(document.getElementById('DBU').value,9) == -1)
	{
		alert(iObtener_Cadena_AJAX("error_gw50")+" B");
		return -1;
	}
	
	if (document.getElementById("DCK").selectedIndex==-1)
	{
		//alert(iObtener_Cadena_AJAX("error_gw48")+" C");
		alert(iObtener_Cadena_AJAX("error_gw48")+" 1");
		return -1;
	}
	
	if (iComprobar_Entero(document.getElementById('DCT').value,9) == -1)
	{
		//alert(iObtener_Cadena_AJAX("error_gw49")+" C");
		alert(iObtener_Cadena_AJAX("error_gw49")+" 1");
		return -1;
	}
	if (iComprobar_Decimal(document.getElementById('DCU').value,9) == -1)
	{
		//alert(iObtener_Cadena_AJAX("error_gw50")+" C");
		alert(iObtener_Cadena_AJAX("error_gw50")+" 1");
		return -1;
	}
	
	if (document.getElementById("DDK").selectedIndex==-1)
	{		
		//alert(iObtener_Cadena_AJAX("error_gw48")+" D");
		alert(iObtener_Cadena_AJAX("error_gw48")+" 2");
		return -1;
	}
	
	if (iComprobar_Entero(document.getElementById('DDT').value,9) == -1)
	{
		//alert(iObtener_Cadena_AJAX("error_gw49")+" D");
		alert(iObtener_Cadena_AJAX("error_gw49")+" 2");
		return -1;
	}
	if (iComprobar_Decimal(document.getElementById('DDU').value,9) == -1)
	{
		//alert(iObtener_Cadena_AJAX("error_gw50")+" D");
		alert(iObtener_Cadena_AJAX("error_gw50")+" 2");
		return -1;
	}
	
	if (document.getElementById("DEK").selectedIndex==-1)
	{
		//alert(iObtener_Cadena_AJAX("error_gw48")+" E");
		alert(iObtener_Cadena_AJAX("error_gw48")+" 3");
		return -1;
	}
	
	if (iComprobar_Entero(document.getElementById('DET').value,9) == -1)
	{
		//alert(iObtener_Cadena_AJAX("error_gw49")+" E");
		alert(iObtener_Cadena_AJAX("error_gw49")+" 3");
		return -1;
	}
	if (iComprobar_Decimal(document.getElementById('DEU').value,9) == -1)
	{
		//alert(iObtener_Cadena_AJAX("error_gw50")+" E");
		alert(iObtener_Cadena_AJAX("error_gw50")+" 3");
		return -1;
	}
	
	if (document.getElementById("DFK").selectedIndex==-1)
	{
		//alert(iObtener_Cadena_AJAX("error_gw48")+" F");
		alert(iObtener_Cadena_AJAX("error_gw48")+" 4");
		return -1;
	}
	
	if (iComprobar_Entero(document.getElementById('DFT').value,9) == -1)
	{
		//alert(iObtener_Cadena_AJAX("error_gw49")+" F");
		alert(iObtener_Cadena_AJAX("error_gw49")+" 4");
		return -1;
	}
	if (iComprobar_Decimal(document.getElementById('DFU').value,9) == -1)
	{
		//alert(iObtener_Cadena_AJAX("error_gw50")+" F");
		alert(iObtener_Cadena_AJAX("error_gw50")+" 4");
		return -1;
	}
	
	for(iContador=10 ; iContador < 23; iContador++)
	{
		if (document.getElementById("EH"+iContador).selectedIndex==-1)
		{
			alert(iObtener_Cadena_AJAX("error_gw46")+" "+(iContador));
			return -1;
		}
		
		if (document.getElementById("SH"+iContador).selectedIndex==-1)
		{
			alert(iObtener_Cadena_AJAX("error_gw47")+" "+(iContador));
			return -1;
		}
	}
	
	return 0;
}

function iComprobar_Todos_Valores_LowT()
{
	if (document.getElementById('NGW').value.length > 20)
	{
		alert('El Nombre del Concentrador es demasiado largo');
		return -1;
	}
	else if (iComprobar_Nombre(document.getElementById('NGW').value) == -1)
	{
		alert('El Nombre del Concentrador contiene caracteres inválidos');
		return -1;
	}
	if (document.getElementById('TEA').selectedIndex == -1)
	{
		alert('Valor de Habilitación de Funcionalidad inválido');
		return -1;
	}
	if (iComprobar_IP(document.getElementById('G03').value) == -1)
	{
		alert('Valor de IP Servidor Primario inválido');
		return -1;
	}
	if (iComprobar_IP(document.getElementById('G04').value) == -1)
	{
		alert('Valor de IP Servidor Secundario inválido');
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('PSV').value,3) == -1)
	{
		alert('Valor de Tiempo de Permanencia en Bajo Consumo inválido');
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('TEB').value,3) == -1)
	{
		alert('Valor de Retardo de Pulso de Enclavamiento inválido');
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('NEN').value,3) == -1)
	{
		alert('Valor de Retardo de Tramas de Control inválido');
		return -1;
	}		
	if (document.getElementById('GPH').selectedIndex == -1)
	{
		alert('Valor de Habilitación GPRS inválido');
		return -1;
	}
	if (document.getElementById('GSH').selectedIndex == -1)
	{
		alert('Valor de Habilitación GSM inválido');
		return -1;
	}
	if (document.getElementById('USE').selectedIndex == -1)
	{
		alert('Valor de Habilitación USB inválido');
		return -1;
	}
	if (document.getElementById('OPE').selectedIndex == -1)
	{
		alert('Valor de Habilitación USB inválido');
		return -1;
	}
	if (iComprobar_Port(document.getElementById('PGR').value) == -1)
	{
		alert('Valor de Puerto TCP Concentrador inválido');
		return -1;
	}
	if (iComprobar_Port(document.getElementById('PRR').value) == -1)
	{
		alert('Valor de Puerto TCP Servidor inválido');
		return -1;
	}
	if (document.getElementById('CNS').selectedIndex == -1)
	{
		alert('Valor de Habilitación de Captura No Selectiva inválido');
		return -1;
	}
	if (document.getElementById('HOIH').selectedIndex == -1)
	{
		alert('Valor de Hora de Inicio de Envío inválido');
		return -1;
	}	
	if (document.getElementById('HOIM').selectedIndex == -1)
	{
		alert('Valor de Minutos de Inicio de Envío inválido');
		return -1;
	}
	if (document.getElementById('ITCH').selectedIndex == -1)
	{
		alert('Valor de Hora de Periodo de Envío inválido');
		return -1;
	}	
	if (document.getElementById('ITCM').selectedIndex == -1)
	{
		alert('Valor de Minutos de Periodo de Envío inválido');
		return -1;
	}

	for (iContador = 1; iContador < 7; iContador++)
	{
		// Primero de todo, guardamos el tipo de sensor
		if (document.getElementById("TI"+iContador).selectedIndex==-1)
		{
			alert('Valor de Tipo de Sensor '+iContador+' inválido');
			return -1;
		}
		
		if (iComprobar_Entero(document.getElementById('TM'+iContador).value,5) == -1)
		{
			alert('Valor de Tiempo de Medida del Sensor '+iContador+' inválido');
			return -1;
		}
		if (iComprobar_Entero(document.getElementById('TE'+iContador).value,5) == -1)
		{
			alert('Valor de Tiempo de Envio del Sensor '+iContador+' inválido');
			return -1;
		}
		
		if (document.getElementById("AS"+iContador).selectedIndex==-1)
		{
			alert('Valor de Tipo de Alimentación '+iContador+' inválido');
			return -1;
		}
		if (document.getElementById("EH"+iContador).selectedIndex==-1)
		{
			alert('Valor de Notificación de Email '+iContador+' inválido');
			return -1;
		}
	}
	if (iComprobar_Decimal(document.getElementById('UM3').value,5) == -1)
	{
		alert('Valor de Umbral Máximo del Sensor Analogico 1 inválido');
		return -1;
	}
	if (iComprobar_Decimal(document.getElementById('UN3').value,5) == -1)
	{
		alert('Valor de Umbral Mínimo del Sensor Analogico 1 inválido');
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('GM3').value,5) == -1)
	{
		alert('Valor de Gradiente del Sensor Analogico 1 inválido');
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('TG3').value,5) == -1)
	{
		alert('Valor de Tiempo de Envio de Gradiente del Sensor Analogico 1 inválido');
		return -1;
	}
	if (iComprobar_Decimal(document.getElementById('UM4').value,5) == -1)
	{
		alert('Valor de Umbral Máximo del Sensor Analogico 2 inválido');
		return -1;
	}
	if (iComprobar_Decimal(document.getElementById('UN4').value,5) == -1)
	{
		alert('Valor de Umbral Mínimo del Sensor Analogico 2 inválido');
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('GM4').value,5) == -1)
	{
		alert('Valor de Gradiente del Sensor Analogico 2 inválido');
		return -1;
	}
	if (iComprobar_Entero(document.getElementById('TG4').value,5) == -1)
	{
		alert('Valor de Tiempo de Envio de Gradiente del Sensor Analogico 2 inválido');
		return -1;
	}
	return 0;
}

function vActualizar_Unidades(iNumeroCombo)
{
	iTSTemp = iObtener_TSGW_Select("TS"+iNumeroCombo);
	switch (iTSTemp)
	{
		case 6:
			document.getElementById('P'+iNumeroCombo+'X_unit').innerHTML="%";
			document.getElementById('P'+iNumeroCombo+'N_unit').innerHTML="%";
			break;
		case 7:
			document.getElementById('P'+iNumeroCombo+'X_unit').innerHTML="mm";
			document.getElementById('P'+iNumeroCombo+'N_unit').innerHTML="mm";
			break;
		case 8:
			document.getElementById('P'+iNumeroCombo+'X_unit').innerHTML="km/h";
			document.getElementById('P'+iNumeroCombo+'N_unit').innerHTML="km/h";
			break;
		case 9:
			document.getElementById('P'+iNumeroCombo+'X_unit').innerHTML="º";
			document.getElementById('P'+iNumeroCombo+'N_unit').innerHTML="º";
			break;
		case 10:
			document.getElementById('P'+iNumeroCombo+'X_unit').innerHTML="ºC";
			document.getElementById('P'+iNumeroCombo+'N_unit').innerHTML="ºC";
			break;
		case 11:
			document.getElementById('P'+iNumeroCombo+'X_unit').innerHTML="W/m2";
			document.getElementById('P'+iNumeroCombo+'N_unit').innerHTML="W/m2";
			break;
		case 15:			
			document.getElementById('P'+iNumeroCombo+'X_unit').innerHTML="mm";
			document.getElementById('P'+iNumeroCombo+'N_unit').innerHTML="mm";		
			break;			
		case 0:
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 12:
		case 13:
		case 14:
		case 16:
		case 17:
		case 18:
		case 19:
		default:
			document.getElementById('P'+iNumeroCombo+'X_unit').innerHTML="";
			document.getElementById('P'+iNumeroCombo+'N_unit').innerHTML="";
			break; 
	}
	iTSTemp = iObtener_TSGW_Select("TS"+iNumeroCombo);
	if ((iTSTemp == 16)
		|| (iTSTemp == 2)
		|| (iTSTemp == 21)
		|| (iTSTemp == 22)
		|| (iTSTemp == 23)
		|| (iTSTemp == 24)
		|| (iTSTemp == 25)
		|| (iTSTemp == 26))
	{
		$('#M'+iNumeroCombo+'X').attr("class", 'texto_valores mostrado');
		$('#M'+iNumeroCombo+'N').attr("class", 'texto_valores mostrado');
		$('#U'+iNumeroCombo+'D').attr("class", 'texto_valores mostrado');
		$('#offset'+iNumeroCombo).attr("class", 'mostrado');
		$('#pendiente'+iNumeroCombo).attr("class", 'mostrado');
		$('#unidad'+iNumeroCombo).attr("class", 'mostrado');
				
		document.getElementById('M'+iNumeroCombo+'X').disabled=false;
		document.getElementById('M'+iNumeroCombo+'N').disabled=false;
		document.getElementById('U'+iNumeroCombo+'D').disabled=false;
		document.getElementById('offset'+iNumeroCombo).disabled=false;
		document.getElementById('pendiente'+iNumeroCombo).disabled=false;
		document.getElementById('unidad'+iNumeroCombo).disabled=false;	
	}
	else
	{
		$('#M'+iNumeroCombo+'X').attr("class", 'texto_valores escondido');
		$('#M'+iNumeroCombo+'N').attr("class", 'texto_valores escondido');
		$('#U'+iNumeroCombo+'D').attr("class", 'texto_valores escondido');
		$('#offset'+iNumeroCombo).attr("class", 'escondido');
		$('#pendiente'+iNumeroCombo).attr("class", 'escondido');
		$('#unidad'+iNumeroCombo).attr("class", 'escondido');

		document.getElementById('M'+iNumeroCombo+'X').disabled=true;
		document.getElementById('M'+iNumeroCombo+'N').disabled=true;
		document.getElementById('U'+iNumeroCombo+'D').disabled=true;
		document.getElementById('offset'+iNumeroCombo).disabled=true;
		document.getElementById('pendiente'+iNumeroCombo).disabled=true;
		document.getElementById('unidad'+iNumeroCombo).disabled=true;						
	}
}
function vActualizar_Unidades_lowA(iNumeroCombo)
{	
	switch (document.getElementById('A'+iNumeroCombo+'K').options[document.getElementById('A'+iNumeroCombo+'K').selectedIndex].id)
	{		
		case '30':
		case '37':
		case '38':
		case '39':
		case '40':			
			document.getElementById('A'+iNumeroCombo+'U_unit').innerHTML="%";
			document.getElementById('A'+iNumeroCombo+'L_unit').innerHTML="%";
			break;
		case '33':
		case '43':
		case '41':
			document.getElementById('A'+iNumeroCombo+'U_unit').innerHTML="º";
			document.getElementById('A'+iNumeroCombo+'L_unit').innerHTML="º";
			break;
		case '31':
			document.getElementById('A'+iNumeroCombo+'U_unit').innerHTML="ºC";
			document.getElementById('A'+iNumeroCombo+'L_unit').innerHTML="ºC";
			break;
		case '32':
		case '44':		
			document.getElementById('A'+iNumeroCombo+'U_unit').innerHTML="W/m2";
			document.getElementById('A'+iNumeroCombo+'L_unit').innerHTML="W/m2";
			break;
		case '42':		
			document.getElementById('A'+iNumeroCombo+'U_unit').innerHTML="m/s";
			document.getElementById('A'+iNumeroCombo+'L_unit').innerHTML="m/s";
			break;
		case '45':		
			document.getElementById('A'+iNumeroCombo+'U_unit').innerHTML="pH";
			document.getElementById('A'+iNumeroCombo+'L_unit').innerHTML="pH";
			break;
		case '46':		
			document.getElementById('A'+iNumeroCombo+'U_unit').innerHTML="uS/cm";
			document.getElementById('A'+iNumeroCombo+'L_unit').innerHTML="uS/cm";
			break;
		case '0':
		case '6':
		default:
			document.getElementById('A'+iNumeroCombo+'U_unit').innerHTML="";
			document.getElementById('A'+iNumeroCombo+'L_unit').innerHTML="";
			break;
	}
}

function vActualizar_Unidades_lowD(iNumeroCombo)
{	

	switch (document.getElementById('D'+iNumeroCombo+'K').options[document.getElementById('D'+iNumeroCombo+'K').selectedIndex].id)
	{		
		case '8':
			document.getElementById('D'+iNumeroCombo+'U_unit').innerHTML="mm";
			break;
		case '34':		
			document.getElementById('D'+iNumeroCombo+'U_unit').innerHTML="km/h";
			break;			
		default:
			document.getElementById('D'+iNumeroCombo+'U_unit').innerHTML="";
			break; 
	}	
}
function vActualizar_Unidades_LowT(iNumeroCombo)
{
	switch (document.getElementById('TI'+iNumeroCombo).selectedIndex)
	{
		
		case "AN1":
			document.getElementById('UN'+iNumeroCombo+'_unit').innerHTML="V";
			document.getElementById('UM'+iNumeroCombo+'_unit').innerHTML="V";
			break;
		default:
			document.getElementById('UN'+iNumeroCombo+'_unit').innerHTML="";
			document.getElementById('UM'+iNumeroCombo+'_unit').innerHTML="";
			break; 
	}
}
function sPrepararCadenaGW(suscriptor, caVersionHWIN)
{
	var iContador;
	var sTipoSensAux;
	var sCadenaParams;
	
	if (suscriptor!="NO")
	{
		sCadenaParams = "SUS"+suscriptor+";";
	}
	else
	{
		sCadenaParams='';
	}
		
	if ((document.getElementById('VHW')) && (document.getElementById('VHW').selectedIndex >= 0))
	{
		sCadenaParams += "VHW" + document.getElementById('VHW').options[document.getElementById('VHW').selectedIndex].id + ";";
	}
	if ((document.getElementById('VSW')) && (document.getElementById('VSW').selectedIndex >= 0))
	{
		sCadenaParams += "VSW" + document.getElementById('VSW').options[document.getElementById('VSW').selectedIndex].id + ";";
	}
	
	sCadenaParams += "TCH"+document.getElementById('TCH').selectedIndex+";";
	sCadenaParams += "DHP"+document.getElementById('DHP').selectedIndex+";";
	sCadenaParams += "HMR"+document.getElementById('HMR').selectedIndex+";";
	sCadenaParams += "IPX" + document.getElementById('IPX').value+";";
	sCadenaParams += "IPY" + document.getElementById('IPY').value+";";
	sCadenaParams += "PRX" + document.getElementById('PRX').value+";";
	sCadenaParams += "PRY" + document.getElementById('PRY').value+";";
	sCadenaParams += "ITC" + document.getElementById('ITC').value+";";
	sCadenaParams += "PGT" + document.getElementById('PGT').value+";";
	sCadenaParams += "PGU" + document.getElementById('PGU').value+";";
	sCadenaParams += "IPP" + document.getElementById('IPP').value+";";
	sCadenaParams += "MSK" + document.getElementById('MSK').value+";";
	sCadenaParams += "PDE" + document.getElementById('PDE').value+";";
	sCadenaParams += "TPP" + document.getElementById('TPP').value+";";
	sCadenaParams += "GPH"+document.getElementById('GPH').selectedIndex+";";
	sCadenaParams += "IPW" + document.getElementById('IPW').value+";";
	sCadenaParams += "IPZ" + document.getElementById('IPZ').value+";";
	sCadenaParams += "GSH"+document.getElementById('GSH').selectedIndex+";";
	sCadenaParams += "GSX" + document.getElementById('GSX').value+";";
	sCadenaParams += "GSY" + document.getElementById('GSY').value+";";
	sCadenaParams += "KEY" + document.getElementById('KEY').value+";";
	
	sCadenaParams += "MTP"+document.getElementById('MTP').selectedIndex+";";
	sCadenaParams += "ITP" + document.getElementById('ITP').value+";";

	for (iContador = 1; iContador < 10; iContador++)
	{
		iTSTemp = iObtener_TSGW_Select("TS"+iContador);
		if (iTSTemp == -1)
		{
			sTipoSensAux = "0";
		}
		else
		{
			sTipoSensAux = iTSTemp;
		}
		sCadenaParams += "T"+iContador+"M" + document.getElementById('T'+iContador+'M').value+";";
		sCadenaParams += "T"+iContador+"S" + document.getElementById('T'+iContador+'S').value+";";
		sCadenaParams += "P"+iContador+"X" + sConvertir_Inversa_Datos_Sensor_GW(document.getElementById('P'+iContador+'X').value, parseInt(sTipoSensAux), document.getElementById('M'+iContador+'X').value, document.getElementById('M'+iContador+'N').value, caVersionHWIN)+";";
		sCadenaParams += "P"+iContador+"N" + sConvertir_Inversa_Datos_Sensor_GW(document.getElementById('P'+iContador+'N').value, parseInt(sTipoSensAux), document.getElementById('M'+iContador+'X').value, document.getElementById('M'+iContador+'N').value, caVersionHWIN)+";";
		sCadenaParams += "M"+iContador+"X" + document.getElementById('M'+iContador+'X').value+";";
		sCadenaParams += "M"+iContador+"N" + document.getElementById('M'+iContador+'N').value+";";
		sCadenaParams += "U"+iContador+"D" + document.getElementById('U'+iContador+'D').selectedIndex+";";
		sCadenaParams += "TS"+iContador+sTipoSensAux+";";
		if (document.getElementById("EH"+iContador).selectedIndex!=-1)
		{
			sCadenaParams += "EH"+iContador + document.getElementById('EH'+iContador).selectedIndex+";";
		}
		else
		{
			sCadenaParams += "EH"+iContador + "0;";
		}
		if (document.getElementById("SH"+iContador).selectedIndex!=-1)
		{
			sCadenaParams += "SH"+iContador + document.getElementById('SH'+iContador).selectedIndex+";";
		}
		else
		{
			sCadenaParams += "SH"+iContador + "0;";
		}
		sCadenaParams += "SN"+iContador + document.getElementById('SN'+iContador).value+";";
	}
	sCadenaParams += "FLG0;";
	sCadenaParams += "HPS"+document.getElementById('HPS').selectedIndex+";";
	sCadenaParams += "S1X";
	for (iContador = 1; iContador < 4; iContador++)
	{
		if (document.getElementById('MAXS1O'+iContador).checked)
		{
			sCadenaParams += "1";
		}
		else
		{
			sCadenaParams += "0";
		}
	}
	sCadenaParams += ";";
	sCadenaParams += "S1N";
	for (iContador = 1; iContador < 4; iContador++)
	{
		if (document.getElementById('MINS1O'+iContador).checked)
		{
			sCadenaParams += "1";
		}
		else
		{
			sCadenaParams += "0";
		}
	}				
	sCadenaParams += ";";	
	sCadenaParams += "S2X";
	for (iContador = 1; iContador < 4; iContador++)
	{
		if (document.getElementById('MAXS2O'+iContador).checked)
		{
			sCadenaParams += "1";
		}
		else
		{
			sCadenaParams += "0";
		}
	}
	sCadenaParams += ";";
	sCadenaParams += "S2N";
	for (iContador = 1; iContador < 4; iContador++)
	{
		if (document.getElementById('MINS2O'+iContador).checked)
		{
			sCadenaParams += "1";
		}
		else
		{
			sCadenaParams += "0";
		}
	}
	sCadenaParams += ";";
	sCadenaParams += "S3X";
	for (iContador = 1; iContador < 4; iContador++)
	{
		if (document.getElementById('MAXS3O'+iContador).checked)
		{
			sCadenaParams += "1";
		}
		else
		{
			sCadenaParams += "0";
		}
	}
	sCadenaParams += ";";
	sCadenaParams += "S3N";
	for (iContador = 1; iContador < 4; iContador++)
	{
		if (document.getElementById('MINS3O'+iContador).checked)
		{
			sCadenaParams += "1";
		}
		else
		{
			sCadenaParams += "0";
		}
	}
	sCadenaParams += ";";
	sCadenaParams += "NGW" + document.getElementById('NGW').value + ";";
	return sCadenaParams;
}
function sPrepararCadenaGWLow(suscriptor)
{
	var iContador;
	var sTipoSensAux;
	var sCadenaParams;
	
	if (suscriptor!="NO")
	{
		sCadenaParams = "SUS"+suscriptor+";";
	}
	else
	{
		sCadenaParams='';
	}
	
//			for (iContador = 10; iContador < 23; iContador++)
//			{
//				document.getElementById("EH"+iContador).selectedIndex=0;
//				document.getElementById("SH"+iContador).selectedIndex=0;
//			}
	sCadenaParams += "CTA" + document.getElementById('CTA').value+";";
	sCadenaParams += "CIS" + document.getElementById('CIS').value+";";
	sCadenaParams += "CID" + document.getElementById('CID').value+";";
	sCadenaParams += "CIP" + document.getElementById('CIP').value+";";
	sCadenaParams += "CIT" + document.getElementById('CIT').value+";";
	
	if ((document.getElementById('VHW')) && (document.getElementById('VHW').selectedIndex >= 0))
	{
		sCadenaParams += "VHW" + document.getElementById('VHW').options[document.getElementById('VHW').selectedIndex].id + ";";
	}
	if ((document.getElementById('VSW')) && (document.getElementById('VSW').selectedIndex >= 0))
	{
		sCadenaParams += "VSW" + document.getElementById('VSW').options[document.getElementById('VSW').selectedIndex].id + ";";
	}

	for (iContador = 0; iContador < 7; iContador++)
	{
		// Primero de todo, guardamos el tipo de sensor
		if (document.getElementById("A"+iContador+"K").selectedIndex!=-1)
		{
			sTipoSensAux = document.getElementById("A"+iContador+"K").options[document.getElementById("A"+iContador+"K").selectedIndex].id;
		}
		else
		{
			sTipoSensAux = "0";
		}
		
		sCadenaParams += "A"+iContador+"T" + document.getElementById('A'+iContador+'T').value+";";
		sCadenaParams += "A"+iContador+"W" + document.getElementById('A'+iContador+'W').value+";";
		sCadenaParams += "A"+iContador+"M" + document.getElementById('A'+iContador+'M').value+";";
		sCadenaParams += "A"+iContador+"N" + document.getElementById('A'+iContador+'N').value+";";		
		sCadenaParams += "A"+iContador+"V" + document.getElementById('A'+iContador+'V').selectedIndex+";";
		sCadenaParams += "A"+iContador+"E" + document.getElementById('A'+iContador+'E').selectedIndex+";";
		sCadenaParams += "A"+iContador+"K"+sTipoSensAux+";";
		sCadenaParams += "A"+iContador+"P" + document.getElementById('A'+iContador+'P').options[document.getElementById('A'+iContador+'P').selectedIndex].id+";";
		if(iContador < 3)
		{
			sCadenaParams += "M"+iContador+"X" + document.getElementById('M'+iContador+'X').value+";";
			sCadenaParams += "M"+iContador+"N" + document.getElementById('M'+iContador+'N').value+";";
			sCadenaParams += "U"+iContador+"D" + document.getElementById('U'+iContador+'D').selectedIndex+";";			
			sCadenaParams += "A"+iContador+"U" + sConvertir_Inversa_Datos_Sensor_GW(document.getElementById('A'+iContador+'U').value,parseInt(sTipoSensAux), document.getElementById('M'+iContador+'X').value, document.getElementById('M'+iContador+'N').value, "12")+";";
			sCadenaParams += "A"+iContador+"L" + sConvertir_Inversa_Datos_Sensor_GW(document.getElementById('A'+iContador+'L').value,parseInt(sTipoSensAux), document.getElementById('M'+iContador+'X').value, document.getElementById('M'+iContador+'N').value, "12")+";";			
		}
		else
		{			
			sCadenaParams += "A"+iContador+"U" + sConvertir_Inversa_Datos_Sensor_GW(document.getElementById('A'+iContador+'U').value,parseInt(sTipoSensAux), '0', '0', "12")+";";
			sCadenaParams += "A"+iContador+"L" + sConvertir_Inversa_Datos_Sensor_GW(document.getElementById('A'+iContador+'L').value,parseInt(sTipoSensAux), '0', '0', "12")+";";	

		}
		tipo1 = document.getElementById("MINA"+iContador+"1").checked?1:0;
		tipo2 = document.getElementById("MINA"+iContador+"2").checked?1:0;
		tipo3 = document.getElementById("MINA"+iContador+"3").checked?1:0;

		sCadenaParams += "A"+iContador+"A" + tipo1+ tipo2 + tipo3+";";						
	
		tipo1 = document.getElementById("MAXA"+iContador+"1").checked?1:0;
		tipo2 = document.getElementById("MAXA"+iContador+"2").checked?1:0;
		tipo3 = document.getElementById("MAXA"+iContador+"3").checked?1:0;

		sCadenaParams += "A"+iContador+"B" + tipo1+ tipo2 + tipo3+";";			
		//alert(sCadenaParams);
	}
	for (iContador = 0; iContador < 16; iContador++)
	{
		//Primero comprobamos el numero de sensor
		if(iContador > 9)
		{
			switch (iContador)
			{
				case 10:
					cContador = 'A';
					break;
				case 11:
					cContador = 'B';
					break;
				case 12:
					cContador = 'C';
					break;
				case 13:
					cContador = 'D';
					break;
				case 14:
					cContador = 'E';
					break;
				case 15:
					cContador = 'F';
					break;
			}
		}
		else
			cContador = iContador;
		if (document.getElementById("D"+cContador+"K").selectedIndex!=-1)
		{
			sTipoSensAux = document.getElementById("D"+cContador+"K").options[document.getElementById("D"+cContador+"K").selectedIndex].id;
		}
		else
		{
			sTipoSensAux = "0";
		}
		
			
		sCadenaParams += "D"+cContador+"T" + document.getElementById('D'+cContador+'T').value+";";
		sCadenaParams += "D"+cContador+"C" + document.getElementById('D'+cContador+'C').selectedIndex+";";
		sCadenaParams += "D"+cContador+"E" + document.getElementById('D'+cContador+'E').selectedIndex+";";
		sCadenaParams += "D"+cContador+"U" + sConvertir_Inversa_Datos_Sensor_GW(document.getElementById('D'+cContador+'U').value,parseInt(sTipoSensAux), '0', '0', "12")+";";
		sCadenaParams += "D"+cContador+"K"+sTipoSensAux+";";
		if(iContador<3)
		{				
		
			tipo1 = document.getElementById("MAXD"+iContador+"1").checked?1:0;
			tipo2 = document.getElementById("MAXD"+iContador+"2").checked?1:0;
			tipo3 = document.getElementById("MAXD"+iContador+"3").checked?1:0;
			sCadenaParams += "D"+iContador+"B" + tipo1+ tipo2 + tipo3+";";		
		}
	}
	for(iContador = 0 ; iContador < 23; iContador++)
	{
		if(iContador > 9)
		{
			switch (iContador)
			{
				case 10:
					cContador = 'A';
					break;
				case 11:
					cContador = 'B';
					break;
				case 12:
					cContador = 'C';
					break;
				case 13:
					cContador = 'D';
					break;
				case 14:
					cContador = 'E';
					break;
				case 15:
					cContador = 'F';
					break;
				case 16:
					cContador = 'G';
					break;
				case 17:
					cContador = 'H';
					break;
				case 18:
					cContador = 'I';
					break;
				case 19:
					cContador = 'J';
					break;
				case 20:
					cContador = 'K';
					break;
				case 21:
					cContador = 'L';
					break;
				case 22:
					cContador = 'M';
					break;
			}
		}
		else
		{
			cContador = iContador;
		}
		if (document.getElementById("EH"+iContador).selectedIndex!=-1)
		{
			sCadenaParams += "EH"+cContador + document.getElementById('EH'+iContador).selectedIndex+";";
		}
		else
		{
			sCadenaParams += "EH"+cContador + "0;";
		}
		
		if (document.getElementById("SH"+iContador).selectedIndex!=-1)
		{
			sCadenaParams += "SH"+cContador + document.getElementById('SH'+iContador).selectedIndex+";";
		}
		else
		{
			sCadenaParams += "SH"+cContador + "0;";
		}
		sCadenaParams += "SN"+cContador + document.getElementById('SN'+iContador).value+";";
	}
	sCadenaParams += "HMR"+document.getElementById('HMR').selectedIndex+";";
	sCadenaParams += "NGW" + document.getElementById('NGW').value + ";";
	console.log(sCadenaParams);
	return sCadenaParams;
}
function sPrepararCadenaGWLowT(suscriptor)
{
	var iContador;
	var sTipoSensAux;
	var sCadenaParams;
	
	if (suscriptor!="NO")
	{
		sCadenaParams = "SUS"+suscriptor+";";
	}
	else
	{
		sCadenaParams='';
	}
	sCadenaParams += "TEA"+document.getElementById('TEA').selectedIndex+";";
	sCadenaParams += "PSV" + document.getElementById('PSV').value+";";
	sCadenaParams += "TEB" + document.getElementById('TEB').value+";";
	sCadenaParams += "HOI"+document.getElementById('HOIH').value+document.getElementById('HOIM').value+";";
	sCadenaParams += "ITC"+document.getElementById('ITCH').value+document.getElementById('ITCM').value+";";
	sCadenaParams += "NEN" + document.getElementById('NEN').value+";";
	sCadenaParams += "VSO" + document.getElementById('VSO').value+";";
	sCadenaParams += "USE"+document.getElementById('USE').selectedIndex+";";
	sCadenaParams += "GPH"+document.getElementById('GPH').selectedIndex+";";
	sCadenaParams += "GSH"+document.getElementById('GSH').selectedIndex+";";
	sCadenaParams += "OPE"+document.getElementById('OPE').selectedIndex+";";
	sCadenaParams += "PRR" + document.getElementById('PRR').value+";";
	sCadenaParams += "PGR" + document.getElementById('PGR').value+";";
	sCadenaParams += "G03" + document.getElementById('G03').value+";";
	sCadenaParams += "G04" + document.getElementById('G04').value+";";
	sCadenaParams += "CNS"+document.getElementById('CNS').selectedIndex+";";

	for (iContador = 1; iContador < 7; iContador++)
	{	
		// Primero de todo, guardamos el tipo de sensor
		if (document.getElementById("TI"+iContador).selectedIndex==0)
		{
			sTipoSensAux = "0";
		}
		else if (document.getElementById("TI"+iContador).selectedIndex!=-1)
		{
			sTipoSensAux = document.getElementById("TI"+iContador).selectedIndex+6;
		}
		else
		{
			sTipoSensAux = "0";
		}
		sCadenaParams += "TM"+iContador + document.getElementById('TM'+iContador).value+";";
		sCadenaParams += "TE"+iContador + document.getElementById('TE'+iContador).value+";";
		if(iContador == 3 || iContador == 4)
		{	
			sCadenaParams += "UN"+iContador + sConvertir_Inversa_Datos_Sensor_GWLowT(document.getElementById('UN'+iContador).value,sTipoSensAux, '0', '0')+";";
			sCadenaParams += "UM"+iContador + sConvertir_Inversa_Datos_Sensor_GWLowT(document.getElementById('UM'+iContador).value,sTipoSensAux, '0', '0')+";";
			sCadenaParams += "GM"+iContador + sConvertir_Inversa_Gradiente_Sensor_GW(document.getElementById('GM'+iContador).value,sTipoSensAux, '0', '0')+";";
			sCadenaParams += "TG"+iContador + document.getElementById('TG'+iContador).value+";";
		}
		sCadenaParams += "TI"+iContador+document.getElementById("TI"+iContador)[document.getElementById("TI"+iContador).selectedIndex].id+";";
		sCadenaParams += "AS"+iContador+document.getElementById("AS"+iContador).selectedIndex+";";
		
		if (document.getElementById("EH"+iContador).selectedIndex!=-1)
		{
			sCadenaParams += "EH"+iContador + document.getElementById('EH'+iContador).selectedIndex+";";
		}
		else
		{
			sCadenaParams += "EH"+iContador + "0;";
		}
		if (document.getElementById("SH"+iContador).selectedIndex!=-1)
		{
			sCadenaParams += "SH"+iContador + document.getElementById('SH'+iContador).selectedIndex+";";
		}
		else
		{
			sCadenaParams += "SH"+iContador + "0;";
		}		
	}
	
	sCadenaParams += "NGW" + document.getElementById('NGW').value + ";";
	return sCadenaParams;
}
function iComprobar_Valores_LowT()
{
	if (document.getElementById('NGW').value.length > 20)
	{
		alert('El Nombre del Concentrador es demasiado largo');
		return -1;
	}
	else if (iComprobar_Nombre(document.getElementById('NGW').value) == -1)
	{
		alert('El Nombre del Concentrador contiene caracteres inválidos');
		return -1;
	}
	if (document.getElementById('G03').value.length > 0)
	{
		if (iComprobar_IP(document.getElementById('G03').value) == -1)
		{
			alert('Valor de IP Servidor Primario inválido');
			return -1;
		}
	}
	if (document.getElementById('G04').value.length > 0)
	{
		if (iComprobar_IP(document.getElementById('G04').value) == -1)
		{
			alert('Valor de IP Servidor Secundario inválido');
			return -1;
		}
	}
	if (document.getElementById('PSV').value.length > 0)
	{
		if (iComprobar_Entero(document.getElementById('PSV').value,3) == -1)
		{
			alert('Valor de Tiempo de Permanencia en Bajo Consumo inválido');
			return -1;
		}
	}
	if (document.getElementById('TEB').value.length > 0)
	{
		if (iComprobar_Entero(document.getElementById('TEB').value,3) == -1)
		{
			alert('Valor de Retardo de Pulso de Enclavamiento inválido');
			return -1;
		}
	}
	if (document.getElementById('NEN').value.length > 0)
	{
		if (iComprobar_Entero(document.getElementById('NEN').value,3) == -1)
		{
			alert('Valor de Retardo de Tramas de Control inválido');
			return -1;
		}
	}
	if (document.getElementById('PGR').value.length > 0)
	{
		if (iComprobar_Port(document.getElementById('PGR').value) == -1)
		{
			alert('Valor de Puerto TCP Concentrador inválido');
			return -1;
		}
	}
	if (document.getElementById('PRR').value.length > 0)
	{
		if (iComprobar_Port(document.getElementById('PRR').value) == -1)
		{
			alert('Valor de Puerto TCP Servidor inválido');
			return -1;
		}
	}

	for (iContador = 1; iContador < 7; iContador++)
	{
		if (document.getElementById('TM'+iContador).value.length > 0)
		{
			if (iComprobar_Entero(document.getElementById('TM'+iContador).value,5) == -1)
			{
				alert('Valor de Tiempo de Medida del Sensor '+iContador+' inválido');
				return -1;
			}
		}
		if (document.getElementById('TE'+iContador).value.length > 0)
		{
			if (iComprobar_Entero(document.getElementById('TE'+iContador).value,5) == -1)
			{
				alert('Valor de Tiempo de Envio del Sensor '+iContador+' inválido');
				return -1;
			}
		}
		if(iContador==3 || iContador==4)
		{
			if (document.getElementById('UM'+iContador).value.length > 0)
			{
				if (iComprobar_Decimal(document.getElementById('UM'+iContador).value,5) == -1)
				{
					alert('Valor de Umbral Máximo del Sensor '+iContador+' inválido');
					return -1;
				}
			}
			if (document.getElementById('UN'+iContador).value.length > 0)
			{
				if (iComprobar_Decimal(document.getElementById('UN'+iContador).value,5) == -1)
				{
					alert('Valor de Umbral Mínimo del Sensor '+iContador+' inválido');
					return -1;
				}
			}
			if (document.getElementById('GM'+iContador).value.length > 0)
			{
				if (iComprobar_Entero(document.getElementById('GM'+iContador).value,5) == -1)
				{
					alert('Valor de Gradiente del Sensor '+iContador+' inválido');
					return -1;
				}
			}
			if (document.getElementById('TG'+iContador).value.length > 0)
			{
				if (iComprobar_Entero(document.getElementById('TG'+iContador).value,5) == -1)
				{
					alert('Valor de Tiempo de Envio de Gradiente del Sensor '+iContador+' inválido');
					return -1;
				}
			}
		}
	}
	
	return 0;
}

function vCargar_Versiones_GW_DB(sGWID)
{
	var xmlHttpgrReadNode;
	var sPrincipalNode;
	var sListaValores;
	var sListaNombres;
	var sNombreParam;
	var sValorParam;
	var iContador;
	var url = "gw_lecturaDB_versiones.php?cliente_db="+top.document.getElementById("db_cliente").value+"&gw_id="+sGWID;
	xmlHttpgrReadNode= GetXmlHttpObject();
	xmlHttpgrReadNode.open("GET",url,false);
	xmlHttpgrReadNode.send(null);
	if (xmlHttpgrReadNode.responseText.substring(0,5) != "ERROR")
	{
		sPrincipalNode=parsear_xml(xmlHttpgrReadNode.responseText);
		if (sPrincipalNode != null)
		{
			sListaNombres=sPrincipalNode.childNodes[0].getElementsByTagName("nombre");
			sListaValores=sPrincipalNode.childNodes[0].getElementsByTagName("valor");
			for(iContador=0;iContador<sListaNombres.length;iContador++)
			{
				sNombreParam=sListaNombres[iContador].childNodes[0].nodeValue;
				if (sListaValores[iContador].childNodes[0])
				{
					sValorParam=sListaValores[iContador].childNodes[0].nodeValue;
				}
				else
				{
					sValorParam='';
				}
				if (sNombreParam.length==3)
				{
					if (sNombreParam=='VHW')
					{
						caVGWHW = sValorParam;
					}
					else if (sNombreParam=='VSW')
					{
						caVGWSW = sValorParam;
					}
					else if (sNombreParam=='GTI')
					{
						caGWTIPO = sValorParam;
					}
				}
			}
		}	
	}
	else
	{
		alert(xmlHttpgrReadNode.responseText);
	}	
}

function vRellenar_Combo_VersionesSW(combo_entrada, caVersionHWIN)
{
	document.getElementById(combo_entrada).length = 0;
	switch (caVersionHWIN)
	{
        case "11":
			insertarOptionCombo(combo_entrada,"1001","1001");
            break;
        case "10":
        	insertarOptionCombo(combo_entrada,"1100","1100");
        	insertarOptionCombo(combo_entrada,"1002","1002");
        	insertarOptionCombo(combo_entrada,"1000","1000");
            break;
        case "12":
        default:
        	insertarOptionCombo(combo_entrada,"1100","1100");
        	insertarOptionCombo(combo_entrada,"1002","1002");
        	insertarOptionCombo(combo_entrada,"1000","1000");
            break;
    }
    document.getElementById(combo_entrada).selectedIndex = 0;
}

function OnVersionChange(iHWoSW)
{
	var caVersionHW;
	var caVersionSW;
	if ((document.getElementById("VHW").selectedIndex == -1) && (document.getElementById("VHW").options.length > 0))
	{
		document.getElementById("VHW").selectedIndex = 0;
	}
	caVersionHW = document.getElementById("VHW").options[document.getElementById("VHW").selectedIndex].value;	
	
	if (iHWoSW == 0)
	{
       	vRellenar_Combo_VersionesSW("VSW",caVersionHW);
   	}
   	
   	if ((document.getElementById("VSW").selectedIndex == -1) && (document.getElementById("VSW").options.length > 0))
	{
		document.getElementById("VSW").selectedIndex = 0;
	}
	caVersionSW = document.getElementById("VSW").options[document.getElementById("VSW").selectedIndex].value;
	
   	Rellenar_Todos_Tipos_Sensor_GW(caVersionHW, caVersionSW);
}

function iObtener_TSGW_Select(sCadenaSelect)
{
	if (document.getElementById(sCadenaSelect).selectedIndex > -1)
	{
		return document.getElementById(sCadenaSelect).options[document.getElementById(sCadenaSelect).selectedIndex].id;
	}
	else
	{
		return -1;
	}
}

function iAsignar_TSGW_Select(cbComboTS,sValorIN)
{
	$('#'+cbComboTS+' option[id="'+sValorIN+'"]').attr("selected", "selected");
}
