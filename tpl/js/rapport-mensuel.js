$( document ).ready(function() {
  $(function(){
    $('form').jqTransform({imgPath:'jqtransformplugin/img/'});
  });

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