$(document).ready(function() {
    $("form").jqTransform({imgPath:"jqtransformplugin/img/"});
    
    $(".morecontent_tableau").hide(),
    $("tr:odd").css({"background-color":"white",color:"#333132","z-index":"1"});
    $("tr:odd").find("a").css({"background-color":"white",color:"#333132","z-index":"1"});
    $("tr:even").find("input").css({"border":"none"});
    $(".seemore_img").click(function(){
    var a=this;$(this).closest("tr").find("div").slideToggle(500,function(){
    $(this).is(":visible")?$(a).attr("src",racineimg+"/tpl/img/moins_ico.png"):$(a).attr("src",racineimg+"/tpl/img/plus_ico.png")})});
  
});