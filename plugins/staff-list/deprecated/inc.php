<?php
//--------------------------------------------------------
function abcfsl_util_img_alt( $imgID ){

    $imgMeta = '';
    if($imgID > 0){ $imgMeta = get_post_meta($imgID, '_wp_attachment_image_alt', true); }

    return $imgMeta;
}

