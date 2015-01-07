function xstooltip_findPosX(obj)
{
	var curleft = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
        {
            curleft += obj.offsetLeft
            obj = obj.offsetParent;
        }
	}
	else if (obj.x)
	curleft += obj.x;
	return curleft;
}
function xstooltip_findPosY(obj)
{
    var curtop = 0;
    if (obj.offsetParent)
    {
        while (obj.offsetParent) 
        {
            curtop += obj.offsetTop
            obj = obj.offsetParent;
        }
    }
    else if (obj.y)
        curtop += obj.y;
    return curtop;
}
function xstooltip_show(gw_id, gw_tipo)
{
	var url;
	var xmlHttpgrNodo;
	var gw_id_aux=gw_id;

	url = "carga_vista_general_sensores_gw.php?cliente_db="+top.document.getElementById('db_cliente').value+"&instalacion_id="+top.document.getElementById("comboInstalaciones").options[top.document.getElementById("comboInstalaciones").selectedIndex].value+"&gw_id="+gw_id+"&gw_tipo="+gw_tipo;
	xmlHttpgrNodo= GetXmlHttpObject();
	xmlHttpgrNodo.open("GET",url,true);

	xmlHttpgrNodo.onreadystatechange=function()
	{
		if (xmlHttpgrNodo.readyState==4)
		{
			if (xmlHttpgrNodo.responseText=='ERROR')
			{
				alert(xmlHttpgrNodo.responseText);
			}
			else
			{
			    it2 = document.getElementById('contenedor_sensores');
			    img = document.getElementById('imagen'+gw_id_aux);
			    //AMB Contenedor de la vista de GWs, para calcular la posición relativa de la flecha
				divVista = document.getElementById('carga_vista_gw');

			    x = xstooltip_findPosX(img) + 25;		        		         
		        y = xstooltip_findPosY(img) - divVista.scrollTop;

			    it2.innerHTML=xmlHttpgrNodo.responseText;
		        
		        it2.style.top = y + 'px';
		        it2.style.left = x + 'px';			    
			    it2.style.visibility = 'visible';
			}					
		}				
	}
	xmlHttpgrNodo.send(null);
}
function xstooltip_hide(id)
{
    it2 = document.getElementById('contenedor_sensores');
    it2.innerHTML="";
    it2.style.visibility = 'hidden';
}