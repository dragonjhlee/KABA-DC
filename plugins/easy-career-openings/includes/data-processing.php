<?php 

//Returns all current corporate postings
function get_positions() {
	global $wpdb;
	$eco_get_positions_sql = "SELECT id, JobTitle, ContactName, PostingCity, PostingState FROM ".$wpdb->prefix."eco_career_openings ORDER BY ID ASC";
	$eco_get_positions = $wpdb->get_results($eco_get_positions_sql);
	return $eco_get_positions;
}