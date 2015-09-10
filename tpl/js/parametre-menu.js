$(document).ready(function() {
 $('.ss_menu').hide();
 $('.active_menu02').parents('ul').find('.ss_menu').show();
 $('.see_more_param').css({'display':'block'});

    $('.see_more_param').click(function(){
      var that = this;
      $(that).parents('ul').find('.ss_menu').slideToggle(500, function() {
        if ($(this).is(':visible')) {
          $(that).attr('src',racineimg+'/tpl/img/moins_ico.png');
        } else {
          $(that).attr('src',racineimg+'/tpl/img/plus_ico.png');
        }
      });
    });
    $('.see_more_param2').click(function(e){
      e.preventDefault;
      var that = $(this).parents('ul');
      $(that).find('.ss_menu').slideToggle(500, function() {
        //alert($(this).is(':visible'));
        if ($(this).is(':visible')) {
          $(that).find('img').attr('src',racineimg+'/tpl/img/moins_ico.png');
        } else {
          $(that).find('img').attr('src',racineimg+'/tpl/img/plus_ico.png');
        }
      });
    });
});