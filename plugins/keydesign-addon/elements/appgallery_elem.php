<?php

if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_tek_appgallery extends WPBakeryShortCodesContainer {
    }
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tek_appgallery_single extends WPBakeryShortCode {
    }
}

if (!class_exists('tek_appgallery')) {
    class tek_appgallery extends KEYDESIGN_ADDON_CLASS
    {
        function __construct() {
            add_action('init', array($this, 'kd_appgallery_init'));
            add_shortcode('tek_appgallery', array($this, 'kd_appgallery_container'));
            add_shortcode('tek_appgallery_single', array($this, 'kd_appgallery_single'));
        }

        // Element configuration in admin
        function kd_appgallery_init() {
            // Container element configuration
            if (function_exists('vc_map')) {
                vc_map(array(
                    "name" => esc_html__("App gallery", "keydesign"),
                    "description" => esc_html__("Mobile app screenshots carousel.", "keydesign"),
                    "base" => "tek_appgallery",
                    "class" => "",
                    "show_settings_on_create" => true,
                    "content_element" => true,
                    "as_parent" => array('only' => 'tek_appgallery_single'),
                    "icon" => plugins_url('assets/element_icons/app-gallery.png', dirname(__FILE__)),
                    "category" => esc_html__("KeyDesign Elements", "keydesign"),
                    "js_view" => 'VcColumnView',
                    "params" => array(
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => esc_html__("Section title", "keydesign"),
                            "param_name" => "ag_title",
                            "value" => "",
                            "description" => esc_html__("Enter section title here.", "keydesign")
                        ),

                        array(
                            "type" => "textarea",
                            "class" => "",
                            "heading" => esc_html__("Section description", "keydesign"),
                            "param_name" => "ag_description",
                            "value" => "",
                            "description" => esc_html__("Enter section description here.", "keydesign")
                        ),

                        array(
                            "type" => "attach_image",
                            "heading" => esc_html__("Upload mockup", "keydesign"),
                            "param_name" => "ag_mockup",
                            "description" => esc_html__("Upload container mockup.", "keydesign")
                        ),

                        array(
                            "type"          =>  "dropdown",
                            "class"         =>  "",
                            "heading"       =>  esc_html__("Enable autoplay","keydesign"),
                            "param_name"    =>  "ag_autoplay",
                            "value"         =>  array(
                                    "Off"   => "auto_off",
                                    "On"   => "auto_on"
                                ),
                            "save_always" => true,
                            "description"   =>  esc_html__("Carousel autoplay settings.", "keydesign")
                        ),

                        array(
                            "type"          =>  "dropdown",
                            "class"         =>  "",
                            "heading"       =>  esc_html__("Autoplay speed","keydesign"),
                            "param_name"    =>  "ag_autoplay_speed",
                            "value"         =>  array(
                                    "10s"   => "10000",
                                    "9s"   => "9000",
                                    "8s"   => "8000",
                                    "7s"   => "7000",
                                    "6s"   => "6000",
                                    "5s"   => "5000",
                                    "4s"   => "4000",
                                    "3s"   => "3000",
                                ),
                            "save_always" => true,
                            "dependency" =>	array(
                                "element" => "ag_autoplay",
                                "value" => array("auto_on")
                            ),
                            "description"   =>  esc_html__("Carousel autoplay speed.", "keydesign")
                        ),

                        array(
                            "type"          =>  "dropdown",
                            "class"         =>  "",
                            "heading"       =>  esc_html__("Stop on hover","keydesign"),
                            "param_name"    =>  "ag_stoponhover",
                            "value"         =>  array(
                                    "Off"   => "hover_off",
                                    "On"   => "hover_on"
                                ),
                            "save_always" => true,
                            "dependency" =>	array(
                                "element" => "ag_autoplay",
                                "value" => array("auto_on")
                            ),
                            "description"   =>  esc_html__("Stop sliding carousel on mouse over.", "keydesign")
                        ),

                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => esc_html__("Extra class name", "keydesign"),
                            "param_name" => "ag_extra_class",
                            "value" => "",
                            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "keydesign")
                        ),

                    )

                ));

                // Shortcode configuration

                vc_map(array(
                    "name" => esc_html__("App screenshot", "keydesign"),
                    "base" => "tek_appgallery_single",
                    "content_element" => true,
                    "as_child" => array('only' => 'tek_appgallery'),
                    "icon" => plugins_url('assets/element_icons/child-image.png', dirname(__FILE__)),
                    "params" => array(
                        array(
                            "type" => "attach_image",
                            "heading" => esc_html__("Upload image", "keydesign"),
                            "param_name" => "ag_screenshot",
                            "admin_label" => true,
                            "description" => esc_html__("Upload mobile app screenshot.", "keydesign")
                        )
                    )
                ));
            }
        }

        public function kd_appgallery_container($atts, $content = null) {

            extract(shortcode_atts(array(
                    'ag_title' => '',
                    'ag_description' => '',
                    'ag_mockup' => '',
                    'ag_autoplay' => '',
                    'ag_autoplay_speed' => '',
                    'ag_stoponhover' => '',
                    'ag_extra_class' => ''
                ), $atts));

            $mockup_image  = wpb_getImageBySize($params = array(
                'post_id' => NULL,
                'attach_id' => $ag_mockup,
                'thumb_size' => 'full',
                'class' => ""
            ));

            $kd_agunique_id = "kd-appgallery-".uniqid();

            $output = '
            <div class="app-gallery ag-parent '.$kd_agunique_id.' '.$ag_extra_class.'">
                <div class="ag-section-desc">
                    <h4>'.$ag_title.'</h4><span class="heading-separator"></span>
                    <p>'.$ag_description.'</p>
                </div>
                <div class="ag-mockup">'.$mockup_image['thumbnail'].'</div>
                <div class="ag-slider">'.do_shortcode($content).'</div>
            </div>';

            $output .= '<script type="text/javascript">
              jQuery(document).ready(function($){
                if ($(".app-gallery.'.$kd_agunique_id.' .ag-slider").length) {
                  $(".app-gallery.'.$kd_agunique_id.' .ag-slider").owlCarousel({
                    navigation: false,
                    pagination: true,';

                    if($ag_autoplay == "auto_on" && $ag_autoplay_speed !== "") {
                      $output .= 'autoPlay: '.$ag_autoplay_speed.',';
                    } else {
                      $output .= 'autoPlay: false,';
                    }

                    if($ag_autoplay == "auto_on" && $ag_stoponhover == "hover_on") {
                      $output .= 'stopOnHover: true,';
                    } else {
                      $output .= 'stopOnHover: false,';
                    }

                    $output .='
                    addClassActive: true,
                    items: 1,
                  });
                }
              });
            </script>';

            return $output;
        }



        public function kd_appgallery_single($atts, $content = null) {

            extract(shortcode_atts(array(
                'ag_screenshot'          => ''
            ), $atts));

            $ss_image  = wpb_getImageBySize($params = array(
                'post_id' => NULL,
                'attach_id' => $ag_screenshot,
                'thumb_size' => 'full',
                'class' => ""
            ));

            $output = '<div class="ag-slider-child">
                        '.$ss_image['thumbnail'].'
                      </div>';

            return $output;
        }
    }
}

if (class_exists('tek_appgallery')) {
    $tek_appgallery = new tek_appgallery;
}

?>
