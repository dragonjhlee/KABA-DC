
	
</div><!-- #container -->

<footer id="colophon" role="contentinfo">
		<div id="site-generator">

			<?php echo __('&copy; ', 'attorney') . esc_attr( get_bloginfo( 'name', 'display' ) );  ?>
            <?php if ( is_front_page() && ! is_paged() ) : ?>
            <?php _e('- Built with ', 'attorney'); ?><a href="<?php echo esc_url( __( 'https://wpdevshed.com/attorney-theme/', 'attorney' ) ); ?>" target="_blank"><?php _e('Attorney', 'attorney'); ?></a>
            <?php _e(' and ', 'attorney'); ?><a href="<?php echo esc_url( __( 'http://wordpress.org/', 'attorney' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'attorney' ); ?>" target="_blank"><?php _e('WordPress' ,'attorney'); ?></a>
            <?php endif; ?>
            <?php attorney_footer_nav(); ?>
            
		</div>
	</footer><!-- #colophon -->

<?php wp_footer(); ?>


</body>
</html>