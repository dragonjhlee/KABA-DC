<?php
if (!class_exists('KD_ELEM_VIDEO')) {
    class KD_ELEM_VIDEO extends KEYDESIGN_ADDON_CLASS {
        function __construct() {
            add_action('init', array($this, 'kd_video_init'));
            add_shortcode('tek_video', array($this, 'kd_video_shrt'));
        }

        // Element configuration in admin
        function kd_video_init() {
            if (function_exists('vc_map')) {
                vc_map(array(
                    "name" => esc_html__("Video Modal", "keydesign"),
                    "description" => esc_html__("Video modal", "keydesign"),
                    "base" => "tek_video",
                    "class" => "",
                    "icon" => plugins_url('assets/element_icons/video-modal.png', dirname(__FILE__)),
                    "category" => esc_html__("KeyDesign Elements", "keydesign"),
                    "params" => array(
                        array(
                            "type" => "dropdown",
                            "class" => "",
                            "heading" => esc_html__("Video source", "keydesign"),
                            "param_name" => "video_source",
                            "value" => array(
                                "YouTube/Vimeo" => "yt-vimeo-video",
                                "HTML5 Video" => "html-video",
                            ),
                            "save_always" => true,
                        ),
            						array(
            							"type" => "kd_param_notice",
            							"text" => "<span style='display: block;'>Please use the YouTube embed link for the video - eg: see the following <a href='".plugins_url('assets/img/youtube-embed.png', dirname(__FILE__))."' target='_blank'>image</a>.</span>",
            							"param_name" => "notification",
            							"edit_field_class" => "vc_column vc_col-sm-12",
                          "dependency" =>	array(
                              "element" => "video_source",
                              "value" => array("yt-vimeo-video")
                          ),
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => esc_html__("Video link", "keydesign"),
                            "param_name" => "video_url",
                            "value" => "",
		                        "description" => esc_html__("Enter link to video.", "keydesign"),
                            "dependency" =>	array(
                                "element" => "video_source",
                                "value" => array("yt-vimeo-video")
                            ),
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => esc_html__("Video title", "keydesign"),
                            "param_name" => "video_title",
                            "value" => "",
		                        "description" => esc_html__("Enter video title.", "keydesign"),
                            "dependency" =>	array(
                                "element" => "video_source",
                                "value" => array("html-video")
                            ),
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => esc_html__("Video URL MP4", "keydesign"),
                            "param_name" => "video_url_mp4",
                            "value" => "",
                            "dependency" =>	array(
                                "element" => "video_source",
                                "value" => array("html-video")
                            ),
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => esc_html__("Video URL OGG", "keydesign"),
                            "param_name" => "video_url_ogg",
                            "value" => "",
                            "dependency" =>	array(
                                "element" => "video_source",
                                "value" => array("html-video")
                            ),
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => esc_html__("Video URL WEBM", "keydesign"),
                            "param_name" => "video_url_webm",
                            "value" => "",
                            "dependency" =>	array(
                                "element" => "video_source",
                                "value" => array("html-video")
                            ),
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => esc_html__("Video height", "keydesign"),
                            "param_name" => "video_height",
                            "value" => "",
		                        "description" => esc_html__("Enter video height. Default value is 400 pixels.", "keydesign"),
                            "dependency" =>	array(
                                "element" => "video_source",
                                "value" => array("html-video")
                            ),
                        ),
                        array(
                            "type" => "attach_image",
                            "heading" => esc_html__("Cover image", "keydesign"),
                            "param_name" => "video_image",
                            "description" => esc_html__("Upload video preview image.", "keydesign")
                        ),
                        array(
                            "type" => "dropdown",
                            "class" => "",
                            "heading" => esc_html__("Open video in", "keydesign"),
                            "param_name" => "video_location",
                            "value" => array(
                                "Modal" => "",
                                "New window" => "video_location_new",
                            ),
                            "save_always" => true,
                            "dependency" =>	array(
                                "element" => "video_source",
                                "value" => array("yt-vimeo-video")
                            ),
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "heading" => esc_html__("Extra class name", "keydesign"),
                            "param_name" => "video_extra_class",
                            "value" => "",
                            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "keydesign")
                        ),
                    )
                ));
            }
        }



		// Render the element on front-end
        public function kd_video_shrt($atts, $content = null)
        {
            extract(shortcode_atts(array(
                'video_source' => '',
                'video_title' => '',
                'video_url' => '',
                'video_url_mp4' => '',
                'video_url_ogg' => '',
                'video_url_webm' => '',
                'video_height' => '',
                'video_location' => '',
                'video_image' => '',
                'video_extra_class' => '',
            ), $atts));

            $image = wpb_getImageBySize($params = array(
                'post_id' => NULL,
                'attach_id' => $video_image,
                'thumb_size' => 'full',
                'class' => ""
            ));

            $image_html = wp_get_attachment_url( $video_image );

            $output = $video_id = '';

            $video_id .= uniqid();
            $vheight = ! empty( $video_height ) ? $video_height : '400px';

            $output = '<div class="video-container '.$video_extra_class.'">
                        '.$image['thumbnail'];
            if ( $video_location == "video_location_new" )  {
                $output .='<a href='.$video_url.' target="_blank">';
            } else {
            $output .='<a data-toggle="modal" data-target="#video-modal-'.$video_id.'" data-backdrop="true">';
            }

            $output .='<span class="play-video"><span class="fa fa-play"></span></span></a>

                        </div>';

            if ( $video_location != "video_location_new" )  {
            $output .= '<div class="modal fade video-modal" id="video-modal-'.$video_id.'" role="dialog">
                            <div class="modal-content">
                                <div class="row">';
                                if ( $video_source == "html-video" && !empty($video_url_mp4) ) {
                                  $output .= '<video class="video-modal-local" title="'.$video_title.'" poster="'.$image_html.'" height="'.$vheight.'" controls>
                                  <source src="'.$video_url_mp4.'" type="video/mp4">';
                                  if (!empty($video_url_ogg)) {
                                    $output .= '<source src="'.$video_url_ogg.'" type="video/ogg">';
                                  }
                                  if (!empty($video_url_webm)) {
                                    $output .= '<source src="'.$video_url_webm.'" type="video/webm">';
                                  }
                                  $output .= '<img alt="" src="'.$image_html.'" title="Video playback is not supported by your browser" />
                                  </video>';
                                } else {
                                 $output .= '<iframe width="712" height="400" src="'.$video_url.'" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                               }
                                $output .= '</div>
                            </div>
                        </div>';
            }
            return $output;
        }
    }
}

if (class_exists('KD_ELEM_VIDEO')) {
    $KD_ELEM_VIDEO = new KD_ELEM_VIDEO;
}

?>
