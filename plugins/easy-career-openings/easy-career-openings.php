<?
/*  
 * Plugin Name: Easy Career Openings
 * Plugin URI: http://digitalmcgrath.com
 * Description: The purpose of this plugin is to give users the ability to add career openings to their WordPress blog/site.
 * Version: 0.4
 * Author: Chris McGrath (@digitalmcgrath)
 * Author URI: http://digitalmcgrath.com
*/

class Easy_Career_Openings {
	public static $instance;
	
	function __construct() {
		self::$instance = $this;
		register_activation_hook(__FILE__,array($this,'activate'));
		register_deactivation_hook(__FILE__,array($this,'deactivate'));
		add_action('plugins_loaded', array($this, 'plugins_loaded'));
	}

	public function plugins_loaded() {
		add_action('admin_menu', array( $this, 'eco_menu' ));
		add_action('admin_head', array( $this, 'eco_admin_register_head'));
    if (! get_option('eco-career-application-page')){
        $my_app_page = array(
      'post_title' => 'Apply For Position',
      'post_content' => '[ecoapplication]',
      'post_status' => 'publish',
      'post_author' => 1,
      'post_type' => 'page'
      );
      $eco_app_page_created = wp_insert_post( $my_app_page );
      $ecoapppermalink = get_permalink( $eco_app_page_created );
      update_option('eco-career-application-page', $ecoapppermalink);
    }
	}
	public function eco_admin_register_head() {
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/includes/css/eco_styles.css';

    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
    }

    //Activation function
    public function activate(){
    	global $wpdb;
    	$eco_table_prefix=$wpdb->prefix.'eco_';
		define('ECO_TABLE_PREFIX', $eco_table_prefix);
		$table = ECO_TABLE_PREFIX."career_openings";
    	$structure = "CREATE TABLE $table (
  		`id` int(11) NOT NULL AUTO_INCREMENT,
  		`JobTitle` varchar(255) DEFAULT NULL,
  		`ContactName` varchar(255) DEFAULT NULL,
  		`ContactEmail` varchar(255) DEFAULT NULL,
  		`JobBody` text,
  		`HoursPerWeek` varchar(100) DEFAULT NULL,
  		`PostingCity` varchar(255) DEFAULT NULL,
  		`PostingState` varchar(100) DEFAULT NULL,
  		`PostingPostalCode` varchar(25) DEFAULT NULL,
  		`JobClassification` varchar(255) DEFAULT NULL,
  		`PostDate` date NOT NULL,
  		PRIMARY KEY (`id`)
		);";
    	$wpdb->query($structure);

    	// Create post object
  		$my_post = array(
     	'post_title' => 'Career Details',
     	'post_content' => '[ecodetails]',
     	'post_status' => 'publish',
     	'post_author' => 1,
     	'post_type' => 'page'
  		);

