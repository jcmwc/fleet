//var cal=null;
/*
function valideform(val){
	alert(ici)
	//alert(top.contenu.document.formcontenu)
	obj=document.formcontenu
  //sauvegarde des editeurs
  for(i=0;i<top.contenu.editor.length;i++){
		obj.elements[top.contenu.editor[i].InstanceName].value=top.contenu.editor[i].getHTML();
	}
  if(val==1){
	  //preview
    obj.action='<?=$_GET["urlpage"]?>?mode=preview';
    obj.target='_blank';
  }else{
	  //sauvegarde des données
    obj.action='admin/editorial/editorial.php?mode=modif';
    obj.target='_parent';
  }
  obj.submit();
}
*/
function precharge(iObj,iSrc) {
	if (document.images) {
		eval(iObj+" = new Image()");
		eval(iObj+".src = \""+iSrc+"\"");}
}

function roll(nom,iObj)
{
	if (document.images)
   		document.images[nom].src = eval(iObj+".src");
}

var editor= new Array();
var editorpdf= new Array();
var editorhtml= new Array();
var calendar= new Array();
function showhideMenu(obj,mstring){
//alert(obj.childNodes.length)
if(typeof(obj)!="undefined"){
	if(typeof(obj.childNodes[1])!="undefined"){
		if(document.all&&/msie|MSIE 6/.test(navigator.userAgent))
			obj.childNodes[1].style.display=mstring;
   }      
}
}

/*
_editor_url="../htmlarea/";
function initHtmlarea(){
	for(i=0;i<editor.length;i++){
   			editor[i] = new HTMLArea(editor[i]);
          	// register the TableOperations plugin with our editor
	         editor[i].registerPlugin("ContextMenu");
          	editor[i].registerPlugin("TableOperations");
          	editor[i].generate();
   }
}*/
function initHtmlarea(chemin,cssdir)
{
	// Automatically calculates the editor base path based on the _samples directory.
	// This is usefull only for these samples. A real application should use something like this:
	// oFCKeditor.BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
	for(i=0;i<editor.length;i++){
   	inputname=editor[i].split("|")[0];
	  cssstring=editor[i].split("|")[1];
		height=editor[i].split("|")[2];
		toolbar=editor[i].split("|")[3];
    template=editor[i].split("|")[4];
    editor[i] = new FCKeditor(inputname) ;
    editor[i].Config["DefaultLanguage"]    = defaultlanguage;
    editor[i].Config["ProcessHTMLEntities"]    = false;
    /*
    editor[i].Config["ProcessHTMLEntities"]    = true;
    editor[i].Config["IncludeLatinEntities"]    = false;
    */
    editor[i].Config["playerUrl"]    = '/userfiles/mediaplayer.swf';
    editor[i].BasePath	= chemin;
    //editor[i].Height = height;
    editor[i].Height = height;
    editor[i].ToolbarSet=toolbar;
    editor[i].Config["TemplatesXmlPath"]=template;
    //alert(chemin+"xmlstyle.php?"+cssdir+cssstring)
    editor[i].Config["EditorAreaStyles"] = cssdir+cssstring;
      //editor[i].Config.StylesXmlPath = chemin+"xmlstyle.php?"+cssdir+cssstring;
      //alert(editor[i].Config.StylesXmlPath)
      //editor[i].Config.EditorAreaCSS = cssdir+cssstring;
			//editor[i].Config.StylesXmlPath =	cssdir+cssstring+'.xml';
  		//editor[i].Config.StylesXmlPath =	'../fckstyles.xml';
	   //editor[i].Config.EditorAreaCSS=chemin + 'css/fck_editorarea.css';
    editor[i].ReplaceTextarea() ;
      //alert(editor[i].Config.EditorAreaCSS);
	}
}
function validateGenForm(obj){
obj.onsubmit();
if(validateForm(obj)){
	obj.submit();
}
}

