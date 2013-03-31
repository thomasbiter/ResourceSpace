<?php
$directory = '.';
?>
<!doctype html>
<!-- Conditional comment for mobile ie7 blogs.msdn.com/b/iemobile/ -->
<!--[if IEMobile 7 ]>    <html class="no-js iem7" lang="en"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head> 
  <meta charset="utf-8" />

  <title>ResourceSpace</title>
  <meta name="description" content="Media for OpenSource" />

  <!-- Mobile viewport optimization h5bp.com/ad -->
  <meta name="HandheldFriendly" content="True" />
  <meta name="MobileOptimized" content="320" />
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />

  <!-- Home screen icon  Mathias Bynens mathiasbynens.be/notes/touch-icons -->
  <!-- For iPhone 4 with high-resolution Retina display: -->
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $directory ?>/img/h/apple-touch-icon.png" />
  <!-- For first-generation iPad: -->
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $directory ?>/img/m/apple-touch-icon.png" />
  <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
  <link rel="apple-touch-icon-precomposed" href="<?php echo $directory ?>/img/l/apple-touch-icon-precomposed.png" />
  <!-- For nokia devices: -->
  <link rel="shortcut icon" href="<?php echo $directory ?>/img/l/apple-touch-icon.png" />
    
    <!-- iOS web app, delete if not needed. https://github.com/h5bp/mobile-boilerplate/issues/94 -->
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" /> 
  <!-- <script>(function(){var a;if(navigator.platform==="iPad"){a=window.orientation!==90||window.orientation===-90?"img/startup-tablet-landscape.png":"img/startup-tablet-portrait.png"}else{a=window.devicePixelRatio===2?"img/startup-retina.png":"img/startup.png"}document.write('<link rel="apple-touch-startup-image" href="'+a+'"/>')})()</script> -->
  
  <!-- The script prevents links from opening in mobile safari. https://gist.github.com/1042026 -->
  <!-- <script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script> -->
  
  <!-- Mobile IE allows us to activate ClearType technology for smoothing fonts for easy reading -->
  <!--<meta http-equiv="cleartype" content="on">-->

  <!-- more tags for your 'head' to consider h5bp.com/d/head-Tips -->
  
  
  <!-- fonts -->
  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css' />

  <!--<link href='http://fonts.googleapis.com/css?family=Quattrocento:400,700' rel='stylesheet' type='text/css'>-->
  
  <!--<link rel="stylesheet" href="<?php echo $directory ?>/css/style.less">-->
  <link rel="stylesheet" href="<?php echo $directory ?>/css/reset.css" />
  <link rel="stylesheet" href="<?php echo $directory ?>/css/flexslider.css" />
    
  <link rel="stylesheet" href="<?php echo $directory ?>/css/photoswipe/photoswipe.css" />
  <!--<link rel="stylesheet" href="<?php echo $directory ?>/css/jquery-ui-1.8.16.custom.css">-->
  

    
  <link rel="stylesheet/less" href="<?php echo $directory; ?>/css/style.php?theme=black" />
  
  <script src="<?php echo $directory ?>/js/less-1.3.0.min.js"></script>
  
   <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0-rc.1/jquery.mobile-1.2.0-rc.1.min.css" />
<script src="http://code.jquery.com/jquery-1.8.1.min.js"></script>

  
  <!--validation for older browsers (if) -->
  
  
  <script src="<?php echo $directory ?>/js/iscroll.js"></script>
  <script src="<?php echo $directory ?>/js/jquery.flexslider-min.js"></script>
  <script src="<?php echo $directory ?>/js/photoswipe/klass.min.js"></script>
  <script src="<?php echo $directory ?>/js/photoswipe/code.photoswipe.jquery-3.0.5.min.js"></script>
  <script>
    $(document).bind("mobileinit", function(){
      $.mobile.defaultPageTransition = 'fade';        //$.mobile.defaultPageTransition = 'slide';
          $.mobile.ignoreContentEnabled = true;
            //$.mobile.ajaxEnabled = false;
    });
  </script>
  <script src="http://code.jquery.com/mobile/1.2.0-rc.1/jquery.mobile-1.2.0-rc.1.min.js"></script>
 
  

  <!--
  <script src="<?php echo $directory ?>/js/hammer/hammer.js"></script>
  <script src="<?php echo $directory ?>/js/hammer/jquery.hammer.js"></script>
  -->
  
  <script src="<?php echo $directory ?>/js/helper.js"></script>
  <script src="<?php echo $directory ?>/js/script.js"></script>
  <!-- end scripts-->

  
  
  <!-- Main Stylesheet -->
  <!--<link rel="stylesheet" href="<?php echo $directory ?>/css/style.css">-->
  
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  
  <script src="<?php echo $directory ?>/js/libs/modernizr-2.0.6.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
