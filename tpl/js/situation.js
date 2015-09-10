// This is a file copied by your subgenerator.
$( document ).ready(function() {
  var plusmoins = 0;

  $('.morecontent_tableau').hide();

  $('tr:odd')
        .css({
          "background-color" : "white",
          "color" : "#333132",
          "z-index" : "1"
  });


  $('.seemore_img').click(function(){
    var that = this;
    $(this).closest("tr").find("div").slideToggle(500, function() {
      if ($(this).is(':visible')) {
        $(that).attr('src',racineimg+'/tpl/img/moins_ico.png');
      } else {
        $(that).attr('src',racineimg+'/tpl/img/plus_ico.png');
      }
    });
      
  })
    $(function(){
      $('form').jqTransform({imgPath:'jqtransformplugin/img/'});
    });
});




  //$('.seemore_img').click(function(){
    //if(imgSrc.contains(imgPlus)){
      //img.closest("tr").find("div").slideDown(500);
      //img.attr('src','img/moins_ico.png');
    //}
    //  $(this).closest("tr").find("div").slideUp(500);
     // $(this).attr('src','img/plus_ico.png');
  //});
  
$(document).ready(function() {
	$(".fancyiframe").fancybox({
		width	: "600px",
		height	: "600px",
		fitToView	: false,		
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
});
