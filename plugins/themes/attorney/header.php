<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="container">

	<header id="branding" role="banner">
      <div id="inner-header" class="clearfix">
		        
        <div id="site-heading">

            <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ): 
            $attorney_custom_logo_id = get_theme_mod( 'custom_logo' );
            $image = wp_get_attachment_image_src( $attorney_custom_logo_id,'full');
            ?>
            <div id="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a></div>
            <?php else : ?>
            <div id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
            <div id="site-description"><?php bloginfo( 'description' ); ?></div>
            <?php endif; ?>
            
		</div>
        
        <div id="social-media" class="clearfix">
        
        	<?php if ( get_theme_mod( 'attorney_facebook' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'attorney_facebook' ) ); ?>" class="social-fb" title="<?php echo esc_url( get_theme_mod( 'attorney_facebook' ) ); ?>"><?php _e('Facebook', 'attorney') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'attorney_twitter' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'attorney_twitter' ) ); ?>" class="social-tw" title="<?php echo esc_url( get_theme_mod( 'attorney_twitter' ) ); ?>"><?php _e('Twitter', 'attorney') ?></a>
            <?php endif; ?>
			
            <?php if ( get_theme_mod( 'attorney_google' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'attorney_google' ) ); ?>" class="social-gp" title="<?php echo esc_url( get_theme_mod( 'attorney_google' ) ); ?>"><?php _e('Google+', 'attorney') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'attorney_pinterest' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'attorney_pinterest' ) ); ?>" class="social-pi" title="<?php echo esc_url( get_theme_mod( 'attorney_pinterest' ) ); ?>"><?php _e('Pinterest', 'attorney') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'attorney_linkedin' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'attorney_linkedin' ) ); ?>" class="social-li" title="<?php echo esc_url( get_theme_mod( 'attorney_linkedin' ) ); ?>"><?php _e('Linkedin', 'attorney') ?></a>
            <?php endif; ?>
            
			<?php if ( get_theme_mod( 'attorney_youtube' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'attorney_youtube' ) ); ?>" class="social-yt" title="<?php echo esc_url( get_theme_mod( 'attorney_youtube' ) ); ?>"><?php _e('Youtube', 'attorney') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'attorney_tumblr' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'attorney_tumblr' ) ); ?>" class="social-tu" title="<?php echo esc_url( get_theme_mod( 'attorney_tumblr' ) ); ?>"><?php _e('Tumblr', 'attorney') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'attorney_instagram' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'attorney_instagram' ) ); ?>" class="social-in" title="<?php echo esc_url( get_theme_mod( 'attorney_instagram' ) ); ?>"><?php _e('Instagram', 'attorney') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'attorney_flickr' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'attorney_flickr' ) ); ?>" class="social-fl" title="<?php echo esc_url( get_theme_mod( 'attorney_flickr' ) ); ?>"><?php _e('Instagram', 'attorney') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'attorney_vimeo' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'attorney_vimeo' ) ); ?>" class="social-vi" title="<?php echo esc_url( get_theme_mod( 'attorney_vimeo' ) ); ?>"><?php _e('Vimeo', 'attorney') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'attorney_yelp' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'attorney_yelp' ) ); ?>" class="social-ye" title="<?php echo esc_url( get_theme_mod( 'attorney_yelp' ) ); ?>"><?php _e('Yelp', 'attorney') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'attorney_rss' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'attorney_rss' ) ); ?>" class="social-rs" title="<?php echo esc_url( get_theme_mod( 'attorney_rss' ) ); ?>"><?php _e('RSS', 'attorney') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'attorney_email' ) ) : ?>
            <a href="<?php _e('mailto:', 'attorney'); echo sanitize_email( get_theme_mod( 'attorney_email' ) ); ?>" class="social-em" title="<?php _e('mailto:', 'attorney'); echo sanitize_email( get_theme_mod( 'attorney_email' ) ); ?>"><?php _e('Email', 'attorney') ?></a>
            <?php endif; ?>
            
            
        </div>

		

      </div>
      	
      <nav id="access" role="navigation">
        <h1 class="assistive-text section-heading"><?php _e( 'Main menu', 'attorney' ); ?></h1>
        <div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'attorney' ); ?>"><?php _e( 'Skip to content', 'attorney' ); ?></a></div>
        <?php attorney_main_nav(); // Adjust using Menus in Wordpress Admin ?>
        <?php get_search_form(); ?>
      </nav><!-- #access -->
 
	</header><!-- #branding -->
