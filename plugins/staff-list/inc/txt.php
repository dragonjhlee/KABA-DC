<?php

function abcfsl_txt($id, $suffix='') {
    switch ($id){
        case 1:
            $out = __('Why Single Page is blank?&nbsp;', 'staff-list');
            break;
        case 4:
            $out = __('<a href="http://abcfolio.com/wordpress-plugin-staff-list-single-page-hyperlinks/"> Documentation.</a>', 'staff-list');
            break;
        default:
            $out = '';
            break;
    }
    return $out . $suffix;
}
function abcfsl_txt_err ($id, $suffix='', $bold=false) {
    $txt = abcfsl_txt($id, $suffix='');
    return '<div class="abcflRed">' . $txt . '</div>';

}