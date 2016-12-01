function convertText(text){
	
	//console.log(text);
	
	var linebs = '<br>';
	var jpTag = false;
	var jpTagbrTag = true;
	var jbrTag = false;
	var noBreaks = text;

//var tfEncode = $('#tfEncode:checked').val();
	var tfEncode = false;
	
	
	
	noBreaks = noBreaks.replace(/\r\n/g,"XiLBXZ");
	noBreaks = noBreaks.replace(/\n/g,"XiLBXZ");
	noBreaks = noBreaks.replace(/\r/g,"XiLBXZ");
	
	
	var i = noBreaks.length, aRet = [];
	
//relq = /\&amp\;/g;
//oBreaks = noBreaks.replace(relq,'&amp;amp;');
	
	
	
	re1 = /\s+/g;
	noBreaks = noBreaks.replace(re1," ");
	noBreaks = $.trim(noBreaks);
	
	
	if(jbrTag != 0 || jbrTag !=  false){
		re4 = /XiLBXZXiLBXZ/gi;
		noBreaks = noBreaks.replace(re4,linebs+"\r\n"+linebs+"\r\n");
	}else{
		re4 = /XiLBXZXiLBXZ/gi;
		noBreaks = noBreaks.replace(re4,"</p><p>");
	}
	
	if(jpTag == 0 || jpTag ==  false){
		re5 = /XiLBXZ/gi;
		noBreaks = noBreaks.replace(re5,linebs+"\r\n");
	}else{
		re5 = /XiLBXZ/gi;
		noBreaks = noBreaks.replace(re5," ");
	}
	
	if(jbrTag == 0 || jbrTag ==  false){
		noBreaks ='<p>'+noBreaks+'</p>';
	}
	
	noBreaks = noBreaks.replace("<p><\/p>","");
	noBreaks = noBreaks.replace("\r\n\r\n","");
	noBreaks = noBreaks.replace(/<\/p><p>/g,"</p>\r\n\r\n<p>");
	noBreaks = noBreaks.replace(new RegExp("<p><br />","g"),"<p>");
	noBreaks = noBreaks.replace(new RegExp("<p><br>","g"),"<p>");
	
	
	//document.getElementById("newCode").value = noBreaks;
	return noBreaks;
}
