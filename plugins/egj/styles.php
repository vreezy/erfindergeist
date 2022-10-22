<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// we need this to load the parent styles
// https://developer.wordpress.org/themes/advanced-topics/child-themes/
function erfindergeist_styles()
{
   wp_enqueue_style(
      'loading-shimmer-style',
      plugins_url( '/', __FILE__ ) . 'loading-shimmer.css',
      // get_stylesheet_directory_uri() . '/styles/loading-shimmer.css',
      array(),
      1.0
   );

   wp_enqueue_style(
      'discord-style',
      // get_stylesheet_directory_uri() . '/styles/discord.css',
      plugins_url( '/', __FILE__ ) . 'discord.css',
      array(),
      1.0
   );

   wp_enqueue_script( 
      'gcalendar-script',
      // get_stylesheet_directory_uri() . '/js/gcalendar.js',
      plugins_url( '/', __FILE__ ) . 'gcalendar.js',
      array('jquery'),
      1.3,
      true
   );

   wp_enqueue_script( 
      'discord-script',
      // get_stylesheet_directory_uri() . '/js/discord.js',
     plugins_url( '/',  __FILE__ ) . 'discord.js',
      array('jquery'),
      1.3,
      true
   );
}
add_action('wp_enqueue_scripts', 'erfindergeist_styles');