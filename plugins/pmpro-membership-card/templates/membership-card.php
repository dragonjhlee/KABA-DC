PMP Pro Set Expiration Date

<?php 
	global $wpdb, $pmpro_membership_card_user, $pmpro_currency_symbol, $post;
?>
<style>
	/* Hide any thumbnail that might be on the page. */
	.page .attachment-post-thumbnail, .page .wp-post-image {display: none;}
	.post .attachment-post-thumbnail, .post .wp-post-image {display: none;}
	
	/* Page Styles */
	.pmpro_membership_card {clear: both; }
	.pmpro_membership_card-print {border: 1px solid #000000; border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px; background: #FFF; margin: 0 0 10px 0; }
	.pmpro_membership_card-inner {padding: 2%; }
	.pmpro_membership_card-print h1 {font-size: 16px; margin: 0 0 20px 0; }
	.pmpro_membership_card-print p {margin: 1px 0 0 0; padding: 0; font-size: 11px; }
	img.pmpro_membership_card_image {float: right; border: none; box-shadow: none; }
	.pmpro_membership_card-print-md .pmpro_membership_card_image {max-width: 120px; }
	.pmpro_membership_card-print-md img.pmpro_membership_card_image {margin-bottom: 10%; }
	.pmpro_membership_card-print-sm, .pmpro_membership_card-print-lg {visibility: hidden !important; }
	.pmpro_clear {clear: both; }
	/* Print Styles */
	@media print
	{	
		.page, .page .pmpro_membership_card #nav-below {visibility: hidden !important; }
		.page .pmpro_membership_card { visibility: visible !important; position: fixed; top: 10%; left: 2%; width: 96%; }
		.pmpro_membership_card-print-md {width: 50%; float: left; margin-bottom: 40%; }
		.pmpro_membership_card-print-md .pmpro_membership_card-inner {padding: 5% 2%; }
		.pmpro_membership_card-print-md img.pmpro_membership_card_image {max-width: 100px; }
		.pmpro_membership_card-print-sm {visibility: visible !important; float: right; width: 40%; }
		.pmpro_membership_card-print-sm img.pmpro_membership_card_image {max-width: 60px; margin-bottom: 10%; }
		.pmpro_membership_card-print-lg {clear: both; visibility: visible !important; width: 100%; line-height: 26px; }
		.pmpro_membership_card-print-lg .pmpro_membership_card-inner {padding: 10% 5%; }
		.pmpro_membership_card-print-lg img.pmpro_membership_card_image {max-width: 120px; }
		.pmpro_membership_card-print-lg h1 {font-size: 40px; margin: 0 0 40px 0; }
		.pmpro_membership_card-print-lg p {font-size: 16px; margin: 4px 0 0 0; }
	}
</style>
<a class="pmpro_a-print" href="javascript:window.print()">Print</a>
<div class="pmpro_membership_card">
	<?php 
		$featured_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
		if(function_exists("pmpro_getMemberStartDate"))
			$since = pmpro_getMemberStartDate($pmpro_membership_card_user->ID);
		else
			$since = $pmpro_membership_card_user->user_registered;
	?>
	<div class="pmpro_membership_card-print pmpro_membership_card-print-md">	<div class="pmpro_membership_card-inner">
		<h1>
			<?php 
				if($pmpro_membership_card_user->user_firstname)
					echo $pmpro_membership_card_user->user_firstname, " ", $pmpro_membership_card_user->user_lastname;
				else
					echo $pmpro_membership_card_user->display_name;
			?>
		</h1>		
		<?php
			if(!empty($featured_image))
			{
			?>
			<img id="pmpro_membership_card_image" class="pmpro_membership_card_image" src="<?php echo esc_attr($featured_image);?>" border="0" />
			<?php
			}
		?>	
		<?php
			if(!empty($since))
			{
			?>
			<p><strong>Member Since:</strong> <?php echo date(get_option("date_format"), strtotime($pmpro_membership_card_user->user_registered));?></p>
			<?php
			}
		?>
			
		<?php if(function_exists("pmpro_hasMembershipLevel")) { ?>
		<p><strong><?php _e("Level", "pmpro");?>:</strong> <?php echo $pmpro_membership_card_user->membership_level->name?></p>		
		<p><strong><?php _e("Membership Expires", "pmpro");?>:</strong> 
			<?php 
				if($pmpro_membership_card_user->membership_level->enddate)
					echo "December 31";
				else
					echo "Never";
			?>
		</p>
		<?php } ?>				
	</div><div class="pmpro_clear"></div></div> <!-- end pmpro_membership_card-print-md -->

	<div class="pmpro_membership_card-print pmpro_membership_card-print-sm">	<div class="pmpro_membership_card-inner">
		<h1>
			<?php 
				if($pmpro_membership_card_user->user_firstname)
					echo $pmpro_membership_card_user->user_firstname, " ", $pmpro_membership_card_user->user_lastname;
				else
					echo $pmpro_membership_card_user->display_name;
			?>
		</h1>		
		<?php
			if(!empty($featured_image))
			{
			?>
			<img id="pmpro_membership_card_image" class="pmpro_membership_card_image" src="<?php echo esc_attr($featured_image);?>" border="0" />
			<?php
			}
		?>	
		<?php
			if(!empty($since))
			{
			?>
			<p><strong>Member Since:</strong> <?php echo date(get_option("date_format"), strtotime($pmpro_membership_card_user->user_registered));?></p>
			<?php
			}
		?>
			
		<?php if(function_exists("pmpro_hasMembershipLevel")) { ?>
		<p><strong><?php _e("Level", "pmpro");?>:</strong> <?php echo $pmpro_membership_card_user->membership_level->name?></p>		
		<p><strong><?php _e("Membership Expires", "pmpro");?>:</strong> 
			<?php 
				if($pmpro_membership_card_user->membership_level->enddate)
					echo "December 31";
				else
					echo "Never";
			?>
		</p>
		<?php } ?>				
	</div><div class="pmpro_clear"></div></div> <!-- end pmpro_membership_card-print-sm -->

		
	<nav id="nav-below" class="navigation" role="navigation">


		<div class="nav-previous alignleft">
			<?php if(function_exists("pmpro_hasMembershipLevel") && pmpro_hasMembershipLevel(NULL, $pmpro_membership_card_user->ID)) { ?>
				<a href="<?php echo pmpro_url("account")?>"><?php _e('&larr; Return to Your Account', 'pmpro');?></a>
			<?php } else { ?>
				<a href="<?php echo home_url()?>"><?php _e('&larr; Return to Home', 'pmpro');?></a>
			<?php } ?>
		</div>
	</nav>
</div> <!-- end #pmpro_membership_card -->
	