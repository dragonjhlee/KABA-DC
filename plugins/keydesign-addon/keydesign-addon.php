<?php
/*
	Plugin Name: KeyDesign Addon
	Plugin URI: http://keydesign-themes.com/
	Author: KeyDesign
	Author URI: http://keydesign-themes.com/
	Version: 1.9.5
	Description: KeyDesign Core Plugin for Intact Theme
	Text Domain: keydesign
*/

/*
	If accesed directly, exit.
*/
if (!defined('ABSPATH')) die('-1');

if (!defined('__KEYDESIGN_ROOT__')){
	define('__KEYDESIGN_ROOT__', dirname(__FILE__));
}

if (!defined('KEYDESIGN_PLUGIN_PATH')){
	define('KEYDESIGN_PLUGIN_PATH', dirname(__FILE__));
}

if (!class_exists('KEYDESIGN_ADDON_CLASS')) {

	add_action('admin_init','initiate_keydesign_addon');
	function initiate_keydesign_addon() {
		if( defined('WPB_VC_VERSION') ){
			if( version_compare( 5.4, WPB_VC_VERSION, '>' )){
				add_action( 'admin_notices', 'keydesign_version_notice' );
				add_action( 'network_admin_notices','keydesign_version_notice' );
			}
		} else {
			add_action( 'admin_notices', 'keydesign_activation_notice' );
			add_action( 'network_admin_notices','keydesign_activation_notice' );
		}
	}

	/* Verify VC version and activation */
	function keydesign_version_notice() {
		$is_multisite = is_multisite();
		$is_network_admin = is_network_admin();
		if( ( $is_multisite && $is_network_admin ) || !$is_multisite ) {
			echo '<div class="updated">
				<p>'.__('The','keydesign').' <strong>Keydesign Addon</strong> '.__('plugin requires','keydesign').' <strong>WPBakery Page Builder</strong> '.__('version 5.4 or greater.','keydesign').'</p>
			</div>';
		}
	}

	function keydesign_activation_notice() {
		$is_multisite = is_multisite();
		$is_network_admin = is_network_admin();
		if( ( $is_multisite && $is_network_admin) || !$is_multisite ) {
			echo '<div class="updated">
				<p>'.__('The','keydesign').' <strong>KeyDesign Addon</strong> '.__('plugin requires','keydesign').' <strong>WPBakery Page Builder</strong> '.__('Plugin installed and activated.','keydesign').'</p>
			</div>';
		}
	}

	/*	Load plugin textdomain. */
	add_action( 'plugins_loaded', 'keydesign_addon_load_textdomain' );
	function keydesign_addon_load_textdomain() {
		load_plugin_textdomain( 'keydesign', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/* Activation hook */
	register_activation_hook( __FILE__, 'keydesign_addon_activate' );
	function keydesign_addon_activate() {
		update_option('keydesign_addon_version', '1.9.5' );
	}

	/* Allow SVG icon upload */
	function keydesign_svg_upload( $mimes ){
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	add_filter( 'upload_mimes', 'keydesign_svg_upload' );

	class KEYDESIGN_ADDON_CLASS {
		function __construct() {
			$this->elements_folder	=	plugin_dir_path( __FILE__ ).'elements/';
			$this->params_dir = plugin_dir_path( __FILE__ ).'params/';
			add_action( 'after_setup_theme', array( $this, 'integrate_with_vc' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'keydesign_load_front_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'keydesign_load_admin_scripts') );
			add_action( 'init', array( $this, 'keydesign_init_portfolio_cpt' ), 1 );
		}

		public function integrate_with_vc() {
			if( class_exists( 'WPBakeryShortCode' ) ) {
				foreach(glob($this->elements_folder."/*.php") as $elem) {
					require_once($elem);
				}
				foreach(glob($this->params_dir."/*.php") as $param)
				{
					require_once($param);
				}
			}
		}

		public function keydesign_init_portfolio_cpt() {
			require_once ( trailingslashit( KEYDESIGN_PLUGIN_PATH ) . 'custom-post-type.php' );
		}

		public function keydesign_load_front_scripts() {
			// Register & Load plug-in main style sheet
			wp_register_style( 'kd_addon_style', plugins_url('assets/css/kd_vc_front.css', __FILE__));
			wp_enqueue_style( 'kd_addon_style' );

			// Easing Script
			wp_register_script( 'kd_easing_script', plugins_url('assets/js/jquery.easing.min.js', __FILE__), array('jquery') );
			wp_enqueue_script ( 'kd_easing_script' );

			// OWL Carousel
			wp_register_script( 'kd_carousel_script', plugins_url('assets/js/owl.carousel.min.js', __FILE__), array('jquery') );
			wp_enqueue_script ( 'kd_carousel_script' );

			// Easy Tabs
			wp_register_script( 'kd_easytabs_script', plugins_url('assets/js/jquery.easytabs.min.js', __FILE__), array('jquery') );
			wp_enqueue_script ( 'kd_easytabs_script' );

	    // Countdown Element
			wp_register_script( 'kd_countdown_script', plugins_url('assets/js/jquery.countdown.js', __FILE__), array('jquery') );

			// Pie Chart Element
			wp_register_script( 'kd_easypiechart_script', plugins_url('assets/js/jquery.easypiechart.min.js', __FILE__), array('jquery') );

			// Event session Element
			wp_register_script( 'kd_jquery_appear', plugins_url('assets/js/jquery.appear.js', __FILE__), array('jquery') );
			wp_enqueue_script ( 'kd_jquery_appear' );

			// Register & Load Photoswipe
			wp_register_style( 'photoswipe', plugins_url('assets/css/photoswipe.css', __FILE__));
			wp_register_style( 'photoswipe-skin', plugins_url('assets/css/photoswipe-default-skin.css', __FILE__));
			wp_register_script( 'photoswipejs', plugins_url('assets/js/photoswipe.min.js', __FILE__), array('jquery') );
			wp_register_script( 'photoswipejs-ui', plugins_url('assets/js/photoswipe-ui-default.min.js', __FILE__), array('jquery') );

			// Progressbar element
			wp_register_script( 'kd_progressbar', plugins_url('assets/js/kd_progressbar.js', __FILE__), array('jquery') );

			// Counter element
			wp_register_script( 'kd_countto', plugins_url('assets/js/kd_countto.js', __FILE__), array('jquery') );

			// Iconsmind font pack resources
			wp_register_style( 'kd_iconsmind', plugins_url('assets/css/iconsmind.min.css', __FILE__));

			// Plugin Front End Script
			wp_register_script( 'kd_addon_script', plugins_url('assets/js/kd_addon_script.js', __FILE__), array('jquery') );
			wp_enqueue_script ( 'kd_addon_script' );
		}

		public function keydesign_load_admin_scripts() {
			wp_enqueue_style( 'kd_iconsmind', plugins_url('assets/css/iconsmind.min.css', __FILE__));
		}

	}
}
// Finally initialize code
new KEYDESIGN_ADDON_CLASS();
