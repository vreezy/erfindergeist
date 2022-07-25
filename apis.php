<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// CUSTOM APIS
// https://egj.vreezy.de/wp-json/erfindergeist/v1/gcalendar
add_action('rest_api_init', function () {
   register_rest_route('erfindergeist/v1', '/gcalendar', array(
      'methods'  => 'GET',
      'callback' => 'gcalendar'
   ));
});

https://egj.vreezy.de/wp-json/erfindergeist/v1/discord
add_action('rest_api_init', function () {
   register_rest_route('erfindergeist/v1', '/discord', array(
      'methods'  => 'GET',
      'callback' => 'discord'
   ));
});


function gcalendar($request)
{

   $apikey_opt_name = 'g_Calendar_apikey';
   $google_calendar_id_opt_name = 'g_Calendar_id';

   if(!get_option( $apikey_opt_name ) && !get_option(  $google_calendar_id_opt_name )) {
      return new WP_Error('rest_custom_error', 'Apikey is not set', array('status' => 400));
   }

   $dateTime = new DateTime();
   
   $currentDate = $dateTime->format(DateTimeInterface::RFC3339);
   
   // google api dislike +00:00. replace with Z
   $currentDate = str_replace("+00:00", "Z", $currentDate);

   // $gCalendarId = "07ioi5n94ai52i862agbh13tgc%40group.calendar.google.com";
   // $gCalendarApiKey = ""; // AIzaSyBUtiIjAkRXpKa6Eat5triW8x3W-QDNNxU
   
   $gCalendarApiKey = get_option( $apikey_opt_name );
   $gCalendarId = get_option( $google_calendar_id_opt_name );
   $url = 'https://www.googleapis.com/calendar/v3/calendars/'.$gCalendarId.'/events?maxResults=5&orderBy=startTime&singleEvents=true&timeMin=' . $currentDate . '&key='.$gCalendarApiKey;
   
   $content = file_get_contents($url);
 
   $response = new WP_REST_Response(json_decode($content, true)); 
   $response->set_status(200);

   return $response;
}


function discord($request)
{
   $erfindergeist_discord_iframe_html_opt_name = 'erfindergeist_discord_iframe_html';
   
   if(!get_option( $erfindergeist_discord_iframe_html_opt_name ) ) {
      return new WP_Error('rest_custom_error', 'Error finding option', array('status' => 400));
   }

   $erfindergeist_discord_iframe_html_opt_value = stripslashes(get_option( $erfindergeist_discord_iframe_html_opt_name ));

   $response = new WP_REST_Response($erfindergeist_discord_iframe_html_opt_value); 
   $response->set_status(200);

   return $response;

}