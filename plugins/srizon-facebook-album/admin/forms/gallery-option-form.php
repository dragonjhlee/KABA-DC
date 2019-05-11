<form action="admin.php?page=SrzFb-Galleries&srzl=save" method="post">
	<?php SrizonFBUI::renderBoxHeader( 'box1', __( "Gallery Title", 'srizon-facebook-album' ), true ); ?>
    <table class="srzfb-admin-album" width="100%">
        <tr>
            <td colspan="2">
                <input type="text" name="title" style="width: 100%" value="<?php echo $value_arr['title']; ?>"/>
            </td>
        </tr>
    </table>
	<?php

	SrizonFBUI::renderBoxFooter();
	SrizonFBUI::renderBoxHeader( 'box2', __( "Access Token", 'srizon-facebook-album' ), true );
	?>
    <div>
        <table class="srzfb-admin-album" width="100%">
            <tr>
                <td width="25%"><label><?php _e( 'Access Token', 'srizon-facebook-album' ); ?></label></td>
                <td>
                    <input type="text" name="options[access_token]" style="width: 100%"
                           value="<?php echo $value_arr['access_token']; ?>"/>
                    <p class="srz-admin-subtext">
						<?php _e( 'You can generate Access Tokens on <a href="https://fb.srizon.com" target="_blank">fb.srizon.com</a>', 'srizon-facebook-album' ); ?>
                    </p>
                    <p class="srz-admin-subtext">
						<?php _e( 'Note that each Access Token is bound to a Profile or Page. And gallery will be created from the Page/Profile the access token is created for', 'srizon-facebook-album' ); ?>
                    </p>
                </td>
            </tr>
        </table>
    </div>
	<?php
	SrizonFBUI::renderBoxFooter();
	SrizonFBUI::renderBoxHeader( 'box3', __( "Include or Exclude Albums", 'srizon-facebook-album' ), true );
	?>
    <div>
        <table class="srzfb-admin-gallery">
            <tr>
                <td colspan="2"><em>Available on <a href="https://srizon.com/product/srizon-facebook-album"
                                                    target="_blank">Pro Version</a> Only</em></td>
            </tr>
        </table>
    </div>
	<?php
	SrizonFBUI::renderBoxFooter();
	SrizonFBUI::renderBoxHeader( 'box33', __( "Layout Related", 'srizon-facebook-album' ), true );
	?>

    <table class="srzfb-admin-gallery">
        <tr>
            <td width="30%"><label for="maxheight"
                                   class="label"><?php _e( 'Target Thumb Height', 'srizon-facebook-album' ); ?></label>
            </td>
            <td>
                <input id="maxheight" name="options[maxheight]"
                       type="text"
                       value="<?php echo $value_arr['maxheight']; ?>"
                />

                <p class="srz-admin-subtext"><?php _e( 'This may not be the exact height but closer to this.', 'srizon-facebook-album' ); ?></p>
            </td>
        </tr>
        <tr>
            <td><label for="collagepadding"
                       class="label"><?php _e( 'Collage - Padding', 'srizon-facebook-album' ); ?></label></td>
            <td>
                <input id="collagepadding" name="options[collagepadding]"
                       type="text"
                       value="<?php echo $value_arr['collagepadding']; ?>"
                />


            </td>
        </tr>
        <tr>
            <td><label for="collagepartiallast"
                       class="label"><?php _e( 'Collage - Fill Last Row', 'srizon-facebook-album' ); ?></label>
            </td>
            <td>
                <select id="collagepartiallast" name="options[collagepartiallast]"

                        class="btn-group btn-group-yesno"
                >
                    <option value="true" <?php if ( $value_arr['collagepartiallast'] == 'true' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'No', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="false" <?php if ( $value_arr['collagepartiallast'] == 'false' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Yes', 'srizon-facebook-album' ); ?>
                    </option>
                </select>


            </td>
        </tr>
        <tr>
            <td><label for="hovercaptiontypecover"
                       class="label"><?php _e( 'Caption Behavior (Cover Photos)', 'srizon-facebook-album' ); ?></label>
            </td>
            <td>
                <select id="hovercaptiontypecover" name="options[hovercaptiontypecover]"
                >
                    <option value="0" <?php if ( $value_arr['hovercaptiontypecover'] == '0' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Show On Hover - Hide On Leave', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="1" <?php if ( $value_arr['hovercaptiontypecover'] == '1' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Hide On Hover - Show On Leave', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="2" <?php if ( $value_arr['hovercaptiontypecover'] == '2' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Always Show', 'srizon-facebook-album' ); ?>
                    </option>
                </select>


            </td>
        </tr>
        <tr>
            <td><label for="hovercaption"
                       class="label"><?php _e( 'Mouse Over Caption (Album Photos)', 'srizon-facebook-album' ); ?></label>
            </td>
            <td>
                <select id="hovercaption" name="options[hovercaption]"

                        class="hovercaption"
                >
                    <option value="1" <?php if ( $value_arr['hovercaption'] == '1' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Yes', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="0" <?php if ( $value_arr['hovercaption'] == '0' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'No', 'srizon-facebook-album' ); ?>
                    </option>
                </select>
            </td>
        </tr>
        <tr class="srz-cond" data-cond-option="hovercaption" data-cond-value="1">
            <td><label for="hovercaptiontype"
                       class="label"><?php _e( 'Caption Behavior (Album Photos)', 'srizon-facebook-album' ); ?></label>
            </td>
            <td>
                <select id="hovercaptiontype" name="options[hovercaptiontype]"
                >
                    <option value="0" <?php if ( $value_arr['hovercaptiontype'] == '0' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Show On Hover - Hide On Leave', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="1" <?php if ( $value_arr['hovercaptiontype'] == '1' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Hide On Hover - Show On Leave', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="2" <?php if ( $value_arr['hovercaptiontype'] == '2' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Always Show', 'srizon-facebook-album' ); ?>
                    </option>
                </select>


            </td>
        </tr>
        <tr>
            <td><label for="show_image_count"
                       class="label"><?php _e( 'Show Image Count On Album Cover', 'srizon-facebook-album' ); ?></label>
            </td>
            <td>
                <select id="show_image_count" name="options[show_image_count]"

                        class="btn-group btn-group-yesno"
                >
                    <option value="1" <?php if ( $value_arr['show_image_count'] == '1' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Yes', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="0" <?php if ( $value_arr['show_image_count'] == '0' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'No', 'srizon-facebook-album' ); ?>
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="showhoverzoom"
                       class="label"><?php _e( 'Animate Thumb on Hover', 'srizon-facebook-album' ); ?></label></td>
            <td>
                <select id="showhoverzoom" name="options[showhoverzoom]"

                        class="btn-group btn-group-yesno"
                >
                    <option value="1" <?php if ( $value_arr['showhoverzoom'] == '1' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Yes', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="0" <?php if ( $value_arr['showhoverzoom'] == '0' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'No', 'srizon-facebook-album' ); ?>
                    </option>
                </select>


            </td>
        </tr>

    </table>
	<?php
	SrizonFBUI::renderBoxFooter();
	SrizonFBUI::renderBoxHeader( 'box4', __( "Options", 'srizon-facebook-album' ), true );
	?>
    <table class="srzfb-admin-gallery">
        <tr>
            <td>
                <span class="label"><?php _e( 'Album text', 'srizon-facebook-albums' ); ?></span>
            </td>
            <td>
                <input type="text" name="options[albumtxt]" value="<?php echo $value_arr['albumtxt']; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label"><?php _e( 'Back To Gallery text', 'srizon-facebook-albums' ); ?></span>
            </td>
            <td>
                <input type="text" name="options[backtogallerytxt]"
                       value="<?php echo $value_arr['backtogallerytxt']; ?>"/>
            </td>
        </tr>
        <tr>
            <td width="30%">
				<span
                        class="label"><?php _e( 'Sync After Every # minutes', 'srizon-facebook-album' ); ?></span>
            </td>
            <td>
                <input type="text" size="5" name="options[updatefeed]"
                       value="<?php echo $value_arr['updatefeed']; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label"><?php _e( 'Album (Cover) Sorting', 'srizon-facebook-album' ); ?></span>
            </td>
            <td>
                <select name="options[album_sorting]">
                    <option value="default" <?php if ( $value_arr['album_sorting'] == 'default' )
						echo 'selected="selected"' ?>><?php _e( 'Default (As given by FB API)', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="defaultr" <?php if ( $value_arr['album_sorting'] == 'defaultr' )
						echo 'selected="selected"' ?>><?php _e( 'Default Reversed', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="modified" <?php if ( $value_arr['album_sorting'] == 'modified' )
						echo 'selected="selected"' ?>><?php _e( 'Modification Time', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="modifiedr" <?php if ( $value_arr['album_sorting'] == 'modifiedr' )
						echo 'selected="selected"' ?>><?php _e( 'Modification Time Reversed', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="created" <?php if ( $value_arr['album_sorting'] == 'created' )
						echo 'selected="selected"' ?>><?php _e( 'Creation Time', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="createdr" <?php if ( $value_arr['album_sorting'] == 'createdr' )
						echo 'selected="selected"' ?>><?php _e( 'Creation Time Reversed', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="shuffle" <?php if ( $value_arr['album_sorting'] == 'shuffle' )
						echo 'selected="selected"' ?>><?php _e( 'Shuffle on each load', 'srizon-facebook-album' ); ?>
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label"><?php _e( 'Images Sorting (Inside each Album)', 'srizon-facebook-album' ); ?></span>
            </td>
            <td>
                <select name="options[image_sorting]">
                    <option value="default" <?php if ( $value_arr['image_sorting'] == 'default' )
						echo 'selected="selected"' ?>><?php _e( 'Default (As given by FB API)', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="defaultr" <?php if ( $value_arr['image_sorting'] == 'defaultr' )
						echo 'selected="selected"' ?>><?php _e( 'Default Reversed', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="modified" <?php if ( $value_arr['image_sorting'] == 'modified' )
						echo 'selected="selected"' ?>><?php _e( 'Modification Time', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="modifiedr" <?php if ( $value_arr['image_sorting'] == 'modifiedr' )
						echo 'selected="selected"' ?>><?php _e( 'Modification Time Reversed', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="created" <?php if ( $value_arr['image_sorting'] == 'created' )
						echo 'selected="selected"' ?>><?php _e( 'Creation Time', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="createdr" <?php if ( $value_arr['image_sorting'] == 'createdr' )
						echo 'selected="selected"' ?>><?php _e( 'Creation Time Reversed', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="shuffle" <?php if ( $value_arr['image_sorting'] == 'shuffle' )
						echo 'selected="selected"' ?>><?php _e( 'Shuffle on each load', 'srizon-facebook-album' ); ?>
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label class="label"
                       for="totalimg"><?php _e( 'Total Number of Images', 'srizon-facebook-album' ); ?></label>
            </td>
            <td>
                <input type="text" size="5" name="options[totalimg]" id="totalimg"
                       value="<?php echo $value_arr['totalimg']; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label"><?php _e( 'Paginate After # Images', 'srizon-facebook-album' ); ?></span>
            </td>
            <td>
                <input type="text" size="5" name="options[paginatenum]"
                       value="<?php echo $value_arr['paginatenum']; ?>"/>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div>
                    <span class="label"><?php wp_nonce_field( 'SrzFbGalleries', 'srjfb_submit' ); ?></span>
					<?php
					if ( isset( $value_arr['id'] ) ) {
						echo '<input type="hidden" name="id" value="' . $value_arr['id'] . '" />';
					}
					?>
                    <input type="submit" class="button-primary" name="submit"
                           value="<?php _e( 'Save Gallery', 'srizon-facebook-album' ); ?>"/>
                </div>
            </td>
        </tr>
    </table>
	<?php
	SrizonFBUI::renderBoxFooter();
	?>

</form>