function estuneadressemail(monemail)
{
flag=false;
	if(monemail!="")
	{
	longueur=monemail.substring(monemail.lastIndexOf("."),monemail.length).length
		if(monemail.indexOf("@")!=-1&&(longueur==3||longueur==4))
		{
			if(monemail.indexOf("@")<monemail.lastIndexOf(".")+1)
				flag= true;
		}
	}
return flag;
}
var win;
function openwin(url,large,hauteur,scroll) 
{
	scroll=(scroll==null)?"no":"yes";
	exist=(win)?true:false;
	if(exist&&!win.closed)
	{
		win.resizeTo(large+10, hauteur+20)
		win.location=url;
	}
	else
    win = window.open(url,"win","location=no,toolbar=no,directories=no,menubar=no,resizable=yes,scrollbars="+scroll+",width="+large+",height="+hauteur+",status=no");
  win.focus()
}

function testdate(madate)
{
	if(madate.length!=10)
		return false;
	jour=madate.substring(0,2)*1
	mois=madate.substring(3,5)*1-1
	annee=madate.substring(6,10)*1
	madate=new Date(annee,mois,jour)
	if(jour==madate.getDate()&&mois==madate.getMonth()&&annee==madate.getFullYear())
		return true
	else
		return false
}
function testdate2(annee,mois,jour)
{
	madate=new Date(annee,mois,jour)
	if(jour==madate.getDate()&&mois==madate.getMonth()&&annee==madate.getFullYear())
		return true
	else
		return false
}
function testext(url,ext)
{
//alert(url.substring(url.lastIndexOf("."),url.length).toLowerCase()=="."+ext)
if(url.substring(url.lastIndexOf("."),url.length).toLowerCase()=="."+ext)
	return true;
else
	return false;
}
	
function deletelem(obj)
{
if(obj.options&&obj.selectedIndex!=-1){
	if(obj.options[obj.options.selectedIndex].value!="")
	{
		for(i=obj.options.length-1;i>-1;i--)
		{
			if(obj.options[i].selected==true)
				obj.options[i]=null;
		}
	}
	else
		alert("Aucun élément de sélectionné !")
}
}

function deletelem2(obj)
{
		for(i=obj.options.length-1;i>-1;i--)
			obj.options[i]=null;
}

function newelem(obj1,obj2)
{
	if(obj1.value!="")
		{
			for(i=0;i<obj1.options.length;i++)
			{
				if(obj1.options[i].selected)
				{	
					if(!existOption(obj1.options[i].value,obj2))	
					{
						o=new Option(obj1.options[i].text,obj1.options[i].value);
						obj2.options[obj2.options.length]=o;
					}
				}
			}
		}
		else
			alert("Champ vide !");
		obj1.value=""
}

function newelem2(obj1,obj2)
{
	for(i=0;i<obj1.options.length;i++)
	{
		if(!existOption(obj1.options[i].value,obj2))	
		{
			o=new Option(obj1.options[i].text,obj1.options[i].value);
			obj2.options[obj2.options.length]=o;
		}
	}
}

function selectAll(obj)
{
	for(i=0;i<obj.options.length;i++)
		obj.options[i].selected=true;
}
function unselectAll(obj)
{
	for(i=0;i<obj.options.length;i++)
		obj.options[i].selected=false;
}

