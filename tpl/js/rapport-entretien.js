$( document ).ready(function() {
  $(function(){
    $('form').jqTransform({imgPath:'jqtransformplugin/img/'});
  });
  var plusmoins = 0;
  $('.morecontent_tableau').hide();

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

  $('tr:odd')
        .css({
          "background-color" : "white", 
          "color" : "#333132",
          "z-index" : "1"
  });
});