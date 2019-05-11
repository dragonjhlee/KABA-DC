<form action="admin.php?page=SrzFb-Albums&srzl=save" method="post">
	<?php SrizonFBUI::renderBoxHeader( 'box1', __( "Album Title", 'srizon-facebook-album' ), true ); ?>
    <table class="srzfb-admin-album" width="100%">
        <tr>
            <td colspan="2">
                <input type="text" name="title" style="width: 100%" value="<?php echo $value_arr['title']; ?>"/>
            </td>
        </tr>
    </table>
	<?php

	SrizonFBUI::renderBoxFooter();
	SrizonFBUI::renderBoxHeader( 'box2', __( "Album Source", 'srizon-facebook-album' ), true );
	?>
    <div>
        <table class="srzfb-admin-album" width="100%">
            <tr>
                <td width="20%"><label for=""><?php _e( 'Access Token', 'srizon-facebook-album' ); ?></label></td>
                <td>
                    <input type="text" name="options[access_token]" style="width: 100%"
                           value="<?php echo $value_arr['access_token']; ?>"/>

                    <p class="srz-admin-subtext">
						<?php _e( 'You can generate Access Tokens on <a href="https://fb.srizon.com" target="_blank">fb.srizon.com</a>', 'srizon-facebook-album' ); ?>
                    </p>
                    <p class="srz-admin-subtext">
						<?php _e( 'Note that each Access Token is bound to a Profile or Page. Make sure the album ids you put below are from the same Profile or Page', 'srizon-facebook-album' ); ?>
                    </p>

                </td>
            </tr>
            <tr>
                <td><label for=""><?php _e( 'Album ID(s)', 'srizon-facebook-album' ); ?></label></td>
                <td>
					<textarea name="albumid" id="albumid" rows="5"
                              cols="50"><?php echo $value_arr['albumid']; ?></textarea>

                    <p class="srz-admin-subtext">
						<?php _e( 'You can find the Album IDs when you generate Access Tokens on <a href="https://fb.srizon.com" target="_blank">fb.srizon.com</a>', 'srizon-facebook-album' ); ?>
                    </p>

                    <p class="srz-admin-subtext"><?php _e( 'Separate multiple IDs with newline or whitespace (They will be merged into a single album)', 'srizon-facebook-album' ); ?></p>

                </td>
            </tr>
        </table>


        <div></div>
    </div>
	<?php
	SrizonFBUI::renderBoxFooter();
	SrizonFBUI::renderBoxHeader( 'box3', __( "Layout Related", 'srizon-facebook-album' ), true );
	?>

    <table class="srzfb-admin-album">
        <tr>
            <td>
                <label class="label"
                       for="layout"><strong><?php _e( 'Layout', 'srizon-facebook-album' ); ?></strong></label>
            </td>
            <td>
                <select name="options[layout]" id="layout" class="layout-options">
                    <option value="collage_thumb" <?php if ( $value_arr['layout'] == 'collage_thumb' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '1. Collage - Thumb', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="collage_full" <?php if ( $value_arr['layout'] == 'collage_full' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '2. Collage - Full', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="slider_lightbox" <?php if ( $value_arr['layout'] == 'slider_lightbox' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '3. Slider - Lightbox', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="slider_image_above" <?php if ( $value_arr['layout'] == 'slider_image_above' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '4. Slider - Image Above', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="slider_image_below" <?php if ( $value_arr['layout'] == 'slider_image_below' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '5. Slider - Image Below', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="single_image" <?php if ( $value_arr['layout'] == 'single_image' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '6. Single Image', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="image_card" <?php if ( $value_arr['layout'] == 'image_card' ) {
						echo 'selected="selected"';
					} ?>><?php _e( '7. Image Card', 'srizon-facebook-album' ); ?>
                    </option>
                </select>
            </td>
        </tr>

        <tr class="srz-cond" data-cond-option="layout-options"
            data-cond-value="collage_thumb,slider_lightbox,slider_image_above,slider_image_below">
            <td><label for="targetheight"
                       class="label"><?php _e( 'Target Thumb Height', 'srizon-facebook-album' ); ?></label></td>
            <td>
                <input id="targetheight" name="options[targetheight]"
                       type="text"
                       value="<?php echo $value_arr['targetheight']; ?>"
                />

                <p class="srz-admin-subtext"><?php _e( 'This may not be the exact height but closer to this', 'srizon-facebook-album' ); ?></p>
            </td>
        </tr>
        <tr class="srz-cond" data-cond-option="layout-options" data-cond-value="collage_thumb,collage_full">
            <td><label for="collagepadding"
                       class="label"><?php _e( 'Collage - Padding', 'srizon-facebook-album' ); ?></label></td>
            <td>
                <input id="collagepadding" name="options[collagepadding]"
                       type="text"
                       value="<?php echo $value_arr['collagepadding']; ?>"
                />

                <p class="srz-admin-subtext"><?php _e( 'Padding size around each image', 'srizon-facebook-album' ); ?></p>

            </td>
        </tr>
        <tr class="srz-cond" data-cond-option="layout-options" data-cond-value="collage_thumb,collage_full">
            <td><label for="collagepartiallast"
                       class="label"><?php _e( 'Collage - Fill Last Row', 'srizon-facebook-album' ); ?>
                </label></td>
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

                <p class="srz-admin-subtext"><?php _e( 'Stretch the image of the last row to fill the space', 'srizon-facebook-album' ); ?></p>

            </td>
        </tr>
        <tr class="srz-cond" data-cond-option="layout-options"
            data-cond-value="collage_thumb,collage_full,slider_image_above,slider_image_below,single_image,image_card">
            <td><label for="hovercaption"
                       class="label"><?php _e( 'Mouse-over Caption', 'srizon-facebook-album' ); ?></label></td>
            <td>
                <em>Available on <a href="https://srizon.com/product/srizon-facebook-album"
                                    target="_blank">Pro Version</a> Only</em></td>
        </tr>
        <tr class="srz-cond" data-cond-option="layout-options" data-cond-value="collage_thumb">
            <td><label for="showhoverzoom"
                       class="label"><?php _e( 'Animate Thumb on Hover', 'srizon-facebook-album' ); ?></label>
            </td>
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
        <tr class="srz-cond" data-cond-option="layout-options"
            data-cond-value="slider_lightbox,slider_image_above,slider_image_below,single_image">
            <td><label for="animationspeed"
                       class="label"><?php _e( 'Animation Time in MilliSecs', 'srizon-facebook-album' ); ?></label></td>
            <td>
                <input id="animationspeed" name="options[animationspeed]"
                       type="text"
                       value="<?php echo $value_arr['animationspeed']; ?>"
                />


            </td>
        </tr>
        <tr class="srz-cond" data-cond-option="layout-options"
            data-cond-value="slider_lightbox,slider_image_above,slider_image_below">
            <td><label for="autoslideinterval"
                       class="label"><?php _e( 'AutoSlide Interval in Seconds.', 'srizon-facebook-album' ); ?>
                </label></td>
            <td>
                <input id="autoslideinterval" name="options[autoslideinterval]"
                       type="text"
                       value="<?php echo $value_arr['autoslideinterval']; ?>"
                />

                <p class="srz-admin-subtext"><?php _e( 'Put 0 for disabling autoSlide', 'srizon-facebook-album' ); ?></p>
            </td>
        </tr>
        <tr class="srz-cond" data-cond-option="layout-options"
            data-cond-value="collage_full,slider_image_above,slider_image_below,single_image,image_card">
            <td><label for="maxheight"
                       class="label"><?php _e( 'Maximum height of the full image', 'srizon-facebook-album' ); ?></label>
            </td>
            <td>
                <input id="maxheight" name="options[maxheight]"
                       type="text"
                       value="<?php echo $value_arr['maxheight']; ?>"
                /></td>
        </tr>

    </table>
	<?php
	SrizonFBUI::renderBoxFooter();
	SrizonFBUI::renderBoxHeader( 'box4', __( "Options", 'srizon-facebook-album' ), true );
	?>
    <table class="srzfb-admin-album">
        <tr>
            <td>
                <label for="updatefeed"
                       class="label"><?php _e( 'Sync After Every # minutes', 'srizon-facebook-album' ); ?></label>
            </td>
            <td>
                <input type="text" size="5" name="options[updatefeed]" id="updatefeed"
                       value="<?php echo $value_arr['updatefeed']; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <label class="label"
                       for="image_sorting"><?php _e( 'Images Sorting', 'srizon-facebook-album' ); ?></label>
            </td>
            <td>
                <select name="options[image_sorting]" id="image_sorting">
                    <option value="default" <?php if ( $value_arr['image_sorting'] == 'default' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Default (As given by FB API)', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="defaultr" <?php if ( $value_arr['image_sorting'] == 'defaultr' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Default Reversed', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="modified" <?php if ( $value_arr['image_sorting'] == 'modified' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Modification Time', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="modifiedr" <?php if ( $value_arr['image_sorting'] == 'modifiedr' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Modification Time Reversed', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="created" <?php if ( $value_arr['image_sorting'] == 'created' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Creation Time', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="createdr" <?php if ( $value_arr['image_sorting'] == 'createdr' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Creation Time Reversed', 'srizon-facebook-album' ); ?>
                    </option>
                    <option value="shuffle" <?php if ( $value_arr['image_sorting'] == 'shuffle' ) {
						echo 'selected="selected"';
					} ?>><?php _e( 'Shuffle on each load', 'srizon-facebook-album' ); ?>
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
                <label class="label"
                       for="paginatenum"><?php _e( 'Paginate After # Thumbs', 'srizon-facebook-album' ); ?></label>
            </td>
            <td>
                <input type="text" size="5" id="paginatenum" name="options[paginatenum]"
                       value="<?php echo $value_arr['paginatenum']; ?>"/>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label class="label"><?php wp_nonce_field( 'srz_fb_albums', 'srjfb_submit' ); ?></label>
				<?php
				if ( isset( $value_arr['id'] ) ) {
					echo '<input type="hidden" name="id" value="' . $value_arr['id'] . '" />';
				}
				?>
                <input type="submit" class="button-primary" name="submit"
                       value="<?php _e( 'Save Album', 'srizon-facebook-album' ); ?>"/>
            </td>
        </tr>
    </table>
	<?php SrizonFBUI::renderBoxFooter(); ?>
</form>