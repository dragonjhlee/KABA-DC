<?php
add_action('admin_menu', array('SrizonFBAdmin', 'renderMenu'));

class SrizonFBAdmin
{
    static function renderMenu()
    {
        $menuHook1 = add_menu_page(__('FB Album Pro', 'srizon-facebook-album'), __('FB Album Pro', 'srizon-facebook-album'),
            'manage_options', 'SrzFb', array('SrizonFBAdmin', 'renderCommonOptions'),
            srz_fb_get_resource_url('resources/images/srzfb-icon.png'));

        $menuHook2 = add_submenu_page('SrzFb', "FB Album Pro", __('Albums', 'srizon-facebook-album'),
            'edit_posts', 'SrzFb-Albums', 'srz_fb_albums');

        $menuHook3 = add_submenu_page('SrzFb', "FB Album Pro", __('Galleries', 'srizon-facebook-album'),
            'edit_posts', 'SrzFb-Galleries', 'srz_fb_galleries');

        $menuHook4 = add_submenu_page('SrzFb', "FB Album Pro", __('Token Replacer', 'srizon-facebook-album'),
            'manage_options', 'SrzFb-TokenReplacer', array('SrizonFBTokenReplacer', 'render'));

        self::addMenuHooks($menuHook1, $menuHook2, $menuHook3, $menuHook4);
        self::renameDefaultMenu();
    }

    static function addMenuHooks($menuHook1, $menuHook2, $menuHook3, $menuHook4)
    {
        add_action("admin_print_scripts-{$menuHook1}", array('SrizonFBAdmin', 'loadAdminCssAndJSFiles'));
        add_action("admin_print_scripts-{$menuHook2}", array('SrizonFBAdmin', 'loadAdminCssAndJSFiles'));
        add_action("admin_print_scripts-{$menuHook3}", array('SrizonFBAdmin', 'loadAdminCssAndJSFiles'));
        add_action("admin_print_scripts-{$menuHook4}", array('SrizonFBAdmin', 'loadAdminCssAndJSFiles'));
    }

    static function renameDefaultMenu()
    {
        if (current_user_can('manage_options')) {
            global $submenu;
            $submenu['SrzFb'][0][0] = __('Common Options', 'srizon-facebook-album');
        }
    }

    static function loadAdminCssAndJSFiles()
    {
        wp_enqueue_style('srzfbadmin', WP_PLUGIN_URL . '/srizon-facebook-album-pro/admin/resources/admin.css',
            null, '1.0');
        wp_enqueue_style('srztachyons', WP_PLUGIN_URL . '/srizon-facebook-album-pro/admin/resources/tachyons.css',
            null, '1.0');
        wp_enqueue_script('srzfbadmin', WP_PLUGIN_URL . '/srizon-facebook-album-pro/admin/resources/admin.js',
            array('jquery'), '1.0');
    }

    static function renderCommonOptions()
    {
        SrizonFBUI::startPageWrap();
        self::renderTitle();
        SrizonFBUI::startOptionWrapper();
        self::renderRightColumn();
        self::renderLeftColumn();
        SrizonFBUI::endOptionWrapper();
        SrizonFBUI::endPageWrap();
    }

    static function renderTitle()
    {
        echo '<h2>' . __('Srizon FB Album Option Page', 'srizon-facebook-album') . '</h2>';
    }

    static function renderRightColumn()
    {
        SrizonFBUI::startRightColumn();
        SrizonFBCommonOptionsBlocks::renderAbout();
        SrizonFBCommonOptionsBlocks::renderWhatToDo();
        SrizonFBUI::endRightColumn();
    }

    static function renderLeftColumn()
    {
        $optvar = self::getOptions();
        SrizonFBUI::startLeftColumn();
        include 'forms/common-option-form.php'; // $optvar used here
        SrizonFBUI::endLeftColumn();
    }

    static function getOptions()
    {
        if (isset($_POST['submit'])) {
            self::checkNonce();
            $optvar = stripslashes_deep(SrizonFBDB::SaveCommonOpt());
        } else {
            $optvar = stripslashes_deep(SrizonFBDB::GetCommonOpt());
        }
        return $optvar;
    }

    static function checkNonce()
    {
        if (wp_verify_nonce($_POST['srjfb_submit'], 'SrjFb') == false) {
            die('Form token mismatch!');
        }
    }

}

