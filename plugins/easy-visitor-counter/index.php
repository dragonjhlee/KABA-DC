<?php 
/*
Plugin Name: Visitor Counter Plugin
Description: Add the visitor counter widget to your website. 
Version: 1.0
Author: visitorcounterplugin.com
Author URI: http://visitorcounterplugin.com
License: GPLv2
*/


class VisitorCounterPlugin_Widget extends WP_Widget {
     
    function __construct() {
        parent::__construct(
         
            // base ID of the widget
            'vistorcounterplugin_widget',
             
            // name of the widget
            __('Visitor Counter Widget', 'VisitorCounterPlugin' ),
             
            // widget options
            array (
                'description' => __( 'Widget to display daily, weekly and monthly visitor count', 'VisitorCounter' )
            )
             
        );
    }
     
    function form( $instance ) {
    }
     
    function update( $new_instance, $old_instance ) {       
    }
     
    function widget( $args, $instance ) {
        echo '
        <aside class="widget" id="visitor-counter">
        <h2 class="visitor-counter-heading"><a href="http://visitorcounterplugin.com">Visitor Counter</a></h2>
        <div class="visitor-counter-content">
            <p>Today : '.vcp_get_visit_count('D').'</p>
            <p>This Week : '.vcp_get_visit_count('W').'</p>
            <p>This Month : '.vcp_get_visit_count('M').'</p>
        </div>
        </aside>
        ';
    }
     
}

function visitor_counter_plugin_widget() {
 
    register_widget( 'VisitorCounterPlugin_Widget' );
 
}

add_action( 'widgets_init', 'visitor_counter_plugin_widget' );



function visitor_counter_plugin_widget_shortcode($atts) {
    
    global $wp_widget_factory;
    
    // extract(shortcode_atts(array(
    //     'widget_name' => FALSE
    // ), $atts));
    
    $widget_name = 'VisitorCounterPlugin_Widget';
    // $widget_name = wp_specialchars($widget_name);
    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));
        
        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;
    
    ob_start();
    the_widget($widget_name, array(), array('widget_id'=>'arbitrary-instance-visitorcounterplugin_widget',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
    
}
add_shortcode('visitor_counter','visitor_counter_plugin_widget_shortcode'); 

//Log user
add_action( 'init', 'vcp_log_user' );

function vcp_log_user() {
     
    if(!vcp_check_ip_exist($_SERVER['REMOTE_ADDR'])){

        global $wpdb;

        $table_name = $wpdb->prefix . 'vcp_log';

        $sqlQuery = "INSERT INTO $table_name VALUES (NULL,'".$_SERVER['REMOTE_ADDR']."',NULL)";
        $sqlQueryResult = $wpdb -> get_results($sqlQuery);
    }
}


function vcp_get_visit_count($interval='D')
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'vcp_log';
    
    if($interval == 'D')
    $condition = "DATE(`Time`)=DATE(NOW())";
    else if($interval == 'W')
    $condition = "WEEKOFYEAR(`Time`)=WEEKOFYEAR(NOW())";
    else if($interval == 'M')
    $condition = "MONTH(`Time`)=MONTH(NOW())";

    $sql = "SELECT COUNT(*) FROM $table_name WHERE ".$condition;

    $count = $wpdb -> get_var($sql);
   
    return $count;
}

function vcp_check_ip_exist($ip)
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'vcp_log';

    $sql = "SELECT COUNT(*) FROM $table_name WHERE IP='".$ip."' AND DATE(Time)='".date('Y-m-d')."'";

    $count = $wpdb -> get_var($sql);
   
    return $count;
}

global $vcp_db_version;
$vcp_db_version = ‘1’;

function vcp_install() {
    global $wpdb;
    global $vcp_db_version;

    $vcp_log_table = $wpdb->prefix . 'vcp_log';

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $sql = "
    CREATE TABLE IF NOT EXISTS $vcp_log_table 
    (
        `LogID` int(11) NOT NULL AUTO_INCREMENT,
        `IP` varchar(20) NOT NULL,
        `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
         PRIMARY KEY (`LogID`)
    );";

    dbDelta( $sql );

    add_option( 'vcp_db_version', $vcp_db_version );
}

function vcp_uninstall(){

    global $wpdb;
    $vcp_log_table = $wpdb->prefix."vcp_log";
    //Delete any options that's stored also?
    delete_option('vcp_db_version');
    $wpdb->query("DROP TABLE IF EXISTS $vcp_log_table");
}

register_activation_hook( __FILE__, 'vcp_install' );
register_deactivation_hook( __FILE__, 'vcp_uninstall' );
?>