		// Insert the post into the database
  		$eco_page_created = wp_insert_post( $my_post );
  		$ecopermalink = get_permalink( $eco_page_created );
  		update_option('eco-career-details-page', $ecopermalink);
  		$my_app_page = array(
  		'post_title' => 'Apply For Position',
  		'post_content' => '[ecoapplication]',
  		'post_status' => 'publish',
  		'post_author' => 1,
  		'post_type' => 'page'
  		);
  		$eco_app_page_created = wp_insert_post( $my_app_page );
  		$ecoapppermalink = get_permalink( $eco_app_page_created );
  		update_option('eco-career-application-page', $ecoapppermalink);
  		}	

	//Deactivation function
	public function deactivate(){
		global $wpdb;
		$eco_table_prefix=$wpdb->prefix.'eco_';
		define('ECO_TABLE_PREFIX', $eco_table_prefix);
    	$table = ECO_TABLE_PREFIX."career_openings";
    	$structure = "drop table if exists $table";
    	$wpdb->query($structure);
    	
	}

	public function eco_menu(){
	add_menu_page('Easy Career Openings','Careers','read','eco-plugin',array($this, 'main'));
	//add_submenu_page('eco-plugin','Settings', 'Settings','read','eco-settings',array($this, 'eco_settings'));
	}
	public function eco_settings() {
		$this->plugin_title();
		include('includes/forms/eco_settings.php');
	}
	public function main() {
		$this->plugin_title();
		switch ($_REQUEST['action']):
    		case 'add':
        		$this->position();
        	break;
    		case 'edit':
        		$this->position();
        	break;
    		case 'delete':
        		$this->delete_position();
        	break;
    		default:
        		$this->current_positions();
			endswitch;	
	}
	function plugin_title(){
		echo '<div id="icon-themes" class="icon32"></div><h2>Easy Career Openings</h2><br/>';
	}
	function current_positions(){
		echo '<a class="button-secondary" href="admin.php?page=eco-plugin&action=add" title="Add Posting">Add Career Opening</a><br/><br/>';
		echo 'Current Positions'; 
		echo '<table class="widefat" width="80%">';
		echo '	<thead>';
    	echo '		<tr>';
      echo '			<th>Job Title</th>';
      echo '			<th>City</th>';
      echo '			<th>State</th>';
      echo '			<th>Contact</th>';
      echo '			<th>Actions</th>';
    	echo '		</tr>';
		echo '	</thead>';
		echo '	<tfoot>';
    	echo '		<tr>';
      echo '			<th>Job Title</th>';
      echo '			<th>City</th>';
      echo '			<th>State</th>';
      echo '			<th>Contact</th>';
      echo '			<th>Actions</th>';
    	echo '		</tr>';
		echo '	</tfoot>';
		echo '	<tbody>';
		//Loop over the current postings
		foreach($this->get_positions() as $key => $row) {
		
   		echo ' 	<tr>';
     	echo '			<td>'.$row->JobTitle.'</td>';
     	echo '			<td>'.$row->PostingCity.'</td>';
     	echo '			<td>'.$row->PostingState.'</td>';
   		echo '			<td>'.$row->ContactName.'</td>';
   		echo '			<td><a href="'.get_option('eco-career-details-page').'?jobid='.$row->id.'" target="_blank">[PREVIEW]</a>&nbsp;&nbsp;&nbsp;<a href="admin.php?page=eco-plugin&action=edit&jobid='.$row->id.'">[EDIT]</a>&nbsp;&nbsp;&nbsp;<a href="admin.php?page=eco-plugin&action=delete&jobid='.$row->id.'">[DELETE]</a></td>';
   		echo '		</tr>';
   		}
		echo'	</tbody>';
		echo '</table>';
	}

	
	//Delete position
	function delete_position(){
		include('includes/forms/delete.php');
		
	}

	//Add new position
	function position(){
		include('includes/forms/position.php');
	}

	function get_positions() {
	global $wpdb;
	$eco_get_positions_sql = "SELECT id, JobTitle, ContactName, PostingCity, PostingState FROM ".$wpdb->prefix."eco_career_openings ORDER BY ID DESC";
	$eco_get_positions = $wpdb->get_results($eco_get_positions_sql);
	return $eco_get_positions;
}
	
}
//Initialize the class
new Easy_Career_Openings();

//Shorcodes for the list.
function EcoPostingListShortCode() {
	//return '<p>Hello World!</p>';
	include('includes/shortcodes/posting_list.php');
}
add_shortcode('ecolist', 'ECOPostingListShortCode');
//Shortcode for the details
function EcoPostingDetailsShortCode() {
	//return '<p>Hello World!</p>';
	include('includes/shortcodes/posting_details.php');
}
add_shortcode('ecodetails', 'EcoPostingDetailsShortCode');

//Shortcode for the application
function EcoPostingApplicationShortCode(){
	include('includes/shortcodes/posting_application.php');
}
add_shortcode('ecoapplication', 'EcoPostingApplicationShortCode');



?>