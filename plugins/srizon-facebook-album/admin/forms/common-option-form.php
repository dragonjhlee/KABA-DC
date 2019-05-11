<?php
SrizonFBUI::renderBoxHeader( 'pro-version', "Get The Pro Version", true, 'closed' );
?>
    <table class="srzfb-admin-common">
        <tr>
            <td colspan="2">
                <h4>Limitations of this version</h4>
                <ol>
                    <li>Each album can display only 25 images or less</li>
                    <li>Each gallery can display 25 or less album covers. Each cover will open an album with not more
                        than 25 images
                    </li>
                    <li>No caption for images</li>
                </ol>
                <h4>What's in the pro version</h4>
                <ol>
                    <li>Each album can display all the images from facebook. No limitation</li>
                    <li>Each gallery will show all the album covers. Each cover will open the full album</li>
                    <li>Description of each image from facebook will be used as image caption which is shown below the
                        lightbox photo
                    </li>
                    <li>For each gallery you can Include a selected few albums or exclude a few albums and show all
                        other albums
                    </li>
                </ol>
                <h4>Get the pro version now</h4>
                <a target="_blank"
                   href="https://srizon.com/product/srizon-facebook-album/">https://srizon.com/product/srizon-facebook-album/</a>

                <p>If you already have purchased the pro version and need support then create a <a
                            href="http://support.srizon.com" target="_blank">Support Ticket</a></p>
            </td>
        </tr>
    </table>
<?php
SrizonFBUI::renderBoxFooter();
SrizonFBUI::renderBoxHeader( 'box3', __( "Common Options", 'srizon-facebook-album' ), true );
?>
    <form action="admin.php?page=SrzFb" method="post">
        <table class="srzfb-admin-common">
            <tr>
                <td>
                    <span class="label"><?php _e( 'Album text', 'srizon-facebook-album' ); ?></span>
                </td>
                <td>
                    <input type="text" name="albumtxt" value="<?php echo $optvar['albumtxt']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label"><?php _e( 'Back To Gallery text', 'srizon-facebook-album' ); ?></span>
                </td>
                <td>
                    <input type="text" name="backtogallerytxt" value="<?php echo $optvar['backtogallerytxt']; ?>"/>
                </td>
            </tr>
            <tr>
                <td width="20%">
                    <span class="label"><?php _e( 'Lightbox Selection:', 'srizon-facebook-album' ); ?></span>
                </td>
                <td>
                    <input type="radio" name="loadlightbox"
                           value="mp"<?php if ( $optvar['loadlightbox'] == 'mp' ) {
						echo ' checked="checked"';
					} ?> /><?php _e( 'Built in Responsive Lightbox', 'srizon-facebook-album' ); ?>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <input type="radio" name="loadlightbox"
                                                                       value="no"<?php if ( $optvar['loadlightbox'] == 'no' ) {
						echo ' checked="checked"';
					} ?> /><?php _e( 'Other Lightbox', 'srizon-facebook-album' ); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label"><?php _e( 'Lightbox Link Attribute', 'srizon-facebook-album' ); ?></span>
                </td>
                <td>
                    <input type="text" size="30" name="lightboxattrib"
                           value='<?php echo $optvar['lightboxattrib']; ?>'/>

                    <p class="srz-admin-subtext"><?php _e( '(Might be required for Other Lightbox)', 'srizon-facebook-album' ); ?></p>
                </td>
            </tr>
            <tr>
                <td><span class="label"><?php _e( 'Scroll to target', 'srizon-facebook-album' ); ?></span></td>
                <td>
                    <input type="radio" name="jumptoarea"
                           value="false"<?php if ( $optvar['jumptoarea'] == 'false' ) {
						echo ' checked="checked"';
					} ?> /> <?php _e( 'No', 'srizon-facebook-album' ); ?> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <input
                            type="radio" name="jumptoarea"
                            value="true"<?php if ( $optvar['jumptoarea'] == 'true' ) {
						echo ' checked="checked"';
					} ?> /> <?php _e( 'Yes', 'srizon-facebook-album' ); ?>
                    <p class="srz-admin-subtext"><?php _e( 'Scroll to album area when an album/pagination link is clicked?', 'srizon-facebook-album' ); ?></p>
                </td>

            </tr>

            <tr>
                <td>
                    <span class="label"><?php wp_nonce_field( 'SrjFb', 'srjfb_submit' ); ?></span>
                </td>
                <td>
                    <input type="submit" class="button-primary" name="submit"
                           value="<?php _e( 'Save Options', 'srizon-facebook-album' ); ?>"/>
                </td>
            </tr>


            <tr>
                <td colspan="2">
                    <strong><?php _e('Facebook Access Token creation moved to a dedicated site <a href="https://fb.srizon.com" target="_blank">fb.srizon.com</a>', 'srizon-facebook-album'); ?></strong><br>
                    <br>
					<?php _e( 'Facebook changed things so it\'s no longer easy to create your own App and get your albums with that App. I have created a new site so that you can generate your access token easily. Go to  <a href="https://fb.srizon.com" target="_blank">fb.srizon.com</a> to create your access token', 'srizon-facebook-album' ); ?>
                    <h4>After generating tokens copy and paste them inside each album/gallery where the token is
                        applicable (albums/galleries from different Facebook page/account will need different token). For batch updating tokens for
                        multiple albums/galleries, you can use the <a
                                href="admin.php?page=SrzFb-TokenReplacer">Token Replacer</a> tool.</a> </h4>
                </td>
            </tr>

        </table>
    </form>
<?php
SrizonFBUI::renderBoxFooter();
