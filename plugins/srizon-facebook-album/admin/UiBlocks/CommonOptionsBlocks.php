<?php

class SrizonFBCommonOptionsBlocks
{
    static function renderWhatToDo()
    {
        SrizonFBUI::renderBoxHeader('box-what-to-do', __("What to do:", 'srizon-facebook-album'));
        echo '<p><ol>
    <li>' . __('Setup the options on this page', 'srizon-facebook-album') . '</li>
    <li>' . __('Click on the Albums or Galleries sub-menu', 'srizon-facebook-album') . '</li>
    <li>' . __('Click "Add New" button to add a new album or gallery. (or click on an existing album title to edit that)', 'srizon-facebook-album') . '</li>
    <li>' . __('Fill-up or modify the form and save that', 'srizon-facebook-album') . '</li>
    <li>' . __('Your albums or galleries will be listed along with the shortcodes. Use the shortcodes into your page/post to show the photo album or gallery', 'srizon-facebook-album') . '</li>
    <li>' . __('Try out different options/layouts', 'srizon-facebook-album') . '</li>
</ol></p>';
        SrizonFBUI::renderBoxFooter();
    }

    static function renderAbout()
    {
        SrizonFBUI::renderBoxHeader('box1', __("About This Plugin", 'srizon-facebook-album'));
        echo '<p style="padding-left: 10px">' . __('This Plugin will show your Facebook album(s) into your WordPress site.', 'srizon-facebook-album') . '
    <br> ' . __('Select', 'srizon-facebook-album') . ' <em>' . __('Albums', 'srizon-facebook-album') . '</em> ' . __('or', 'srizon-facebook-album') . ' <em>' . __('Galleries', 'srizon-facebook-album') . '</em> ' . __('from sub-menu and add a new album or gallery', 'srizon-facebook-album') . '.
    <br>' . __('Use the generated shortcode on your post/page to display the album/gallery', 'srizon-facebook-album') . '</p>';
        SrizonFBUI::renderBoxFooter();
    }
}