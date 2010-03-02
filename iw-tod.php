<?php
/*
Plugin Name: InvestorWords.com Term of the Day
Plugin URI: http://www.investorguide.com/article/6114/investorwords-com-term-of-the-day-wordpress-plugin/
Description: Display one investing term per day on the sidebar of your Wordpress blog
Author: InvestorGuide.com, Pinyo Bhulipongsanon
Version: 1.1
Author URI: http://www.investorwords.com/
*/


$tod_words_count = get_option('iw_tod_words_count');
$tod_style = get_option('iw_tod_style');
$tod_heading = get_option('iw_tod_heading');

if ($tod_words_count == "") { $tod_words_count = 99999; }
if ($tod_style != "") { $tod_style = '<style type="text/css">'.$tod_style.'</style>'; }

require_once (ABSPATH . WPINC . '/rss-functions.php');

add_action('admin_menu','iw_tod_options');

function iw_tod_options(){
	add_options_page('IW Investing Term', 'IW Investing Term', 5, 'investorwordscom-term-of-the-day/optionpage.php');


}

function displayTOD() {
	global $tod_words_count, $tod_style, $tod_heading;

	// here's where to insert the feed address
	$rss = @fetch_rss ('http://www.investorwords.com/rss/wp_iw_tod.php');

	if ( isset($rss->items) && 0 != count($rss->items) ) {

	echo $tod_style.'<div class="tod">'.$tod_heading;

	// here's (5) where to set the number of headlines
		$rss->items = array_slice($rss->items, 0, 30);

		foreach ($rss->items as $item ) {
			echo '<div class="todterm"><a href="'.wp_filter_kses($item['link']).'">'.wp_specialchars($item['title']).'</a></div>';
			echo '<div class="toddefinition">'.word_trim($item['description'],$tod_words_count).'</div>';
		}

	echo '</div>';
        }

}

/**
* Trim a string to a given number of words
*
* @param $string
*   the original string
* @param $count
*   the word count
* @param $ellipsis
*   TRUE to add "..."
*   or use a string to define other character
* @param $node
*   provide the node and we'll set the $node->
*  
* @return
*   trimmed string with ellipsis added if it was truncated
*/

function word_trim($string, $count, $ellipsis = TRUE) {
  $words = explode(' ', $string);
  if (count($words) > $count) {
    array_splice($words, $count);
    $string = implode(' ', $words);
    if (is_string($ellipsis)) {
      $string .= $ellipsis;
    } elseif ($ellipsis) {
      $string .= '&hellip;';
    }
  }
  return $string;
}

/* Widget Code */

function widget_IWTOD() {
  displayTOD();
}

function widget_IWTOD_init() {
  register_sidebar_widget(__('Investing Term of the Day'), 'widget_IWTOD');
}

add_action("plugins_loaded", "widget_IWTOD_init");
?>