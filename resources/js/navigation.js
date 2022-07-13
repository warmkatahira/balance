$(function(){
    $(".nav-menu ").hover(function(){
      $(this).children(".nav-list").stop().slideToggle();
    });
});