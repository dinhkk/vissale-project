function convertText(text){
	
	console.log(text);
	
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
	
	
	var i = noBreaks.length,
		aRet = [];
	
	if(tfEncode == "yes"){
		while (i--) {
			var iC = noBreaks [i].charCodeAt();
			if (iC == 34 || iC == 38 || (iC ==96) || iC > 127) {
				aRet[i] = '&#'+iC+';';
			} else {
				aRet[i] = noBreaks[i];
			}
		}
		noBreaks = aRet.join('');
		//Get rid of some odd balls
		relq = /\&\#32\;/g;
		noBreaks = noBreaks.replace(relq," ");
		relq = /\&\#10\;/g;
		noBreaks = noBreaks.replace(relq," ");
		relq = /\&\#9\;/g;
		noBreaks = noBreaks.replace(relq," ");
		//make some friendly replacements
		var tf1 =new Array("&#169;","&#174;","&#178;","&#179;","&#34;","&#38;","&#8211;","&#8212;","&#8216;","&#8217;","&#8220;","&#8221;","&#8226;","&#8224;","&#8225;","&#8242;","&#8243;","&#8249;","&#8250;","&#8364;","&#8482;","&#732;","&#710;","&#9824;","&#9827;","&#9829;","&#9830;","&#9674;","&#8592;","&#8594;","&#8593;","&#8595;","&#8596;","&#172;","&#161;","&#162;","&#163;","&#164;","&#165;","&#166;","&#167;","&#168;","&#170;","&#171;","&#172;","&#173;","&#175;","&#176;","&#177;","&#180;","&#181;","&#182;","&#183;","&#184;","&#185;","&#186;","&#187;","&#188;","&#189;","&#190;","&#191;","&#192;","&#193;","&#194;","&#195;","&#196;","&#197;","&#198;","&#199;","&#200;","&#201;","&#202;","&#203;","&#204;","&#205;","&#206;","&#207;","&#208;","&#209;","&#210;","&#211;","&#212;","&#213;","&#214;","&#215;","&#216;","&#217;","&#218;","&#219;","&#220;","&#221;","&#222;","&#223;","&#224;","&#225;","&#226;","&#227;","&#228;","&#229;","&#230;","&#231;","&#232;","&#233;","&#234;","&#235;","&#236;","&#237;","&#238;","&#239;","&#240;","&#241;","&#242;","&#243;","&#244;","&#245;","&#246;","&#247;","&#248;","&#249;","&#250;","&#251;","&#252;","&#253;","&#254;","&#255;");
		var tf2=new Array("&copy;","&reg;","&sup2;","&sup3;","&quot;","&amp;","&ndash;","&mdash;","&lsquo;","&rsquo;","&ldquo;","&rdquo;","&bull;","&dagger;","&Dagger;","&prime;","&Prime;","&lsaquo;","&rsaquo;","&euro;","&trade;","&tilde;","&circ;","&spades;","&clubs;","&hearts;","&diams;","&loz;","&larr;","&rarr;","&uarr;","&darr;","&harr;","&not;","&iexcl;","&cent;","&pound;","&curren;","&yen;","&brvbar;","&sect;","&uml;","&ordf;","&laquo;","&not;","&shy;","&macr;","&deg;","&plusmn;","&acute;","&micro;","&para;","&middot;","&cedil;","&sup1;","&ordm;","&raquo;","&frac14;","&frac12;","&frac34;","&iquest;","&Agrave;","&Aacute;","&Acirc;","&Atilde;","&Auml;","&Aring;","&AElig;","&Ccedil;","&Egrave;","&Eacute;","&Ecirc;","&Euml;","&Igrave;","&Iacute;","&Icirc;","&Iuml;","&ETH;","&Ntilde;","&Ograve;","&Oacute;","&Ocirc;","&Otilde;","&Ouml;","&times;","&Oslash;","&Ugrave;","&Uacute;","&Ucirc;","&Uuml;","&Yacute;","&THORN;","&szlig;","&agrave;","&aacute;","&acirc;","&atilde;","&auml;","&aring;","&aelig;","&ccedil;","&egrave;","&eacute;","&ecirc;","&euml;","&igrave;","&iacute;","&icirc;","&iuml;","&eth;","&ntilde;","&ograve;","&oacute;","&ocirc;","&otilde;","&ouml;","&divide;","&oslash;","&ugrave;","&uacute;","&ucirc;","&uuml;","&yacute;","&thorn;","&yuml;");
		for (var ii = 0; ii < tf1.length; ii++) {
			noBreaks = noBreaks.replace(new RegExp(tf1[ii],"g"),tf2[ii]);
		}
	}

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
