$(function() {

/// load about
$("#show_details").click(function () {

  $("#about_details").slideToggle("slow");
}); 

function preview(img, selection) {
    if (!selection.width || !selection.height)
        return;
		
    //200 is the #preview dimension, change this to your liking
    var scaleX = 200 / selection.width; 
    var scaleY = 200 / selection.height;

    $('#preview img').css({
        width: Math.round(scaleX * $('#big').attr('width')),
        height: Math.round(scaleY * $('#big').attr('height')),
        marginLeft: -Math.round(scaleX * selection.x1),
        marginTop: -Math.round(scaleY * selection.y1)
    });
	
	
    $('.x1').val(selection.x1);
    $('.y1').val(selection.y1);
    $('.x2').val(selection.x2);
    $('.y2').val(selection.y2);
    $('.width').val(selection.width);
    $('.height').val(selection.height);    
}

$("form").submit(function() {
						  
	var fname = $(this).attr('name');
	
	//check if they have made a thumbnail selection
	if(fname == 'upload_thumb'){
		if($('#x1').val() =="" || $('#y1').val() =="" || $('#width').val() <="0" || $('#height').val() <="0"){
			alert("You must make a selection first");
			return false;
		}
	}
	
	$('#big').imgAreaSelect({hide:true});	
	$('#notice').text('Digesting..').fadeIn();							  
	
	$('#upload_target').unbind().load( function(){
												
		var img = $('#upload_target').contents().find('body ').html();

		if(fname == 'upload_big'){
		// load to preview image
		$('#preview').html(img);
		var img_id = 'big';
		/////// get image source , this will be passed into PHP
		$('.img_src').attr('value',img)				
		$('#preview').html('<img src="'+img+'" />');	
		}
		
		$('#div_'+fname).html('<img id="'+img_id+'" src="'+img+'" />');						

		if($(img).attr('class') != 'uperror'){
		$('#upload_thumb').show();
		//area select plugin http://odyniec.net/projects/imgareaselect/examples.html
		$('#big').imgAreaSelect({ 
			aspectRatio: '1:1', 
			handles: true,
			fadeSpeed: 200,
			resizeable:false,
			maxHeight:300,
			maxWidth:200,			
			minHeight:100,
			minWidth:50,			
			onSelectChange: preview
			});
		}
		else{
			//hide them
			$('#upload_thumb').hide();		
		}
		
		$('#notice').fadeOut();					
		
		// we have to remove the values
		$('.width , .height , .x1 , .y1 , #file').val('');
		
	  });
  });
	
});