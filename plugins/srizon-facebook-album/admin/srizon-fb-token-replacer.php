<?php

class SrizonFBTokenReplacer
{
    static function render()
    {
        self::saveIfSubmitted();
        SrizonFBUI::startPageWrap();
        self::renderTitle();
        self::renderBody();
        SrizonFBUI::endPageWrap();
    }

    static function renderTitle()
    {
        echo '<h2 class="mb3">Token Replacer <small>(batch operation)</small></h2>';
        echo '<h3 class="mb4">Generate fresh tokens at <a target="_blank" href="https://fb.srizon.com">fb.srizon.com</a> to replace the old or expired tokens.<br /> 
<small>Facebook Tokens usually expire in 60 days. So you need to replace tokens every 2 months</small></h3>';
    }

    static function renderBody()
    {
        $tokens = SrizonFBTokenExtractor::getAllTokens();
        foreach ($tokens as $token) {
            self::renderTokenPanel($token);
        }
        if(count($tokens)==0){
            echo '<p class="mv4">You have no albums or galleries. Add some albums or galleries first and then you can use this page to replace tokens.</p>';
        }
    }

    private static function renderTokenPanel($token)
    {

        echo '<h4>'
            . self::showRelatedGalleryList($token)
            . self::showAndTextIfApplicable($token)
            . self::showRelatedAlbumList($token)
            . self::showUsingText($token)
            . '</h4>';
        self::renderReplaceTokenForm($token);
    }

    private static function showRelatedGalleryList($token)
    {
        $str = '';
        $galleries = array();
        if (isset($token['galleries'])) {
            if (count($token['galleries']) > 1) {
                $str .= 'These Galleries: ';
            } else {
                $str .= 'This Gallery: ';
            }
            foreach ($token['galleries'] as $gallery) {
                $galleries[] = '<a href="admin.php?page=SrzFb-Galleries&amp;srzf=edit&amp;id=' . $gallery['id'] . '">' . $gallery['title'] . '</a>';
            }
            $str .= implode(', ', $galleries);
        }
        return $str;
    }

    private static function showAndTextIfApplicable($token)
    {
        if (isset($token['galleries']) && isset($token['albums'])) return ' And ';
        return '';
    }

    private static function showRelatedAlbumList($token)
    {
        $str = '';
        $galleries = array();
        if (isset($token['albums'])) {
            if (count($token['albums']) > 1) {
                $str .= 'These Albums: ';
            } else {
                $str .= 'This Album: ';
            }
            foreach ($token['albums'] as $gallery) {
                $galleries[] = '<a href="admin.php?page=SrzFb-Albums&amp;srzf=edit&amp;id=' . $gallery['id'] . '">' . $gallery['title'] . '</a>';
            }
            $str .= implode(', ', $galleries);
        }
        return $str;
    }

    private static function showUsingText($token)
    {
        $count = 0;
        if (isset($token['albums'])) {
            $count = $count + count($token['albums']);
        }
        if (isset($token['galleries'])) {
            $count = $count + count($token['galleries']);
        }
        if ($count > 1) {
            return ' are using the following token:';
        } else {
            return ' is using the following token:';
        }
    }

    private static function renderReplaceTokenForm($token)
    {
        $message = '';
        if ($_REQUEST['srzl'] == 'save' && $token['val'] == $_POST['newToken']) {
            $message = '<p class="green-t mb0">Token updated!</p>';
        }
        echo <<<EOL
        <form class="mb4" action="admin.php?page=SrzFb-TokenReplacer&srzl=save" method="post">
            {$message}
            <input type="text" readonly name="token" value="{$token['val']}" size="90" />
            <p class="mt3 mb1">Enter new token below and click Replace Token button to replace it</p>
            <input type="text" name="newToken" value="" size="90" />
            <input type="hidden" name="oldToken" value="{$token['val']}" />
            <p class="mv2">
            <input class="pointer button" type="submit" value="Replace Token" />
            </p>
        </form>
        <hr />
EOL;

    }

    private static function saveIfSubmitted()
    {
        $oldToken = trim($_POST['oldToken']);
        $newToken = trim($_POST['newToken']);
        if ($_REQUEST['srzl'] == 'save' && isset($_POST['newToken'])) {
            if (!$newToken) {
                echo '<h2 class="red-td1 center mv3">You submitted an empty value for a token. Enter a valid token</h2>';
            } else if (!$oldToken) {
                echo '<h2 class="red-td1 center mv3">Invalid Request</h2>';
            } else {
                self::replaceToken($oldToken, $newToken);
            }
        }
    }

    private static function replaceToken($oldToken, $newToken)
    {
        $albumsAndGalleries = SrizonFBTokenExtractor::getAllAlbumsAndGalleries();
        if ($oldToken == 'empty') {
            $oldToken = '';
        }
        foreach ($albumsAndGalleries as $item) {
            if (trim($item->token) == $oldToken) {
                self::processItem($item->id, $item->type, $newToken);
            }
        }
    }

    private static function processItem($id, $type, $newToken)
    {
        global $wpdb;
        $data = array();
        if ($type == 'album') {
            $table = $wpdb->prefix . 'srzfb_albums';
            $item = SrizonFBDB::GetAlbumRaw($id);
            $data['albumid'] = $item['albumid'];
        } else {
            $table = $wpdb->prefix . 'srzfb_galleries';
            $item = SrizonFBDB::GetGalleryRaw($id);
        }

        $data['title'] = $item['title'];
        $item['options']['access_token'] = $newToken;
        $data['options'] = serialize($item['options']);

        $wpdb->update($table, $data, array('id' => $id));

    }
}

