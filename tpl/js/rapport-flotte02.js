/*
$( document ).ready(function() {
  $('form').jqTransform({imgPath:'jqtransformplugin/img/'});
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

  $( ".datepicker" ).datepicker( $.datepicker.regional[ "fr" ] );
  $(".datepicker").datepicker({
    dateFormat : 'dd/mm/yy',
  });

  $( ".timepicker" ).timepicker( $.timepicker.regional[ "fr" ] );
    $(function(){
      $('.timepicker').timepicker({
        showPeriodLabels: false,
      });
  });
});
*/