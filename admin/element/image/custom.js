var tabval = new Array();
$(function() {
/// load about
$("#show_details").click(function () {

  $("#about_details").slideToggle("slow");
}); 


$("form").submit(function() {
						  
	var fname = $(this).attr('name');
	
	//check if they have made a thumbnail selection
	if(fname == 'upload_thumb'){
		if($('#x1').val() =="" || $('#y1').val() =="" || $('#width').val() <="0" || $('#height').val() <="0"){
			alert("Faites votre sélection");
			return false;
		}
	}
	
	$('#big').imgAreaSelect({hide:true});	
	$('#notice').text('Chargement..').fadeIn();							  
	
	$('#upload_target').unbind().load( function(){
												
		//var img = $('#upload_target').contents().find('body ').html();
		var info = $('#upload_target').contents().find('body').html();
		tmptabval=info.split('|');
    var img = tmptabval[0];
		if(fname == 'upload_big'){
		// load to preview image
		tabval= tmptabval;
		//alert(tabval)
		var img_id = 'big';
		/////// get image source , this will be passed into PHP
		$('.img_src').attr('value',img)				
		}
		var date = new Date();
		//alert(date.getTime());
		$('#div_'+fname).html('<img id="'+img_id+'" src="'+img+'?'+date.getTime()+'" />');						

		if($(img).attr('class') != 'uperror'){
		$('#upload_thumb').show();
		//area select plugin http://odyniec.net/projects/imgareaselect/examples.html
		/*
    $('#big').imgAreaSelect({ 
			aspectRatio: '1:1', 
			handles: true,
			fadeSpeed: 200,
			resizeable:false,
			maxHeight:300,
			maxWidth:200,			
			minHeight:100,
			minWidth:50
			});
		*/
		reinitval();
		}
		/*
		else{
			//hide them
			$('#upload_thumb').hide();		
		}*/
		
		$('#notice').fadeOut();					
		
		// we have to remove the values
		//$('.width , .height , .x1 , .y1 , #file').val('');
		
	  });
  });
	
});

function reinitval(){
    top.myvalue=document.getElementById('thumbinfo').options.length;
    info=$('#thumbinfo').val().split('/');
    //alert(info);
		mywidth=info[0];
		myheight=info[1];
		indice=info[2];
		$('#indice').val(indice);
		
		//alert($('#big').height());
		if(mywidth!="*"&&myheight!="*"){
  		$('#big').imgAreaSelect({ 
  			handles: true,
  			x1: 0, y1: 0, x2: mywidth, y2: myheight,
  			fadeSpeed: 200,
  			resizeable:false,
  			maxHeight:myheight,
  			maxWidth:mywidth,			
  			minHeight:myheight,
  			minWidth:mywidth,
  			onSelectChange: preview
  			});
  			x2=mywidth;
  			y2=myheight;
		}
		if(mywidth!="*"&&myheight=="*"){
  		$('#big').imgAreaSelect({ 
  			handles: true,
  			fadeSpeed: 200,
  			resizeable:false,
  			x1: 0, y1: 0, x2: mywidth, y2: tabval[2],
  			maxWidth:mywidth,			
  			minWidth:mywidth,
  			minHeight:1,
  			maxHeight:tabval[2],
  			onSelectChange: preview
  			});
  			x2=mywidth;
  			y2=tabval[2];
		}
		if(mywidth=="*"&&myheight!="*"){
  		$('#big').imgAreaSelect({ 
  			handles: true,
  			fadeSpeed: 200,
  			resizeable:false,
  			x1: 0, y1: 0, x2: tabval[1], y2: myheight,
  			maxHeight:myheight,  			
  			minHeight:myheight,
  			minWidth:1,
  			maxWidth:tabval[1],
  			onSelectChange: preview
  			});
  			x2=tabval[1];
  			y2=myheight;
		}
		if(mywidth=="*"&&myheight=="*"){
  		$('#big').imgAreaSelect({ 
  			handles: true,
  			fadeSpeed: 200,
  			resizeable:false,
  			x1: 0, y1: 0, x2: tabval[1], y2: tabval[2],
  			maxHeight:tabval[2],  			
  			minHeight:1,
  			minWidth:1,
  			maxWidth:tabval[1],
  			onSelectChange: preview
  			});
  			x2=tabval[1];
  			y2=tabval[2];
		}
		//alert('ici');
		/*
		$('#x1').val(0);
    $('#y1').val(0);
    $('#width').val(x2);
    $('#height').val(y2);
    */
    preview($('#big'),{'x1':0,'y1':0,'x2':x2,'y2':y2,'width':x2,'height':y2})
    //alert($('#width').val());
		
		//'tbl_vignette'.$_SESSION['users_id'].'_'.$_POST['name'].'_'.$_POST['indice'].'.jpg'
		img=$('#uploaddir').val()+"tbl_"+indice+$('#newname').val()+'.jpg';
		//alert(img)
		var date = new Date();
		//on affiche la vignette si elle existe
		$('#div_upload_thumb').html('<img src="'+img+'?'+date.getTime()+'" />');
		
}
function preview(img, selection) {
    if (!selection.width || !selection.height)
        return;
    $('.x1').val(selection.x1);
    $('.y1').val(selection.y1);
    $('.x2').val(selection.x2);
    $('.y2').val(selection.y2);
    $('.width').val(selection.width);
    $('.height').val(selection.height);    
    //alert('ok');
}