function existOption(myValue,obj)
{
	for(w=0;w<obj.options.length;w++)
		if(myValue==obj.options[w].value)
			return true;
	return false;
}
/*
function showCalendar(id, format, showsTime, showsOtherMonths) {
  
  var el = document.getElementById(id);
  if (calendar != null) {
    // we already have some calendar created
    calendar.hide();                 // so we hide it first.
  } else {
    // first-time call, create the calendar.
    var cal = new Calendar(true, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = true;
    }
    calendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  calendar.setDateFormat(format);    // set the specified date format
  calendar.parseDate(el.value);      // try to parse the text in field
  calendar.sel = el;                 // inform it what input field we use

  // the reference element that we pass to showAtElement is the button that
  // triggers the calendar.  In this example we align the calendar bottom-right
  // to the button.
  calendar.showAtElement(el.nextSibling, "Br");        // show the calendar
  
}
*/
function showhideMenu2(obj){
	mydisplay=obj.childNodes[0].style.display;
   mstring=(mydisplay=='none'||mydisplay=='')?'block':'none';
   //alert(mstring)
   obj.childNodes[1].style.display=mstring;
}
function openclosearbre(val){
	var bodyCol = top.document.getElementsByTagName("frameset")[0];
	bodyCol.setAttribute("cols",val+",*");
   if(val==0){
   	top.tailleopen=300;
	   roll('arbreimg','arbreON');
   }else{
	   top.tailleopen=0;
	   roll('arbreimg','arbreOFF');
   }
}
function delog(){
//	alert('ok')
	self.location='../home/index.php?delog=true';
}
function delArbre(){
	clearArbre();
	listchk=top.arbre.getlistchk();
   if(listchk!="")
	window.location='../arbre/del.php?selection='+listchk;
   else
   alert('Vous devez sélectionner au moins un élément');
}
function copymove(myurl){
	clearArbre();
	listchk=top.arbre.getlistchk();
   if(listchk!="")
	window.location='../arbre/'+myurl+'.php?selection='+listchk;
   else
   alert('Vous devez sélectionner au moins un élément');
}
function addElem(libelle,value,nomobj,indice){
   o=new Option(libelle,value);
   indice=(indice==null)?document.forms[0].elements[nomobj].options.length:indice;
   document.forms[0].elements[nomobj].options[indice]=o;
}
function delElem(nomobj){
   obj=document.forms[0].elements[nomobj];
   for(i=obj.options.length-1;i>-1;i--)
			obj.options[i]=null;
}
function moveRank(type){
	clearArbre();
	if(top.listElem.length==1){
   	window.location='../arbre/chgrank.php?func='+type+'&selection='+top.arbre.getlistchk();
   }else{
   	alert('Vous devez sélectionner un élément');
   }
}
function intervertir(){
	clearArbre();
	if(top.listElem.length==2&top.listElem[0]){
   	window.location='../arbre/chgrank.php?func=intervertir&selection='+top.arbre.getlistchk();
   }else{
   	alert('Vous devez sélectionner deux éléments du même parent');
   }
}
function lock(){
	clearArbre();
	if(top.listElem.length==1){
   	window.location='../arbre/lock.php?selection='+top.arbre.getlistchk();
   }else{
   	alert('Vous devez sélectionner un élément');
   }
}
function valide(){
	clearArbre();
	if(top.listElem.length==1){
   	window.location='../arbre/valide.php?selection='+top.arbre.getlistchk();
   }else{
   	alert('Vous devez sélectionner un élément');
   }
}
function droits(){
	clearArbre();
	if(top.listElem.length==1){
   	window.location='../arbre/droits.php?selection='+top.arbre.getlistchk();
   }else{
   	alert('Vous devez sélectionner un élément');
   }
}
function newarbre(type){
	clearArbre();
  	if(top.listElem.length==1||top.listElem.length==0){
    	window.location='../arbre/'+type+'.php?mode=ajout&id='+top.arbre.getlistchk();
  	}else{
  		alert('Vous devez sélectionner un élément');
  	}
}
function modif(){
	clearArbre();
	if(top.listElem.length==1){
   	//alert(top.arbre.infoElem[top.listElem[0]][1])
   	switch(top.arbre.infoElem[top.listElem[0]][1]){
      	case 1:
         	type="document";
         	break;
      	case 2:
         	type="redirection";
         	break;
	     	case 4:
         	type="directory";
         	break;
			case -1:
         	type="video";
         	break;
      	default:
         	type="file";
         	break;
      }
   	window.location='../arbre/'+type+'.php?mode=modif&id='+top.arbre.getlistchk();
   }else{
   	alert('Vous devez sélectionner un élément');
   }
}
function getlistidselect(nomobj){
	clearArbre();
	listvalue="";
   for(i=0;i<document.forms[0].elements[nomobj].options.length;i++){
   	listvalue+=document.forms[0].elements[nomobj].options[i].value+',';
   }
   return listvalue.substr(0,listvalue.length-1);
}
function log(){
	clearArbre();
  	if(top.listElem.length==1){
    	window.location='../arbre/log.php?selection='+top.arbre.getlistchk();
  	}else{
  		alert('Vous devez sélectionner un élément');
  	}
}
function preview(){
  	clearArbre();
  	if(top.listElem.length==1){
    	window.location='../arbre/preview.php?selection='+top.arbre.getlistchk();
  	}else{
  		alert('Vous devez sélectionner un élément');
  	}
}
function clearArbre(){
	for(i=0;i<top.listElem.length;i++){
      if(typeof(top.arbre.infoElem[top.listElem[i]])=="undefined"){
		   top.arbre.removeElem(top.listElem[i])
	   }
	}      
}
function compta(){
	top.location='/compta';
}
function doit() {
			alert(eval("document.JUpload." + document.forms["testform"].cmd.value));
		}
   function show(objet){

		document.getElementById(objet).style.display = "block";
	}
	function cache(objet){
		document.getElementById(objet).style.display = "none";
	}
	
		function fond(objet){
		objet.style.backgroundColor = "#668108";
		objet.style.color = "#FFFFFF";
	}
	function nofond_1(objet){
		objet.style.backgroundColor = "#add01e";
		objet.style.color = "#000000";
	}
	function nofond_2(objet){
		objet.style.backgroundColor = "#ddeca2";
		objet.style.color = "#000000";
	}
	
	function fondtr(objet){
		objet.style.backgroundColor = "#add01e";
		objet.style.color = "#FFFFFF";
	}
	function nofondtr_1(objet){
		objet.style.backgroundColor = "#e3e3e3";
		objet.style.color = "#000000";
	}
	
	function nofondtr_2(objet){
		objet.style.backgroundColor = "#d5d5d5";
		objet.style.color = "#000000";
	}
	
	function permut(i){
		Chaine = document.images[i].src;
		Sous_Chaine = '_haut'
	
		var Resultat = Chaine.indexOf(Sous_Chaine)
		 
		if(Resultat > -1){
			document.images[i].src = document.images[i].src.replace(/_haut/,'_bas');
		} else {
			document.images[i].src = document.images[i].src.replace(/_bas/,'_haut');
		}
	}
	function aspirecontent(){
    if(document.all){
  		if(eval("framecontent").document.getElementById('global')!=null){
  		  document.getElementById('global').innerHTML=eval("framecontent").document.getElementById('global').innerHTML;
    		validateForm = function (obj) {
          //eval(eval("moniframe").document.getElementById('javascript').innerHTML);
          return eval("framecontent").validateForm(obj);    
        }
      }else{
        alert('Erreur au chargement, Veuillez contacter l\'administrateur si le problème persiste');
      }
  	}else{
  		if(document.getElementById('framecontent').contentDocument.getElementById('global')!=null){
  		  document.getElementById('global').innerHTML=document.getElementById('framecontent').contentDocument.getElementById('global').innerHTML;
  		  //alert(document.getElementById('global').innerHTML)
    		validateForm = function (obj) {
          //eval(document.getElementById('moniframe').contentDocument.getElementById('javascript').innerHTML);
          //alert(document.getElementById('framecontent').contentDocument.body.innerHTML);
          return document.getElementById('framecontent').contentWindow.validateForm(obj);
        }
      }else{
        //alert('ici');
        alert(document.getElementById('framecontent').contentDocument.body.innerHTML);
        //alert('Erreur au chargement, Veuillez contacter l\'administrateur si le problème persiste');
      }
    }
    //isOn();
    //alert(top.editor.length);
    if(top.editor.length>0){
      initHtmlarea(fckdir,cssdir);
    }
    //alert(top.calendar.length);
    if(top.calendar.length>0){
      /*
      cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      */
      for(i=0;i<top.calendar.length;i++){
        /*
        //alert(top.calendar[i].showsTime);
        if(top.calendar[i].showsTime){
          Calendar.setup(
            {
              inputField  : top.calendar[i].inputField,         // ID of the input field
              ifFormat    : top.calendar[i].ifFormat,    // the date format
              showsTime      :    true,
              timeFormat     :    "24",
              button      : top.calendar[i].button       // ID of the button
            }
          )
        }else{
          Calendar.setup(
            {
              inputField  : top.calendar[i].inputField,         // ID of the input field
              ifFormat    : top.calendar[i].ifFormat,    // the date format
              button      : top.calendar[i].button       // ID of the button
            }
          )
        }
        */
        if(top.calendar[i].showsTime){
          //alert('ici');
          var test= Calendar.setup(
            {
              inputField  : top.calendar[i].inputField,         // ID of the input field
              dateFormat    : top.calendar[i].ifFormat,    // the date format
              showTime      :  24,
              trigger      : top.calendar[i].button,       // ID of the button
              weekNumbers: true,
              onSelect: function() {
                      this.hide()
              }
            }
          )
        }else{
          Calendar.setup(
            {
              inputField  : top.calendar[i].inputField,         // ID of the input field
              dateFormat    : top.calendar[i].ifFormat,    // the date format
              trigger      : top.calendar[i].button,       // ID of the button
              weekNumbers: true,
              onSelect: function() {
                      this.hide()
              }
            }
          )
        }
        /*
        var tmpcal=new Calendar({
                          inputField:  top.calendar[i].inputField,
                          dateFormat: top.calendar[i].ifFormat,
                          trigger: top.calendar[i].button,                          
                          onSelect: function() {
                                  this.hide()
                          }
                  });
        alert(tmpcal.showsTime)
        tmpcal.args.showsTime=24;
        */
        /*
        alert(cal.args.showsTime)
        if(top.calendar[i].showsTime){
          cal.args.showsTime=true;
          cal.args.timeFormat="24";
        }
        cal.manageFields(top.calendar[i].button,top.calendar[i].inputField,top.calendar[i].ifFormat);
        */
      }
    }
    
  }


