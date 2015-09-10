// JavaScript Document
function getHTTPObject(data_cut)
{
  //alert("la");
  var xmlhttp = false;

  /* Compilation conditionnelle d'IE */
  /*@cc_on
  @if (@_jscript_version >= 5)
     try
     {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
     }
     catch (e)
     {
        try
        {
           xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (E)
        {
           xmlhttp = false;
        }
     }
  @else
     xmlhttp = false;
  @end @*/

  /* on essaie de créer l'objet si ce n'est pas déjà fait */
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined')
  {
     try
     {
        xmlhttp = new XMLHttpRequest();
     }
     catch (e)
     {
        xmlhttp = false;
     }
  }

  if (xmlhttp)
  {
     /* on définit ce qui doit se passer quand la page répondra */
     xmlhttp.onreadystatechange=function()
     {
        //alert(xmlhttp.readyState + " readyState");
        if (xmlhttp.readyState == 4) /* 4 : état "complete" */
        {
        
           //alert(xmlhttp.responseText + " responseText");
           if (xmlhttp.status == 200) /* 200 : code HTTP pour OK */
           {
              /*
              Traitement de la réponse.
              Ici on affiche la réponse dans une boîte de dialogue.
              */
			       if(xmlhttp.responseText != "okmodif"){
      			 if(xmlhttp.responseText != "Non" && xmlhttp.responseText != "erreur ici"){
      			 	window.location='../frame/index.php';
      			 } else {
      			 	alert("Login et/ou Mot de passe incorrect");
      			 }
      			 }
			  //reloadXML(xmlhttp.responseText);
              //document.getElementById("label_result").innerHTML = xmlhttp.responseText;
			  //mon_tableau[data_cut] = xmlhttp.responseText;	
			  
           }
        }
     }
  }
  return xmlhttp;
}

function verifId(objet,objet2,object3){
		//envoi des données
		/*
    sendData(
		'POST',
		'http://www.byagency.com/phantom/admin/include/identification-xml.php',
		'xmlhttp=1&login='+objet+'&mdp='+objet2);
		*/
		sendData(
		'POST',
		'../include/identification.php',
		'xmlhttp=1&login='+objet+'&mdp='+objet2+'&langue='+object3);
}

function sendData(method, url, data){
  //alert("ici");
	data_cut = data.substring(10, data.length);
	//alert(data);
	//alert(data_cut);
	var xmlhttp = getHTTPObject(data_cut);
	
	if (!xmlhttp)
	{
	return false;
	}
	
	if(method == "GET")
	{
	if(data == 'null')
	{
	xmlhttp.open("GET", url, true); //ouverture asynchrone
	}
	else
	{
	xmlhttp.open("GET", url+"?"+data, true);
	}
	xmlhttp.send(null);
	}
	else if(method == "POST")
	{
	xmlhttp.open("POST", url, true); //ouverture asynchrone
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);
	}
	return true;
}