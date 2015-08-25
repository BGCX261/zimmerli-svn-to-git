$(document).ready(function() {
$(document).click(function(e){var elem = $("#enter:not(.vis), #registration:not(.vis), .lk, #size-table");if(e.target!=elem[0]&&!elem.has(e.target).length){ elem.hide();$('#alpha').hide();$('a.lk-but').removeClass('opened'); } })
$('a.enter').click(function() {
$('#alpha, #enter:not(.vis)').show();
return false
})
$('#for-him>li>a').click(function(){
$(this).parent().find('>ul').slideToggle();
$('#for-her>li>ul').slideUp();
return false
})
$('#for-her>li>a').click(function(){
$(this).parent().find('>ul').slideToggle();
$('#for-him>li>ul').slideUp();
return false
})
$('a.basket').click(function(){
$(this).toggleClass('active');
$('#basket').toggle();
return false
})
$('.reg .regi a').click(function() {
$('#enter').hide();
$('#registration:not(.vis)').show();
return false
})
$('a.registration').click(function() {
$('#alpha, #registration:not(.vis)').show();
return false
})
$('a.lk-but').click(function() {
$(this).parent().find('.lk').toggle();
$(this).toggleClass('opened');
return false
})
$('#prod-list li:nth-child(4n+4)').addClass('foth');

$('.small-img a.photo1').live('click',function() {
$('.big-image img').remove();
$('.big-image').html('<a class="zoom" href="'+$(this).attr('href')+'" rel="prettyPhoto"></a><img src="'+$(this).attr('href')+'" />');
$(this).parent().find('.active').removeClass('active');
$(this).addClass('active');
$("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'facebook',slideshow:0, autoplay_slideshow: false,social_tools:false,deeplinking:false});
return false
})



$('.colors a').click(function() {
$(this).parent().find('input').attr('checked', false);
$(this).parent().find('input#'+$(this).attr('rel')).attr('checked',true);
$(this).parent().find('a.active').removeClass('active');
$(this).addClass('active');
return false
});
$('.sizes a').click(function() {
$(this).parent().find('input').attr('checked', false);
$(this).parent().find('input#'+$(this).attr('rel')).attr('checked',true);
$(this).parent().find('a.active').removeClass('active');
$(this).addClass('active');
return false
}
 );
$('table tr:nth-child(2n+3)').css({'background':'#f1f2f5'});
$('a.size-table').click(function(){
$('#size-table, #alpha').show();
return false
})
$('#size-table h4 span').click(function() {$(this).parent().parent().hide();$('#alpha').hide();})
$('.additional ul li:last-child').css({'margin-right':'0'});
$('a.minus').click(function(){
var cnt = parseInt($(this).parent().find('.num').val());
if(cnt > 0) {
$(this).parent().find('.num').val(cnt-1);
$(this).parent().find('.numnum').text(cnt-1);
}
return false
})
$('a.plus').click(function(){
var cnt = parseInt($(this).parent().find('.num').val());
$(this).parent().find('.num').val(cnt+1);
$(this).parent().find('.numnum').text(cnt+1);
return false
})
$('img').each(function() {
var i = $(this).attr('align');
if(i == 'left') {$(this).addClass('left')}
else if (i == 'right') {$(this).addClass('right');}
});
});