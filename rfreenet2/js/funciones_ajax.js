var xmlHttp;
var xmlHttpbis;

function GetXmlHttpObject()
{
	var mixmlHttp=null;
	try
	{
		// Firefox, Opera 8.0+, Safari
		mixmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
		try
		{
			mixmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			mixmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return mixmlHttp;
}

function parsear_xml(txt)
{
	var xmlDoc;

	try //Internet Explorer
	{
		xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.async="false";
		xmlDoc.loadXML(txt);
		return xmlDoc;
	}
	catch(e)
	{
		try // Firefox, Mozilla, Opera, etc.
		{
			parser=new DOMParser();
			xmlDoc=parser.parseFromString(txt,"text/xml");
			return xmlDoc;
		}
		catch(e)
		{
			alert(e.message);
			return;
		}
	}
}