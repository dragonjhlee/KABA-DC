<?php
/*
Plugin Name:	Flickr Press
Description:	Use this plugin to display your Flickr photosets on your WordPress site.
Version:		1.3.1
Author:			Anthony Ferguson
Author URI:		http://www.fergusweb.net/
Plugin URI:		http://www.fergusweb.net/software/flickr-press/
*/


// Definitions
define('FLICKR_PLUGIN_URL', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)));
define('FLICKR_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.basename(dirname(__FILE__)));

// Include required files
require_once(FLICKR_PLUGIN_DIR.'/phpflickr-3.0/phpFlickr.php');

if (is_admin()) {
	require_once(FLICKR_PLUGIN_DIR.'/flickr-admin.php');
} else {
	require_once(FLICKR_PLUGIN_DIR.'/flickr-public.php');
}

// Launch whichever class we loaded (public | admin)
new FlickrPress();



/**
 *	Extend the phpFlickr class to overwrite a few things.
 */
class phpFlickrPress extends phpFlickr {
	var $hide_private = true;
	var $max_cache_rows = 1000;
	var $cache_expire	= false;		// Seconds, from $this->enableCache()
	
	function enableCache($table, $cache_expire=600) {
		global $wpdb;
		// Set up connection
		$this->cache = 'db';
		$this->cache_table = $wpdb->prefix.$table;
		$this->cache_db = $wpdb->dbh;
		$this->cache_expire = $cache_expire;
		// Will remove any expired rows from database - runs on load.
		$sql = "DELETE FROM `{$this->cache_table}` WHERE `expiration` <= '".$this->current_time()."'";
		$wpdb->query($sql);
//		echo $sql.'<br><br>';
		
		return;	//??		Not using 'max_cache_rows' just yet.  Come back for this later.
		
		// If we have more than the max rows cached, purge all expired and start over
		$result = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM {$this->cache_table}", $this->cache_db));
		if ( $result[0] > $this->max_cache_rows ) {
			mysql_query("DELETE FROM $table WHERE expiration < DATE_SUB(NOW(), INTERVAL {$this->cache_expire} second)", $db);		// TODO:  Use WP time function instead of SQL. Consistent.
			mysql_query('OPTIMIZE TABLE ' . $this->cache_table, $db);
		}
	}
	
	// Use this for a request to filter private photos.  Calls parent request() to avoid duplicating a very big function
	function request($command, $args=array(), $nocache=false) {
		if ($this->hide_private) {
			$args['privacy_filter'] = 1;
		}
		parent::request($command, $args, $nocache);
	}
	
	function hash_request($request) {
		foreach ($request as $key=>$val) {
			if (empty($val) || $key=='api_sig')		unset($request[$key]);
			else									$request[$key] = (string) $val;
		}
		return md5(serialize($request));
	}
	function cache($request, $response) {
		global $wpdb;
		// Prep our 'request' key
		$hash = $this->hash_request($request);
		// Figure out if UPDATE or INSERT is appropriate
		$result = $wpdb->get_var("SELECT COUNT(*) FROM `{$this->cache_table}` WHERE `request` = '{$hash}'");
		if ($result) {
			$sql = "UPDATE `{$this->cache_table}` SET `response` = '".$wpdb->escape($response)."', `expiration` = '".$this->expiry_time()."' WHERE `request` = '{$hash}';";
		} else {
			$sql = "INSERT INTO `{$this->cache_table}` (`request` , `response` , `expiration`) VALUES ( '{$hash}', '".$wpdb->escape($response)."', '".$this->expiry_time()."' );";
		}
		$wpdb->query($sql);
	}
	
	function getCached($request) {
		global $wpdb;
		// Prep our 'request' key
		$hash = $this->hash_request($request);
		// Check database for cached result for this request.  Returns unparsed result, or FALSE
		$row = $wpdb->get_row("SELECT `response` FROM `{$this->cache_table}` WHERE `request` = '{$hash}' AND `expiration` > '".$this->current_time()."'");
		return (is_object($row)) ? $row->response : false;
	}
	
	function current_time() {
		return gmdate( 'Y-m-d H:i:s', (time() + (get_option('gmt_offset') * 3600)));
	}
	function expiry_time() {
		return gmdate( 'Y-m-d H:i:s', (strtotime("+{$this->cache_expire} seconds", time() + (get_option('gmt_offset') * 3600))));
	}
	
}



/**
 *	Base Class
 *		Contains our common functions & variables
 *		Other classes will extend this
 */
class FlickrPress_Base {
	protected $option_key	= 'flickr-options';
	protected $nonce		= 'flickrpress';
	protected $perms		= 'read';				// The permissions we require from Flickr
	protected $opts			= false;
	protected $flickr		= false;				// Will store our flickr wrapper when relevant.
	protected $cache_table	= 'flickr_cache';		// Use this for the Flickr Cache.  Prefix added later.

	// Default Options
	function load_default_options() {
		$this->opts = array(
			'api'				=> array( 'key'=>'', 'secret'=>''),
			'user'				=> array('ID'=>'', 'login'=>'', 'name'=>'', 'token'=>'', 'frob'=>''),
			'flickr_page'		=> false,
			'flickr_position'	=> 'below',	// insert before/after existing content (initial list of albums)
			'new_windows'		=> true,
			'hide_private'		=> true,
			'hide_albums'		=> array(),	// array of album IDs to NOT display on blog.
		);
	}
	// Option Helpers
	function load_options() {
		$this->opts = get_option($this->option_key);
		if (!$this->opts || !is_array($this->opts))		$this->load_default_options();
	}
	function save_options($options = false) {
		if (!$options) { $options = $this->opts; }
		update_option($this->option_key, $options);
		$this->load_options();
	}
	
	// $_POST cleaner : recursive
	function slash_array($array=false) {
		if (!is_array($array)) { return trim(stripslashes($array)); }
		foreach($array as $key=>$value) {
				$array[$key] = (!is_array($value)) ? trim(stripslashes($value)) : $this->slash_array($value);
		}
		return $array;
	}

	// Load the Flickr wrapper
	function load_flickr() {
		// Ensure options are loaded
		if (!$this->opts) return false;
		// Setup Object
		$this->flickr = new phpFlickrPress($this->opts['api']['key'], $this->opts['api']['secret']);
		$this->flickr->hide_private = $this->opts['hide_private'];
		$this->flickr->enableCache($this->cache_table);
	}
	
	// Create table on activation
	// Packaged class attempts creation on every call, this is a more efficient method
	function activation_hook() {
		global $wpdb;
		$this->cache_table = $wpdb->prefix.$this->cache_table;
		if ($wpdb->get_var("show tables like '{$this->cache_table}'") == $this->cache_table) return;
		$sql = "CREATE TABLE ".$this->cache_table." (
					request CHAR(35) NOT NULL,
					response MEDIUMTEXT NOT NULL,
					expiration DATETIME NOT NULL,
					INDEX (request)
				) TYPE = MYISAM;";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	
}















?>