<!DOCTYPE HTML>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="%description%" />
    <meta name="keywords" content="%keywords%" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>%title%</title>

    <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link type="text/css" rel="stylesheet" href="/templates/demoold/css/layout.css?%system_build%" media="all" />        
    
    %system includeQuickEditJs()%
    %system includeEditInPlaceJs()%
    <script src="/js/faq.js"></script>
    <script src="/js/prettyCheckable.js"></script>
    <script>
    $().ready(function(){
      $('#size-box input[type="checkbox"],#size-box input[type="radio"]').prettyCheckable();
    });
    </script>

    <!--[if lt IE 9]>
    <script src="/js/html5.js"></script>
        <script src="/js/ie.js"></script>
        <link rel="stylesheet" href="/templates/demoold/css/ie.css" media="all" />
    <![endif]-->
    <link rel="stylesheet" href="/templates/demoold/css/anythingslider.css">
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" href="/js/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
    <script src="/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
    
    <script src="/js/jquery.anythingslider.min.js"></script>
    <script>
      $(function(){
      $('#slider').anythingSlider({
      theme           : 'metallic',
      resizeContents      : false,
      buildArrows         : true,
      buildStartStop      : false,
      hashTags            : false,
      autoPlay            : true,
      delay               : 5000,
      expand: true,
      buildNavigation: false
    })
    
    
    $('#gal-slider').anythingSlider({
    theme           : 'metallic',
    resizeContents      : false,
    buildArrows         : true,
    buildStartStop      : false,
    hashTags            : false,
    autoPlay            : false,
    showMultiple        : 3,
    expand: false,
    buildNavigation: false
  })
   
});
    function change_foto(id,small_foto,big_foto) {
$('.big-image img').remove();
$('.big-image').html('<a class="zoom" href="'+big_foto+'" rel="prettyPhoto"></a><img src="'+small_foto+'" />');
$('#'+id).parent().find('.active').removeClass('active');
$('#'+id).addClass('active');
$("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'facebook',slideshow:0, autoplay_slideshow: false,social_tools:false,deeplinking:false});
return false
}        
    </script>
 
</head>
<body>
  <header>
    <div class="logo">
      <a href="/"></a>
    </div>
    <div class="top-more">
      %users auth('header')%  

      <div class="call">
        <span>%custom get_header_phone_number()%</span>
        звоните с 9 00 до 20 00
      </div>
      <div class="info">
        Производится в Швейцарии. С 1871 года.
      </div>
    </div>
    %users registrate()%
  </header>
  <nav id="top" class="main-page">
    %menu%
    %emarket cart('top_cart')%
    
  </nav>