function show_me(objet){
  document.getElementById(objet).style.display = "block";
}

function not_me(objet){
  document.getElementById(objet).style.display = "none";
}

function refreshpage(monurl){
  
  if(document.all){
    moniframe=eval("framecontent");
  }else{
    moniframe=document.getElementById('framecontent').contentWindow
  }
  moniframe.location=monurl;
}
function closecrop(){
 // alert(myvalue);
  document.form1.elements[currentelem].value=myvalue;
 // alert(document.form1.elements[currentelem].value)
}
function validateImport(obj){
  if(obj.fichier.value==''){
    alert(obj.fichiertxt.value);
    obj.fichier.focus();
    return false;
  }
  return true;
} 
function majelemcombine(name1,name2,obj){
  //alert(obj.value)
  obj2=obj.form.elements[name2];
  deletelem3(obj2);
  tab=eval('tab'+name1+'_'+name2);
  for(i=0;i<tab[obj.value].length;i++){
    o=new Option(tab[obj.value][i][0],tab[obj.value][i][1]);
    obj2.options[obj2.options.length]=o;
  }
}
function savemodif(obj,indice){
  //alert(sendData)
  sendData(
		'POST',
		'../element/listprice/savemodif.php',
		'xmlhttp=1&montantremise='+obj.form.elements["montantremise"+indice].value+'&montant='+obj.form.elements["montant"+indice].value+'&quantite='+obj.form.elements["quantite"+indice].value+'&ref='+obj.form.elements["ref"+indice].value+'&indice='+indice);
	alert('Modification effectuée');
}

function GB_showCenter(title,url,height,width,closefct){
//$(function() {    
    $( "#dialog" ).dialog({      
    autoOpen: false,      
    show: "fade",   
    hide: "fade",
            modal: true,            
            open: function () {
             $('#contentdialog').attr('src',url);
            }, 
            close:closefct,                    
            height: height,            
            width: width,        
            resizable: true,    
            title: title    });     
    $( "#dialog" ).dialog( "open" );      
  //});
}