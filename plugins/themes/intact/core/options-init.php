<?php
/**
ReduxFramework Sample Config File
For full documentation, please visit: https://docs.reduxframework.com
* */
if (!class_exists('keydesign_Redux_Framework_config')) {
    class keydesign_Redux_Framework_config
    {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;
        public function __construct()
        {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (true == Redux_Helpers::isTheme(__FILE__)) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array(
                    $this,
                    'initSettings'
                ), 10);
            }
        }
        public function initSettings()
        {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setSections();
            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action('redux/loaded', array(
                $this,
                'remove_demo'
            ));
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            add_filter('redux/options/' . $this->args['opt_name'] . '/compiler', array(
                $this,
                'compiler_action'
            ), 10, 2);
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        /**

        This is a test function that will let you see when the compiler hook occurs.
        It only runs if a field   set with compiler=>true is changed.

        * */
        function compiler_action($options, $css)
        {

            $filename  = get_template_directory() . '/core/assets/css/dynamic-keydesign.css';
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
            if ($wp_filesystem) {
                $wp_filesystem->put_contents($filename, $css, FS_CHMOD_FILE // predefined mode settings for WP files
                    );
            }
        }
        /**

        Custom function for filtering the sections array. Good for child themes to override or add to the sections.
        Simply include this function in the child themes functions.php file.

        NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
        so you must use get_template_directory_uri() if you want to use any of the built in icons

        * */
        function dynamic_section($sections)
        {
            //$sections = array();
            $sections[] = array(
                'title' => esc_html__('Section via hook', 'intact'),
                'desc' => esc_html__('This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.', 'intact'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );
            return $sections;
        }
        /**

        Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

        * */
        function change_arguments($args)
        {
            //$args['dev_mode'] = true;
            return $args;
        }
        /**

        Filter hook for filtering the default value of any given field. Very useful in development mode.

        * */
        function change_defaults($defaults)
        {
            $defaults['str_replace'] = 'Testing filter hook!';
            return $defaults;
        }
        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo()
        {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2);
                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(
                    ReduxFrameworkPlugin::instance(),
                    'admin_notices'
                ));
            }
        }
        public function setSections()
        {
            /**
            Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
            * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns      = array();
            ob_start();
            $ct              = wp_get_theme();
            $this->theme     = $ct;
            $item_name       = $this->theme->get('Name');
            $tags            = $this->theme->Tags;
            $screenshot      = $this->theme->get_screenshot();
            $class           = $screenshot ? 'has-screenshot' : '';
            $customize_title = sprintf(esc_html__('Customize &#8220;%s&#8221;', 'intact'), $this->theme->display('Name'));
?>
    <div id="current-theme" class="<?php
            echo esc_attr($class);
?>
        ">
        <?php
            if ($screenshot):
?>
        <?php
                if (current_user_can('edit_theme_options')):
?>
        <a href="<?php
                    echo esc_url(wp_customize_url());
?>
            " class="load-customize hide-if-no-customize" title="
            <?php
                    echo esc_attr($customize_title);
?>
            ">
            <img src="<?php
                    echo esc_url($screenshot);
?>
            " alt="
            <?php
                    esc_attr_e('Current theme preview','intact');
?>" /></a>
        <?php
                endif;
?>
        <img class="hide-if-customize" src="<?php
                echo esc_url($screenshot);
?>
        " alt="
        <?php
                esc_attr_e('Current theme preview','intact');
?>
        " />
        <?php
            endif;
?>

        <h4>
            <?php
            echo esc_attr($this->theme->display('Name'));
?></h4>

        <div>
            <ul class="theme-info">
                <li>
                    <?php
            printf(esc_html__('By %s', 'intact'), $this->theme->display('Author'));
?></li>
                <li>
                    <?php
            printf(esc_html__('Version %s', 'intact'), $this->theme->display('Version'));
?></li>
                <li>
                    <?php
            echo '<strong>' . esc_html__('Tags', 'intact') . ':</strong>
                ';
?>
                <?php
            printf($this->theme->display('Tags'));
?></li>
        </ul>
        <p class="theme-description">
            <?php
            echo esc_attr($this->theme->display('Description'));
?></p>

    </div>
</div>

<?php
            $item_info = ob_get_contents();
            ob_end_clean();
            $sampleHTML = '';
            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'icon' => 'el-icon-globe',
                'title' => esc_html__('Global Options', 'intact'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                        'id' => 'tek-main-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Main Theme Color', 'intact'),
                        'default' => '#31d093',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-preloader',
                        'type' => 'switch',
                        'title' => esc_html__('Preloader', 'intact'),
                        'subtitle' => esc_html__('Turn on/off theme preloader', 'intact'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-google-api',
                        'type' => 'text',
                        'title' => __('Google Map API Key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank" class="el-icon-question-sign"></a>', 'intact'),
                        'default' => '',
                        'subtitle' => esc_html__('Generate, copy and paste here Google Maps API Key', 'intact'),
                    ),
                    array(
                        'id' => 'tek-disable-animations',
                        'type' => 'switch',
                        'title' => esc_html__('Disable Animations on Mobile', 'intact'),
                        'subtitle' => esc_html__('Globally turn on/off element animations on mobile', 'intact'),
                        'default' => false
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-star',
                'title' => esc_html__('Logo', 'intact'),
                'fields' => array(
                  array(
                      'id' => 'tek-logo-style',
                      'type' => 'select',
                      'title' => esc_html__('Logo Style', 'intact'),
                      'options'  => array(
                          '1' => 'Image logo',
                          '2' => 'Text logo'
                      ),
                      'default' => '2'
                  ),
                  array(
                      'id' => 'tek-logo',
                      'type' => 'media',
                      'readonly' => false,
                      'url' => true,
                      'title' => esc_html__('Logo Image', 'intact'),
                      'subtitle' => esc_html__('Upload logo image', 'intact'),
                      'required' => array('tek-logo-style','equals','1'),
                      'default' => array(
                          'url' => get_template_directory_uri() . '/images/logo.png'
                      )
                  ),
                  array(
                      'id' => 'tek-logo2',
                      'type' => 'media',
                      'readonly' => false,
                      'url' => true,
                      'title' => esc_html__('Secondary Logo Image', 'intact'),
                      'subtitle' => esc_html__('Upload logo image for sticky navigation', 'intact'),
                      'required' => array('tek-logo-style','equals','1'),
                      'default' => array(
                          'url' => get_template_directory_uri() . '/images/logo-2.png'
                      )
                  ),
                  array(
                      'id' => 'tek-logo-size',
                      'type' => 'dimensions',
                      'height' => false,
                      'units'    => array('px'),
                      'url' => true,
                      'title' => esc_html__('Logo Image Size', 'intact'),
                      'subtitle' => esc_html__('Choose logo width - the image will constrain proportions', 'intact'),
                      'required' => array('tek-logo-style','equals','1'),
                  ),
                  array(
                      'id' => 'tek-text-logo',
                      'type' => 'text',
                      'title' => esc_html__('Logo Text', 'intact'),
                      'required' => array('tek-logo-style','equals','2'),
                      'default' => 'Intact'
                  ),
                  array(
                      'id' => 'tek-main-logo-color',
                      'type' => 'color',
                      'transparent' => false,
                      'title' => esc_html__('Main Logo Text Color', 'intact'),
                      'required' => array('tek-logo-style','equals','2'),
                      'default' => '#1f1f1f',
                      'validate' => 'color'
                  ),
                  array(
                      'id' => 'tek-secondary-logo-color',
                      'type' => 'color',
                      'transparent' => false,
                      'title' => esc_html__('Secondary Logo Text Color', 'intact'),
                      'subtitle' => esc_html__('Logo text color for sticky navigation', 'intact'),
                      'required' => array('tek-logo-style','equals','2'),
                      'default' => '#1f1f1f',
                      'validate' => 'color'
                  ),
                  array(
                      'id' => 'tek-favicon',
                      'type' => 'media',
                      'readonly' => false,
                      'preview' => false,
                      'url' => true,
                      'title' => esc_html__('Favicon', 'intact'),
                      'subtitle' => esc_html__('Upload favicon image', 'intact'),
                      'default' => array(
                          'url' => get_template_directory_uri() . '/images/favicon.png'
                      )
                  ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-lines',
                'title' => esc_html__('Header', 'intact'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                        'id'=>'tek-header-bar-section-start',
                        'type' => 'section',
                        'title' => esc_html__('Header Bar Settings', 'intact'),
                        'indent' => true,
                    ),
                    array(
                        'id' => 'tek-menu-style',
                        'type' => 'button_set',
                        'title' => esc_html__('Header Bar Width', 'intact'),
                        'subtitle' => esc_html__('You can choose between full width and contained.', 'intact'),
                        'options' => array(
                            '1' => 'Full width',
                            '2' => 'Contained'
                         ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-menu-behaviour',
                        'type' => 'button_set',
                        'title' => esc_html__('Header Bar Behaviour', 'intact'),
                        'subtitle' => esc_html__('You can choose between a sticky or a fixed top menu.', 'intact'),
                        'options' => array(
                            '1' => 'Sticky',
                            '2' => 'Fixed'
                         ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-search-bar',
                        'type' => 'switch',
                        'title' => esc_html__('Search Bar', 'intact'),
                        'subtitle' => esc_html__('Turn on to display search bar.', 'intact'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-header-menu-bg',
                        'type' => 'color',
                        'title' => esc_html__('Header Bar Background Color', 'intact'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-bg-sticky',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Sticky Header Bar Background Color', 'intact'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                      	'id'=>'tek-header-bar-section-end',
                      	'type' => 'section',
                      	'indent' => false,
                    ),
                    array(
                      	'id'=>'tek-menu-settings-section-start',
                      	'type' => 'section',
                      	'title' => esc_html__('Main Menu Settings', 'intact'),
                      	'indent' => true,
                    ),
                    array(
                        'id' => 'tek-menu-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Menu Font Settings', 'intact'),
                        'google' => true,
                        'font-style' => true,
                        'font-size' => true,
                        'line-height' => false,
                        'text-transform' => true,
                        'color' => false,
                        'text-align' => false,
                        'preview' => true,
                        'all_styles' => false,
                        'units' => 'px',
                        'preview' => array(
                            'text' => 'Menu Item'
                        )
                    ),
                    array(
                        'id' => 'tek-header-menu-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Menu Link Color', 'intact'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-color-hover',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Menu Link Hover Color', 'intact'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-color-sticky',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Sticky Menu Link Color', 'intact'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-color-sticky-hover',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Sticky Menu Link Hover Color', 'intact'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                      	'id'=>'tek-menu-settings-section-end',
                      	'type' => 'section',
                      	'indent' => false,
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Header Button', 'intact'),
                'subsection' => true,
                'fields' => array(
                  array(
                      'id' => 'tek-header-button',
                      'type' => 'switch',
                      'title' => esc_html__('Enable Header Button', 'intact'),
                      'default' => false
                  ),
                  array(
                      'id' => 'tek-header-button-text',
                      'type' => 'text',
                      'title' => esc_html__('Button Text', 'intact'),
                      'required' => array('tek-header-button','equals', true),
                      'default' => 'Let`s Talk'
                  ),
                  array(
                      'id' => 'tek-header-button-action',
                      'type' => 'select',
                      'title' => esc_html__('Button Action', 'intact'),
                      'required' => array('tek-header-button','equals', true),
                      'options'  => array(
                          '1' => 'Open modal window with contact form',
                          '2' => 'Scroll to section',
                          '3' => 'Open a new page'
                      ),
                      'default' => '3'
                  ),
                  array(
                      'id' => 'tek-modal-title',
                      'type' => 'text',
                      'title' => esc_html__('Modal Title', 'intact'),
                      'required' => array('tek-header-button-action','equals','1'),
                      'default' => 'Just ask. Get answers.'
                  ),
                  array(
                      'id' => 'tek-modal-subtitle',
                      'type' => 'text',
                      'title' => esc_html__('Modal Subtitle', 'intact'),
                      'required' => array('tek-header-button-action','equals','1'),
                      'default' => 'Your questions and comments are important to us.'
                  ),
                  array(
                      'id' => 'tek-modal-form-select',
                      'type' => 'select',
                      'title' => esc_html__('Contact Form Plugin', 'intact'),
                      'required' => array('tek-header-button-action','equals','1'),
                      'options'  => array(
                          '1' => 'Contact Form 7',
                          '2' => 'Ninja Forms',
                          '3' => 'Gravity Forms',
                          '4' => 'WP Forms',
                      ),
                      'default' => '1'
                  ),
                  array(
                      'id' => 'tek-modal-contactf7-formid',
                      'type' => 'select',
                      'data' => 'posts',
                      'args' => array( 'post_type' => 'wpcf7_contact_form', ),
                      'title' => esc_html__('Contact Form 7 Title', 'intact'),
                      'required' => array('tek-modal-form-select','equals','1'),
                      'default' => ''
                  ),
                  array(
                      'id' => 'tek-modal-ninja-formid',
                      'type' => 'text',
                      'title' => esc_html__('Ninja Form ID', 'intact'),
                      'required' => array('tek-modal-form-select','equals','2'),
                      'default' => ''
                  ),
                  array(
                      'id' => 'tek-modal-gravity-formid',
                      'type' => 'text',
                      'title' => esc_html__('Gravity Form ID', 'intact'),
                      'required' => array('tek-modal-form-select','equals','3'),
                      'default' => ''
                  ),
                  array(
                      'id' => 'tek-modal-wp-formid',
                      'type' => 'text',
                      'title' => esc_html__('WP Form ID', 'intact'),
                      'required' => array('tek-modal-form-select','equals','4'),
                      'default' => ''
                  ),
                  array(
                      'id' => 'tek-scroll-id',
                      'type' => 'text',
                      'title' => esc_html__('Scroll to section ID', 'intact'),
                      'required' => array('tek-header-button-action','equals','2'),
                      'default' => '#download-intact'
                  ),
                  array(
                      'id' => 'tek-button-new-page',
                      'type' => 'text',
                      'title' => esc_html__('Button Link', 'intact'),
                      'required' => array('tek-header-button-action','equals','3'),
                      'default' => '#'
                  ),
                  array(
                      'id' => 'tek-button-target',
                      'type' => 'select',
                      'title' => esc_html__('Link Target', 'intact'),
                      'required' => array('tek-header-button-action','equals','3'),
                      'options'  => array(
                          'new-page' => 'Open in a new page',
                          'same-page' => 'Open in same page'
                      ),
                      'default' => 'new-page'
                  ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => esc_html__('Home Slider', 'intact'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                        'id' => 'tek-slider',
                        'type' => 'text',
                        'title' => esc_html__('Revolution Slider Alias Name', 'intact'),
                        'subtitle' => esc_html__('Enter Revolution Slider alias name here.', 'intact'),
                        'default' => ''
                    )
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-thumbs-up',
                'title' => esc_html__('Footer', 'intact'),
                'fields' => array(

                    array(
                        'id' => 'tek-footer-fixed',
                        'type' => 'switch',
                        'title' => esc_html__('Fixed Footer', 'intact'),
                        'subtitle' => esc_html__('Turn on/off this feature', 'intact'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-backtotop',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Go to Top Button', 'intact'),
                        'subtitle' => esc_html__('Enable to display the Go to Top button.', 'intact'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-upper-footer-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Upper Footer Background', 'intact'),
                        'default' => '#1f1f1f',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-lower-footer-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Lower Footer Background', 'intact'),
                        'default' => '#1f1f1f',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-footer-heading-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Footer Headings Color', 'intact'),
                        'default' => '#ffffff',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-footer-text-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Footer Text Color', 'intact'),
                        'default' => '#e8e8e8',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-footer-text',
                        'type' => 'text',
                        'title' => esc_html__('Copyright Text', 'intact'),
                        'subtitle' => esc_html__('Enter footer bottom copyright text', 'intact'),
                        'default' => 'Intact by KeyDesign. All rights reserved.'
                    ),
                    array(
                        'id' => 'tek-social-icons',
                        'type' => 'checkbox',
                        'title' => esc_html__('Social Icons', 'intact'),
                        'subtitle' => esc_html__('Select visible social icons', 'intact'),
                        'options' => array(
                            '1' => 'Facebook',
                            '2' => 'Twitter',
                            '3' => 'Google+',
                            '4' => 'Pinterest',
                            '5' => 'Youtube',
                            '6' => 'Linkedin',
                            '7' => 'Instagram'
                        ),
                        'default' => array(
                            '1' => '1',
                            '2' => '1',
                            '3' => '1',
                            '4' => '0',
                            '5' => '0',
                            '6' => '1',
                            '7' => '0',
                        )
                    ),
                    array(
                        'id' => 'tek-facebook-url',
                        'type' => 'text',
                        'title' => esc_html__('Facebook Link', 'intact'),
                        'subtitle' => esc_html__('Enter Facebook URL', 'intact'),
                        'validate' => 'url',
                        'default' => 'http://www.facebook.com/'
                    ),

                    array(
                        'id' => 'tek-twitter-url',
                        'type' => 'text',
                        'title' => esc_html__('Twitter Link', 'intact'),
                        'subtitle' => esc_html__('Enter Twitter URL', 'intact'),
                        'validate' => 'url',
                        'default' => 'http://www.twitter.com/'
                    ),

                    array(
                        'id' => 'tek-google-url',
                        'type' => 'text',
                        'title' => esc_html__('Google+ Link', 'intact'),
                        'subtitle' => esc_html__('Enter Google+ URL', 'intact'),
                        'default' => 'http://plus.google.com/'
                    ),
                    array(
                        'id' => 'tek-pinterest-url',
                        'type' => 'text',
                        'title' => esc_html__('Pinterest Link', 'intact'),
                        'subtitle' => esc_html__('Enter Pinterest URL', 'intact'),
                        'validate' => 'url',
                        'default' => 'http://www.pinterest.com/'
                    ),

                    array(
                        'id' => 'tek-youtube-url',
                        'type' => 'text',
                        'title' => esc_html__('Youtube Link', 'intact'),
                        'subtitle' => esc_html__('Enter Youtube URL', 'intact'),
                        'validate' => 'url',
                        'default' => 'http://www.youtube.com/'
                    ),
                    array(
                        'id' => 'tek-linkedin-url',
                        'type' => 'text',
                        'title' => esc_html__('Linkedin Link', 'intact'),
                        'subtitle' => esc_html__('Enter Linkedin URL', 'intact'),
                        'validate' => 'url',
                        'default' => 'http://www.linkedin.com/'
                    ),
                    array(
                        'id' => 'tek-instagram-url',
                        'type' => 'text',
                        'title' => esc_html__('Instagram Link', 'intact'),
                        'subtitle' => esc_html__('Enter Instagram URL', 'intact'),
                        'validate' => 'url',
                        'default' => 'http://www.instagram.com/'
                    ),

                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-fontsize',
                'title' => esc_html__('Typography', 'intact'),
                'compiler' => true,
                'fields' => array(
                    array(
                        'id' => 'tek-default-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Body Typography', 'intact'),
                        'google' => true,
                        'font-style' => true,
                        'font-size' => true,
                        'line-height' => true,
                        'color' => true,
                        'text-align' => true,
                        'preview' => true,
                        'all_styles' => true,
                        'units' => 'px',
                        'default' => array(
                            'color' => '#666',
                            'font-weight' => '300',
                            'font-family' => 'Open Sans',
                            'google' => true,
                            'font-size' => '14px',
                            'text-align' => 'left',
                            'line-height' => '24px'
                        ),
                        'preview' => array(
                            'text' => 'Sample Text'
                        )
                    ),
                    array(
                        'id' => 'tek-heading-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Heading Typography', 'intact'),
                        'google' => true,
                        'font-style' => true,
                        'font-size' => true,
                        'line-height' => true,
                        'color' => true,
                        'text-align' => true,
                        'preview' => true,
                        'all_styles' => true,
                        'units' => 'px',
                        'default' => array(
                            'color' => '#1f1f1f',
                            'font-weight' => '700',
                            'font-family' => 'Poppins',
                            'google' => true,
                            'font-size' => '34px',
                            'text-align' => 'center',
                            'line-height' => '45px'
                        ),
                        'preview' => array(
                            'text' => 'Intact Sample Text'
                        )
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Typekit Fonts', 'intact'),
                'subsection' => true,
                'fields' => array(
                  array(
                      'id' => 'tek-typekit-switch',
                      'type' => 'switch',
                      'title' => esc_html__('Enable Typekit', 'intact'),
                      'subtitle' => esc_html__('Select to enable Typekit fonts and display options below.', 'intact'),
                      'default' => true
                  ),
                  array(
                      'id' => 'tek-typekit',
                      'type' => 'text',
                      'title' => __('Typekit ID <a href="http://keydesign-themes.com/intact/documentation#ops-typekit" target="_blank" class="el-icon-question-sign"></a>', 'intact'),
                      'subtitle' => esc_html__('Enter in the ID for your kit here. Only published data is accessible, so make sure that any changes you make to your kit are updated.', 'intact'),
                      'mode' => 'text',
                      'default' => '',
                      'theme' => 'chrome',
                      'required' => array('tek-typekit-switch','equals', true),
                  ),
                  array(
                      'id' => 'tek-body-typekit-selector',
                      'type' => 'text',
                      'title' => __('Body Font Selector <a href="https://helpx.adobe.com/typekit/using/css-selectors.html" target="_blank" class="el-icon-question-sign"></a>', 'intact'),
                      'subtitle' => esc_html__('Add the Typekit font family name.', 'intact'),
                      'default' => '',
                      'required' => array('tek-typekit-switch','equals', true),
                  ),
                  array(
                      'id' => 'tek-heading-typekit-selector',
                      'type' => 'text',
                      'title' => __('Headings Font Selector <a href="https://helpx.adobe.com/typekit/using/css-selectors.html" target="_blank" class="el-icon-question-sign"></a>', 'intact'),
                      'subtitle' => esc_html__('Add the Typekit font family name.', 'intact'),
                      'default' => '',
                      'required' => array('tek-typekit-switch','equals', true),
                  ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-th-list',
                'title' => esc_html__('Portfolio', 'intact'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                				'id' =>	'tek-portfolio-title',
                				'type' => 'switch',
                				'title' => esc_html__('Show title', 'intact'),
                				'subtitle' => esc_html__('Activate to display the portfolio item title in the content area.', 'intact'),
                				'default' => '1',
                				'on' => 'Yes',
                				'off' => 'No',
              			),
                    array(
                				'id' =>	'tek-portfolio-meta',
                				'type' => 'switch',
                				'title' => esc_html__('Meta section', 'intact'),
                				'subtitle' => esc_html__('Activate to display the meta section (Category, Tags, Publish Date).', 'intact'),
                				'default' => '1',
                				'on' => 'Yes',
                				'off' => 'No',
              			),
                    array(
                				'id' =>	'tek-portfolio-social',
                				'type' => 'switch',
                				'title' => esc_html__('Social media section', 'intact'),
                				'subtitle' => esc_html__('Activate to display the share on social media buttons.', 'intact'),
                				'default' => '1',
                				'on' => 'Yes',
                				'off' => 'No',
              			),
                    array(
                        'id' => 'tek-portfolio-bgcolor',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Page background color', 'intact'),
                        'subtitle' => esc_html__('Select the background color for the content area.', 'intact'),
                        'default' => '#fafafa',
                        'validate' => 'color'
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-shopping-cart',
                'title' => esc_html__('WooCommerce', 'intact'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                        'id' => 'tek-woo-products-number',
                        'type' => 'text',
                        'title' => __('Products per Page', 'intact'),
                        'subtitle' => esc_html__('Change the products number listed per page.', 'intact'),
                        'default' => '9',
                    ),
                    array(
                        'id' => 'tek-woo-sidebar-position',
                        'type' => 'select',
                        'title' => esc_html__('Shop Sidebar Position', 'intact'),
                        'options'  => array(
                            'woo-sidebar-left' => 'Left',
                            'woo-sidebar-right' => 'Right',
                        ),
                        'default' => 'woo-sidebar-right'
                    ),
                    array(
                        'id' => 'tek-woo-single-sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('Single Product Sidebar', 'intact'),
                        'subtitle' => esc_html__('Enable/disable shop sidebar on single product page.', 'intact'),
                        'default' => '0',
                        '1' => 'Yes',
                        '0' => 'No',
                    ),
                    array(
                        'id' => 'tek-woo-cart',
                        'type' => 'switch',
                        'title' => esc_html__('Cart Icon', 'intact'),
                        'subtitle' => esc_html__('Turn on to display shopping cart icon in header.', 'intact'),
                        'default' => '1',
                        '1' => 'On',
                        '0' => 'Off',
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-pencil-alt',
                'title' => esc_html__('Blog', 'intact'),
                'fields' => array(
                    array(
                        'id' => 'tek-blog-subtitle',
                        'type' => 'text',
                        'title' => esc_html__('Blog Subtitle', 'intact'),
                        'default' => 'Welcome to Intact. This is your first post. Edit or delete it, then start blogging!'
                        //
                    ),
                    array(
                        'id' => 'tek-blog-sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('Display Sidebar', 'intact'),
                        'subtitle' => esc_html__('Turn on/off blog sidebar', 'intact'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-blog-minimal',
                        'type' => 'switch',
                        'title' => esc_html__('Minimal Blog', 'intact'),
                        'subtitle' => esc_html__('Change blog layout to minimal style', 'intact'),
                        'default' => false
                    )
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-error-alt',
                'title' => esc_html__('404 Page', 'intact'),
                'fields' => array(
                    array(
                        'id' => 'tek-404-title',
                        'type' => 'text',
                        'title' => esc_html__('Title', 'intact'),
                        'default' => 'Error 404',
                    ),
                    array(
                        'id' => 'tek-404-subtitle',
                        'type' => 'text',
                        'title' => esc_html__('Subtitle', 'intact'),
                        'default' => 'This page could not be found!',
                    ),
                    array(
                        'id' => 'tek-404-back',
                        'type' => 'text',
                        'title' => esc_html__('Back to Homepage Text', 'intact'),
                        'default' => 'Back to homepage',
                    ),
                    array(
                        'id' => 'tek-404-img',
                        'type' => 'media',
                        'readonly' => false,
                        'url' => true,
                        'title' => esc_html__('Background Image', 'intact'),
                        'subtitle' => esc_html__('Upload 404 overlay image', 'intact'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/page-404.jpg'
                        )
                    )
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-wrench-alt',
                'title' => esc_html__('Maintenance Page', 'intact'),
                'fields' => array(
                    array(
                        'id' => 'tek-maintenance-mode',
                        'type' => 'switch',
                        'title' => __('Enable Maintenance Mode', 'intact'),
                        'subtitle' => esc_html__('Activate to enable maintenance mode.', 'intact'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-maintenance-title',
                        'type' => 'text',
                        'title' => esc_html__('Page Title', 'intact'),
                        'required' => array('tek-maintenance-mode','equals', true),
                        'default' => 'StartUp launching soon'
                    ),
                    array(
                        'id' => 'tek-maintenance-content',
                        'type' => 'editor',
                        'title' => esc_html__('Page Content', 'intact'),
                        'required' => array('tek-maintenance-mode','equals', true),
                        'default' => '',
		                    'args'   => array(
                          'teeny'  => true,
                          'textarea_rows' => 10,
                          'media_buttons' => false,
			                  )
                    ),
                    array(
                        'id' => 'tek-maintenance-countdown',
                        'type' => 'switch',
                        'title' => __('Enable Countdown', 'intact'),
                        'subtitle' => esc_html__('Activate to enable the countdown timer.', 'intact'),
                        'required' => array('tek-maintenance-mode','equals', true),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-maintenance-count-day',
                        'type' => 'text',
                        'title' => esc_html__('End Day', 'intact'),
                        'subtitle' => esc_html__('Enter day value. Eg. 05', 'intact'),
                        'required' => array('tek-maintenance-countdown','equals', true),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-maintenance-count-month',
                        'type' => 'text',
                        'title' => esc_html__('End Month', 'intact'),
                        'subtitle' => esc_html__('Enter month value. Eg. 09', 'intact'),
                        'required' => array('tek-maintenance-countdown','equals', true),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-maintenance-count-year',
                        'type' => 'text',
                        'title' => esc_html__('End Year', 'intact'),
                        'subtitle' => esc_html__('Enter year value. Eg. 2020', 'intact'),
                        'required' => array('tek-maintenance-countdown','equals', true),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-maintenance-days-text',
                        'type' => 'text',
                        'title' => esc_html__('Days Label', 'intact'),
                        'subtitle' => esc_html__('Enter days text label.', 'intact'),
                        'required' => array('tek-maintenance-countdown','equals', true),
                        'default' => 'Days'
                    ),
                    array(
                        'id' => 'tek-maintenance-hours-text',
                        'type' => 'text',
                        'title' => esc_html__('Hours Label', 'intact'),
                        'subtitle' => esc_html__('Enter hours text label.', 'intact'),
                        'required' => array('tek-maintenance-countdown','equals', true),
                        'default' => 'Hours'
                    ),
                    array(
                        'id' => 'tek-maintenance-minutes-text',
                        'type' => 'text',
                        'title' => esc_html__('Minutes Label', 'intact'),
                        'subtitle' => esc_html__('Enter minutes text label.', 'intact'),
                        'required' => array('tek-maintenance-countdown','equals', true),
                        'default' => 'Minutes'
                    ),
                    array(
                        'id' => 'tek-maintenance-seconds-text',
                        'type' => 'text',
                        'title' => esc_html__('Seconds Label', 'intact'),
                        'subtitle' => esc_html__('Enter seconds text label.', 'intact'),
                        'required' => array('tek-maintenance-countdown','equals', true),
                        'default' => 'Seconds'
                    ),
                    array(
                        'id' => 'tek-maintenance-subscribe',
                        'type' => 'switch',
                        'title' => __('Enable Contact Form', 'intact'),
                        'subtitle' => esc_html__('Activate to enable contact form on page.', 'intact'),
                        'required' => array('tek-maintenance-mode','equals', true),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-maintenance-form-select',
                        'type' => 'select',
                        'title' => esc_html__('Contact Form Plugin', 'intact'),
                        'required' => array('tek-maintenance-subscribe','equals',true),
                        'options'  => array(
                            '1' => 'Contact Form 7',
                            '2' => 'Ninja Forms',
                            '3' => 'Gravity Forms',
                            '4' => 'WP Forms',
                        ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-maintenance-contactf7-formid',
                        'type' => 'select',
                        'data' => 'posts',
                        'args' => array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1, ),
                        'title' => esc_html__('Contact Form 7 Title', 'intact'),
                        'required' => array('tek-maintenance-form-select','equals','1'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-maintenance-ninja-formid',
                        'type' => 'text',
                        'title' => esc_html__('Ninja Form ID', 'intact'),
                        'required' => array('tek-maintenance-form-select','equals','2'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-maintenance-gravity-formid',
                        'type' => 'text',
                        'title' => esc_html__('Gravity Form ID', 'intact'),
                        'required' => array('tek-maintenance-form-select','equals','3'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-maintenance-wp-formid',
                        'type' => 'text',
                        'title' => esc_html__('WP Form ID', 'intact'),
                        'required' => array('tek-maintenance-form-select','equals','4'),
                        'default' => ''
                    ),

                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-css',
                'title' => esc_html__('Custom CSS/JS', 'intact'),
                'fields' => array(
                    array(
                        'id' => 'tek-css',
                        'type' => 'ace_editor',
                        'title' => esc_html__('CSS', 'intact'),
                        'subtitle' => esc_html__('Enter your CSS code in the side field. Do not include any tags or HTML in the field. Custom CSS entered here will override the theme CSS.', 'intact'),
                        'mode' => 'css',
                        'theme' => 'chrome',
                    ),
                    array(
                  			'id' => 'tek-javascript',
                  			'type' => 'ace_editor',
                  			'title' => esc_html__( 'Javascript', 'intact' ),
                  			'subtitle' => esc_html__( 'Only accepts Javascript code.', 'intact' ),
                  			'mode' => 'html',
                  			'theme' => 'chrome',
                		),
                )
            );
            $this->sections[] = array(
                'title' => esc_html__('Import Demos', 'intact'),
                'desc' => __('Import demo content <a href="http://keydesign-themes.com/intact/documentation#gs-importing-demo-content" target="_blank" class="el-icon-question-sign"></a>', 'intact'),
                'icon' => 'el-icon-magic',
                'fields' => array(
                    array(
                        'id' => 'opt-import-export',
                        'type' => 'import_export',
                        'title' => __('Import Demo <a href="http://keydesign-themes.com/intact/documentation#gs-importing-demo-content" target="_blank" class="el-icon-question-sign"></a>', 'intact'),
                        'subtitle' => '',
                        'full_width' => false
                    )
                )
            );
        }
        /**

        All the possible arguments for Redux.
        For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

        * */
        public function setArguments()
        {
            $theme                         = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args                    = array(
                'opt_name' => 'redux_ThemeTek',
                'page_slug' => 'theme-options',
                'page_title' => 'Theme Options',
                'dev_mode' => '0',
                'update_notice' => '1',
                'admin_bar' => '1',
                'menu_type' => 'submenu',
                'page_parent' => 'themes.php',
                'menu_title' => 'Theme Options',
                'allow_sub_menu' => '1',
                'page_parent_post_type' => 'your_post_type',
                'customizer' => false,
                'class' => '',
                'hints' => array(
                    'icon' => 'el-icon-question-sign',
                    'icon_position' => 'right',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light'
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right'
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'duration' => '500',
                            'event' => 'mouseover'
                        ),
                        'hide' => array(
                            'duration' => '500',
                            'event' => 'mouseleave unfocus'
                        )
                    )
                ),
                'output' => '1',
                'output_tag' => '1',
                'compiler' => '1',
                'page_icon' => 'icon-themes',
                'page_permissions' => 'manage_options',
                'save_defaults' => '1',
                'show_import_export' => '1',
                'transient_time' => '3600',
                'network_sites' => '1'
            );
            $theme                         = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args["display_name"]    = $theme->get("Name");
            $this->args["display_version"] = $theme->get("Version");

        }
    }
    global $reduxConfig;
    $reduxConfig = new keydesign_Redux_Framework_config();
}
/**
Custom function for the callback referenced above
*/
if (!function_exists('keydesign_my_custom_field')):
    function keydesign_my_custom_field($field, $value)
    {
        print_r($field);
        echo '
<br/>
';
        print_r($value);
    }
endif;
/**
Custom function for the callback validation referenced above
* */
if (!function_exists('keydesign_validate_callback_function')):
    function keydesign_validate_callback_function($field, $value, $existing_value)
    {
        $error           = false;
        $value           = 'just testing';
        /*
        do your validation

        if(something) {
        $value = $value;
        } elseif(something else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
        }
        */
        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
