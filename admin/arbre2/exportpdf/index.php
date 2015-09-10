<?
require("../../require/function.php");
testGenRulesDie("EXP");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN"
   "http://www.w3.org/TR/REC-html40/frameset.dtd">

<html>
<head>
<meta charset="UTF-8" />
<script type="text/javascript" src="html2canvas-0.4.1/build/html2canvas.js"></script>
<script>
function capture(){
 frame=document.getElementById('siteframe');
 //alert(frame.contentWindow.document.body)
 html2canvas(frame.contentWindow.document.body, {
            onrendered: function(canvas) {
                //document.body.appendChild(canvas);
                var strDataURI = canvas.toDataURL(); 
                //alert(strDataURI);
                //tab=strDataURI.split("/");
                //alert("canvas fini")
                frame=document.getElementById('tool');
                //alert(frame.contentWindow.document.body.innerHTML);
                //frame.contentWindow.document.getElementById('img').value=strDataURI;
                var cut=10;
                var increment=500000;
                //var sizemax=tab.length;
                //alert(strDataURI.length)
                var field="";
                for(i=0;i<strDataURI.length;i=i+increment){
                  field+= "<textarea name=\"img[]\" >"+strDataURI.substring(i,i+increment)+"</textarea>";
                }
                //alert(field);
                //alert(frame.contentWindow.location.href)
                siteframe=document.getElementById('siteframe');
                //alert(siteframe.contentWindow.location.href);
                field+= "<textarea name=\"urlpage\" >"+siteframe.contentWindow.location.href+"</textarea>";
                //alert(field)
                frame.contentWindow.document.getElementById('myform').innerHTML=field;                
                frame.contentWindow.document.getElementById('myform').submit();
                
                //alert(strDataURI)
                /*
                $.ajax({  
              	  type: "POST",  
              	  url: "save.php",  
              	  data: "img="+strDataURI,   
              	  success: function(data) {
                  alert("fini2");
                }});
                */
                //alert(strDataURI);
                //var doc = new jsPDF();
                //doc.addImage(strDataURI, 'PNG', 15, 40, 180, 160);
                //doc.output();
                //alert(strDataURI)
                //window.location=strDataURI;
                /*
                var oImgPNG = Canvas2Image.saveAsPNG(canvas, false); 
                //alert(oImgPNG);
                if (!oImgPNG) {
            			alert("Sorry, this browser is not capable of saving " + strType + " files!");
            			//return false;
            		} */
                //Canvas2Image.saveAsPNG(canvas);
                //alert('ok')
            }
        });
}
</script>
<title>Export PDF</title>
</head>
<FRAMESET rows="50,*"> 
<FRAME src="outil.php" name="tool" id="tool" marginheight="0" marginwidth="0" frameBorder="0" border="0" scrollbar="0" scrolling="no">
<FRAME src="<?=urlp($_GET["arbre_id"])?>" name="siteframe" id="siteframe" marginheight="0" marginwidth="0" frameBorder="0" border="0" onload="capture()">
</FRAMESET>
</html>   