function iComprobar_IP(sCadenaIN)
{
	var pattern = /\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b$/;
	
	if (!(pattern.test(sCadenaIN))) 
	{
		//alert(sCadenaIN+' is not a valid IP number');
		return -1;
	}
	else
	{
		return 0;
	}
}

function iComprobar_KEY(sCadenaIN)
{
	var pattern = /\b([0-9a-fA-F]{2})?([0-9a-fA-F]{2})?\b$/;
	
	if (!(pattern.test(sCadenaIN)))
	{
		//alert(sCadenaIN+' is not a valid KEY');
		return -1;
	}
	else
	{
		return 0;
	}
}

function iComprobar_Port(sCadenaIN)
{
	if (iComprobar_Entero(sCadenaIN,5) == -1)
	{
		return -1;
	}
	else if ((sCadenaIN.length == 0) || (parseInt(sCadenaIN) <= 0) || (parseInt(sCadenaIN) > 65535)) 
	{
		//alert(sCadenaIN+' is not a valid Port');
		return -1;
	}
	else
	{
		return 0;
	}
}

function iComprobar_Telefono(sCadenaIN,iLongitudMAX)
{
	var pattern = /^\s*(\+)?\d+\s*$/;
	
	if (sCadenaIN.length > iLongitudMAX)
	{
		//alert(sCadenaIN+' is too long');
		return -1;
	}
	else
	{
		if (!(pattern.test(sCadenaIN))) 
		{
			//alert(sCadenaIN+' is not a valid Number');
			return -1;
		}
		else
		{
			return 0;
		}
	}
}

function iComprobar_Entero(sCadenaIN,iLongitudMAX)
{
	var pattern = /^\s*(\+|-)?\d+\s*$/;
	
	if ((sCadenaIN.length == 0) || (sCadenaIN.length > iLongitudMAX)) 
	{
		//alert(sCadenaIN+' is too long');
		return -1;
	}
	else
	{
		if (!(pattern.test(sCadenaIN))) 
		{
			//alert(sCadenaIN+' is not a valid Number');
			return -1;
		}
		else
		{
			return 0;
		}
	}
}

function iComprobar_Decimal(sCadenaIN,iLongitudMAX)
{
	var pattern =  /^\s*(\+|-)?((\d+(\.\d+)?)|(\.\d+))\s*$/;
	
	if ((sCadenaIN.length == 0) || (sCadenaIN.length > iLongitudMAX)) 
	{
		//alert(sCadenaIN+' is too long');
		return -1;
	}
	else
	{
		if (!(pattern.test(sCadenaIN))) 
		{
			//alert(sCadenaIN+' is not a valid Number');
			return -1;
		}
		else
		{
			return 0;
		}
	}
}

function iComprobar_Email(sCadenaIN)
{
	var pattern =  /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
	
	if (!(pattern.test(sCadenaIN)))
	{
		//alert(sCadenaIN+' is not a valid Number');
		return -1;
	}
	else
	{
		return 0;
	}
}

function iComprobar_Nombre(sCadenaIN)
{
	var pattern = /^[\w\s]+$/;
	
	if ((sCadenaIN.length > 0) && (!(pattern.test(sCadenaIN)))) 
	{
		//alert(sCadenaIN+' is not a valid Name');
		return -1;
	}
	else
	{
		return 0;
	}
}

function iComprobar_Consulta(sCadenaIN)
{
	//var pattern = /^[\w\s[?+*!%.,-¿¡()$@#<>]*$/;
	var pattern = /^[-_\w\.\s,¿?¡!][^\n]+$/;
	
	if ((sCadenaIN.length > 0) && (!(pattern.test(sCadenaIN)))) 
	{
		//alert(sCadenaIN+' is not a valid Name');
		return -1;
	}
	else
	{
		return 0;
	}
}

function iComprobarNombreCliente(sEntrada)
{
	var TempChar;
	var RefString="1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
	for(var iCont=0;iCont<sEntrada.length;iCont++)
	{
         TempChar= sEntrada.substring(iCont, iCont+1);
		 if (RefString.indexOf(TempChar, 0)==-1)
		 {
			return -1;
		 }
	}
	return 0;
}

function iComprobar_Entero_Rango(sCadenaIN,iLongitudMAX,iNumMin,iNumMax)
{
	var pattern = /^\s*(\+|-)?\d+\s*$/;
	
	if ((sCadenaIN.length == 0) || (sCadenaIN.length > iLongitudMAX)) 
	{
		//alert(sCadenaIN+' is too long');
		return -1;
	}
	else
	{
		if (!(pattern.test(sCadenaIN))) 
		{
			//alert(sCadenaIN+' is not a valid Number');
			return -1;
		}
		else
		{
			if (parseInt(sCadenaIN)<iNumMin || parseInt(sCadenaIN)>iNumMax ) 
			{
				//alert(sCadenaIN+' is not a valid Number');
				return -1;
			}
			else
			{
				return 0;
			}
		}
	}
}