<?php
if (isset($_POST['submit'])){
	$ecocareerdetailspage = $_POST['eco-career-details-page'];
	update_option('eco-career-details-page', $ecocareerdetailspage); ?>
	<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
<?php } else {
$ecocareerdetailspage = get_option('eco-career-details-page');
}
?>
<div style="width:900px;padding:15px;">
	<div id="delete" class="postbox">
	<h3><span>Important!</span></h3>
		<div class="inside">
			<p>Before you set this option, you will need to create a page and add the "[ecodetails]" shortcode to the page. Once you have done that, please add the page slug below.</p>
		</div>
	</div>
</div><form action="" method="post" class="forms">
<ul>
<li><label>Career Details Page: <?php echo get_option('siteurl');?>/</label>
<input type="text" name="eco-career-details-page" id="eco-career-details-page" value="<?= $ecocareerdetailspage;?>"/>/
</li>
<li><input type="submit" name="submit" value="Save"/></li>
</ul>
</form>
