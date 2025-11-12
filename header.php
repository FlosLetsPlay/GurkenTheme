<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Aktuelle Nachrichten rund um Gukistan.">
	<meta name="keywords" content="Gurkistan, News, GurkenSchau, Plankton">
	<meta name="author" content="Emotional-Complex-61, ugurkenschau, GurkenSchau">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="application-name" content="GurkenSchau">
    <meta name="theme-color" content="rgb(213,69,27)">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
  	<!-- Open Graph Protocol Anfang -->
  	<meta property="og:image" content="https://gurkenschau.eu/wp-content/uploads/2025/09/opengraph_logo.avif">
  	<meta property="og:title" content="GurkenSchau &#8211; aktuelle Nachrichten rund um Gurkistan">
  	<meta property="og:description" content="aktuelle Nachrichten rund um Gurkistan">
  	<meta property="og:type" content="website">
  	<meta property="og:url" content="https://gurkenschau.eu">
  	<meta property="og:site_name" content="GurkenSchau">
  	<!-- Open Graph Protocol Ende   -->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <div class="sidebar w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:70px;" id="mySidebar">
  <nav>
  <span class="w3-bar-item w3-hide-large" onclick="w3_close()" style="cursor: pointer;">
	  <img src="<?php echo get_theme_root_uri() ?>/assets/sitebar/close.svg" alt="close"></span>
    <a href="/" title="Startseite"><img src="<?php echo get_theme_root_uri() ?>/assets/sitebar/home.svg" alt="Home"></a>
    <a href="mailto:kontakt@gurkenschau.eu" title="Mail"><img src="<?php echo get_theme_root_uri() ?>/assets/sitebar/mail.svg" alt="Mail"></a>
	<a href="/ueber-uns" title="Über die GurkenSchau"><img src="<?php echo get_theme_root_uri() ?>/assets/sitebar/info.svg"></a>
    <a href="/youtube" class="w3-tooltip" title="GurkenSchau auf YouTube"><span style="position:absolute;left:0;bottom:7px" class="w3-text w3-tag w3-small"><?php echo do_shortcode('[youtube_subs label="" format="compact" wrap="div" class="yt-subs-badge"]')?></span><img title="GurkenSchau auf YouTube" width="32" alt="YouTube icon" src="<?php echo get_theme_root_uri() ?>/assets/sitebar/youtube.png"></a>
  <span class="dm-sw"><?php echo do_shortcode('[wp_dark_mode style="1"]');?></span>
  </nav>
  <!--Standard-->
<?php
	  echo '<span class="sidebar-emoji" aria-hidden="true">'
     . esc_html( gurkenschau_get_sidebar_emoji() )
     . '</span>';

	  ?>  
 
</div>
<div class="w3-panel">
<div class="w3-xlarge w3-hide-large w3-display-topleft w3-center" style="z-index:1;background-color:var(--main-color);padding: 10px;cursor: pointer;" onclick="w3_open()">
	<img src="<?php echo get_theme_root_uri() ?>/assets/sitebar/menu.svg" alt="menu"></div>
<div class="w3-center w3-padding"><a href="/"><img style="width:30rem;" src="<?php echo get_theme_root_uri() ?>/assets/herbst-header.png"></a></div>
<div style="margin-left:75px"><?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?></div>
</div>
