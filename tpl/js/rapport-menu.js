$(document).ready(function(){
  $(".morecontent_tableau").hide(),
  $(".seemore_img").click(function(){
    var a=this;$(this).closest("tr").find("div").slideToggle(500,function(){
      $(this).is(":visible")?$(a).attr('src',racineimg+'/tpl/img/moins_ico.png'):$(a).attr('src',racineimg+'/tpl/img/plus_ico.png')})}),
  $("tr:odd").css({"background-color":"white",color:"#333132","z-index":"1"}),
  $(".datepicker").datepicker($.datepicker.regional.fr)}),
  $(".datepicker").datepicker({dateFormat:"dd/mm/yy"}),
  $(".timepicker").timepicker($.timepicker.regional.fr),
  $(function(){$(".timepicker").timepicker({showPeriodLabels:!1})}),
  $(function(){$("form").jqTransform({imgPath:"jqtransformplugin/img/"})

  
  //$('#agence_compterapport_butt').hide();
  $('#vehicule_compterapport_butt').click(function(){
    $('#rapport_vehicule_form').show();
    $('#compterapport_form').hide();
    $('#agence_compterapport_butt').show();
    $('#vehicule_compterapport_butt').hide();
  });
  //$('#rapport_vehicule_form').hide();
  $('#agence_compterapport_butt').click(function(){
    $('#rapport_vehicule_form').hide();
    $('#compterapport_form').show();
    $('#agence_compterapport_butt').hide();
    $('#vehicule_compterapport_butt').show();
  });
  $('#vehicule_compterapport_butt').click();
});

