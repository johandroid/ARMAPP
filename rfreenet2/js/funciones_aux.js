function select_innerHTML(objeto,innerHTML)
{
	objeto.innerHTML = ""
    var selTemp = document.createElement("micoxselect")
    var opt;
    selTemp.id="micoxselect1"
    document.body.appendChild(selTemp)
    selTemp = document.getElementById("micoxselect1")
    selTemp.style.display="none"
    if(innerHTML.toLowerCase().indexOf("<option")<0)
    {
        innerHTML = "<option>" + innerHTML + "</option>"
    }
    innerHTML = innerHTML.replace(/<option/gi,"<span").replace(/<\/option/gi,"</span")
    selTemp.innerHTML = innerHTML
      
    
    for(var i=0;i<selTemp.childNodes.length;i++)
    {
    	var spantemp = selTemp.childNodes[i];
        if(spantemp.tagName)
        {     
        	opt = document.createElement("OPTION")
        	if(document.all)
        	{ //IE
        		objeto.add(opt)
        	}
        	else
        	{
        		objeto.appendChild(opt)
        	}       
    
		   //getting attributes
		   for(var j=0; j<spantemp.attributes.length ; j++)
		   {
			   var attrName = spantemp.attributes[j].nodeName;
			   var attrVal = spantemp.attributes[j].nodeValue;
			   if(attrVal)
			   {
				   try
				   {
					   opt.setAttribute(attrName,attrVal);
					   opt.setAttributeNode(spantemp.attributes[j].cloneNode(true));
				   }
				   catch(e){}
			   }
		   }
		   //getting styles
		   if(spantemp.style)
		   {
			   for(var y in spantemp.style)
			   {
				   try
				   {
					   opt.style[y] = spantemp.style[y];
				   }
				   catch(e){}
			   }
		   }
		   //value and text
		   opt.value = spantemp.getAttribute("value")
		   opt.text = spantemp.innerHTML
		   //IE
		   opt.selected = spantemp.getAttribute('selected');
		   opt.className = spantemp.className;
        } 
    }    
	document.body.removeChild(selTemp)
	selTemp = null
}

function insertarOptionCombo(id_combo,ident,texto)
{
	var y=document.createElement('option');
	y.text=texto;
	y.id = ident;
	var x=document.getElementById(id_combo);
	if (x)
	{
		try
		{
			x.add(y,null); // standards compliant
		}
		catch(ex)
		{
			x.add(y); // IE only
		}
	}
}

function insertarTopOptionCombo(id_combo,ident,texto)
{
	var y=top.document.createElement('option');
	y.text=texto;
	y.id = ident;
	var x=top.document.getElementById(id_combo);
	if (x)
	{
		try
		{
			x.add(y,null); // standards compliant
		}
		catch(ex)
		{
			x.add(y); // IE only
		}
	}
}
function insertarOptionComboValue(id_combo,ident,valor,sus,texto)
{
	var y=document.createElement('option');
	y.text=texto;
	y.id = ident;
	y.value = valor+sus;
	var x=document.getElementById(id_combo);
	if (x)
	{
		try
		{
			x.add(y,null); // standards compliant
		}
		catch(ex)
		{
			x.add(y); // IE only
		}
	}
}
function insertarOptionComboTitle(id_combo,ident,texto,titulo)
{
	var y=document.createElement('option');
	y.text=texto;
	y.id = ident;
	var x=document.getElementById(id_combo);
	if (x)
	{
		try
		{
			x.add(y,null); // standards compliant
		}
		catch(ex)
		{
			x.add(y); // IE only
		}
	}
	y.title=titulo;
}
function pad_izquierda(cadena,lon,caracter)
{
	var iIndice;
	var sAuxiliar;
	sAuxiliar = '';
	//alert('Padding ' + cadena + " from " +cadena.length+ " to " + lon + " with " + caracter);
	if (lon > (cadena.length))
	{		
		//iIndice=lon - cadena.length;
		for (iIndice=0; iIndice<(lon - cadena.length);iIndice++)
		{
			sAuxiliar += caracter;
		}
		sAuxiliar+=cadena;
	}
	else
	{
		sAuxiliar=cadena;
	}
	return sAuxiliar;
}

function sDatetime2tTimestamp(YYYY_MM_DD_hh_mm_ss)
{
	var sec_aux = parseInt(YYYY_MM_DD_hh_mm_ss.substring(17),10);
	var min_aux = parseInt(YYYY_MM_DD_hh_mm_ss.substring(14, 16),10);
	var hora_aux = parseInt(YYYY_MM_DD_hh_mm_ss.substring(11, 13),10);
	var dia_aux = parseInt(YYYY_MM_DD_hh_mm_ss.substring(8, 10),10);
	var mes_aux = parseInt(YYYY_MM_DD_hh_mm_ss.substring(5, 7),10);
	var ano_aux = parseInt(YYYY_MM_DD_hh_mm_ss.substring(0, 4),10);
	var fecha = new Date();
	fecha.setDate(dia_aux);
	fecha.setMonth(mes_aux-1);
	fecha.setFullYear(ano_aux);
	fecha.setHours(hora_aux);
	fecha.setMinutes(min_aux);
	fecha.setSeconds(sec_aux);
	fecha.setMilliseconds(0);
	var timestamp = parseInt(fecha.getTime()/1000,10);
	return timestamp;
}


function tTimestamp2sDateTime(timestamp)
{
	var fecha = new Date(timestamp);
	var sFecha = fecha.getFullYear()+"-"+pad_izquierda((fecha.getMonth()+1).toString(),2,'0')+"-"+pad_izquierda((fecha.getDate()).toString(),2,'0')+" "+pad_izquierda((fecha.getHours()).toString(),2,'0')+":"+pad_izquierda((fecha.getMinutes()).toString(),2,'0')+":"+pad_izquierda((fecha.getSeconds()).toString(),2,'0');
	return sFecha;
}