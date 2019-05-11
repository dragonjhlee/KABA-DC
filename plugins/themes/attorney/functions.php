<?php
/**
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 */


if ( ! function_exists( 'attorney_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function attorney_setup() {
		
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'attorney', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'attorney' ),
		'secondary' => __('Footer Menu', 'attorney')
	) );

	add_theme_support('post-thumbnails'); 
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	
	
	// custom backgrounds
	$attorney_custom_background = array(
		// Background color default
		'default-color' => 'f7f7f7',
		// Background image default
		'default-image' => get_template_directory_uri() . '/library/images/bg.jpg',
		'wp-head-callback' => '_custom_background_cb'
	);
	add_theme_support('custom-background', $attorney_custom_background );

	
	// adding post format support
	add_theme_support( 'post-formats', 
		array( 
			'aside', /* Typically styled without a title. Similar to a Facebook note update */
			'gallery', /* A gallery of images. Post will likely contain a gallery shortcode and will have image attachments */
			'link', /* A link to another site. Themes may wish to use the first <a href=ÓÓ> tag in the post content as the external link for that post. An alternative approach could be if the post consists only of a URL, then that will be the URL and the title (post_title) will be the name attached to the anchor for it */
			'image', /* A single image. The first <img /> tag in the post could be considered the image. Alternatively, if the post consists only of a URL, that will be the image URL and the title of the post (post_title) will be the title attribute for the image */
			'quote', /* A quotation. Probably will contain a blockquote holding the quote content. Alternatively, the quote may be just the content, with the source/author being the title */
			'status', /*A short status update, similar to a Twitter status update */
			'video', /* A single video. The first <video /> tag or object/embed in the post content could be considered the video. Alternatively, if the post consists only of a URL, that will be the video URL. May also contain the video as an attachment to the post, if video support is enabled on the blog (like via a plugin) */
			'audio', /* An audio file. Could be used for Podcasting */
			'chat' /* A chat transcript */
		)
	);

	add_theme_support( "title-tag" );

	// adding site logo
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
	) );
}
endif;
add_action( 'after_setup_theme', 'attorney_setup' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! function_exists( 'attorney_content_width' ) ) :
	function attorney_content_width() {
		global $content_width;
		if (!isset($content_width))
			$content_width = 550; /* pixels */
	}
endif;
add_action( 'after_setup_theme', 'attorney_content_width' );


/*******************************************************************
* These are settings for the Theme Customizer in the admin panel. 
*******************************************************************/
if ( ! function_exists( 'attorney_theme_customizer' ) ) :
	function attorney_theme_customizer( $wp_customize ) {
		
	
		/* color scheme option */
		$wp_customize->add_setting( 'attorney_color_settings', array (
			'default'	=> '#c7930d',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'attorney_color_settings', array(
			'label'    => __( 'Theme Color Scheme', 'attorney' ),
			'section'  => 'colors',
			'settings' => 'attorney_color_settings',
		) ) );
	
		
		/* social media option */
		$wp_customize->add_section( 'attorney_social_section' , array(
			'title'       => __( 'Social Media Icons', 'attorney' ),
			'priority'    => 32,
			'description' => __( 'Optional social media buttons in the header', 'attorney' ),
		) );
		
		$wp_customize->add_setting( 'attorney_facebook', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_facebook', array(
			'label'    => __( 'Enter your Facebook url', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_facebook',
			'priority'    => 101,
		) ) );
	
		$wp_customize->add_setting( 'attorney_twitter', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_twitter', array(
			'label'    => __( 'Enter your Twitter url', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_twitter',
			'priority'    => 102,
		) ) );
		
		$wp_customize->add_setting( 'attorney_google', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_google', array(
			'label'    => __( 'Enter your Google+ url', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_google',
			'priority'    => 103,
		) ) );
		
		$wp_customize->add_setting( 'attorney_pinterest', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_pinterest', array(
			'label'    => __( 'Enter your Pinterest url', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_pinterest',
			'priority'    => 104,
		) ) );
		
		$wp_customize->add_setting( 'attorney_linkedin', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_linkedin', array(
			'label'    => __( 'Enter your Linkedin url', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_linkedin',
			'priority'    => 105,
		) ) );
		
		$wp_customize->add_setting( 'attorney_youtube', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_youtube', array(
			'label'    => __( 'Enter your Youtube url', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_youtube',
			'priority'    => 106,
		) ) );
		
		$wp_customize->add_setting( 'attorney_tumblr', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_tumblr', array(
			'label'    => __( 'Enter your Tumblr url', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_tumblr',
			'priority'    => 107,
		) ) );
		
		$wp_customize->add_setting( 'attorney_instagram', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_instagram', array(
			'label'    => __( 'Enter your Instagram url', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_instagram',
			'priority'    => 108,
		) ) );
		
		$wp_customize->add_setting( 'attorney_flickr', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_flickr', array(
			'label'    => __( 'Enter your Flickr url', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_flickr',
			'priority'    => 109,
		) ) );
		
		$wp_customize->add_setting( 'attorney_vimeo', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_vimeo', array(
			'label'    => __( 'Enter your Vimeo url', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_vimeo',
			'priority'    => 110,
		) ) );
		
		$wp_customize->add_setting( 'attorney_yelp', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_yelp', array(
			'label'    => __( 'Enter your Yelp url', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_yelp',
			'priority'    => 111,
		) ) );
		
		$wp_customize->add_setting( 'attorney_rss', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_rss', array(
			'label'    => __( 'Enter your RSS url', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_rss',
			'priority'    => 112,
		) ) );
		
		$wp_customize->add_setting( 'attorney_email', array (
			'sanitize_callback' => 'sanitize_email',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_email', array(
			'label'    => __( 'Enter your email address', 'attorney' ),
			'section'  => 'attorney_social_section',
			'settings' => 'attorney_email',
			'priority'    => 113,
		) ) );
		
		/* slider options */
		
		$wp_customize->add_section( 'attorney_slider_section' , array(
			'title'       => __( 'Slider Options', 'attorney' ),
			'priority'    => 33,
			'description' => __( 'Adjust the behavior of the image slider.', 'attorney' ),
		) );
		
		$wp_customize->add_setting( 'attorney_slider_effect', array(
			'default' => 'scrollHorz',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		));
		
		 $wp_customize->add_control( 'effect_select_box', array(
			'settings' => 'attorney_slider_effect',
			'label' => __( 'Select Effect:', 'attorney' ),
			'section' => 'attorney_slider_section',
			'type' => 'select',
			'choices' => array(
				'scrollHorz' => 'Horizontal (Default)',
				'scrollVert' => 'Vertical',
				'tileSlide' => 'Tile Slide',
				'tileBlind' => 'Blinds',
			),
		) );
		
		$wp_customize->add_setting( 'attorney_slider_timeout', array (
			'sanitize_callback' => 'attorney_sanitize_integer',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'attorney_slider_timeout', array(
			'label'    => __( 'Autoplay Speed in Seconds', 'attorney' ),
			'section'  => 'attorney_slider_section',
			'settings' => 'attorney_slider_timeout',
		) ) );

	}
endif;
add_action('customize_register', 'attorney_theme_customizer');


/**
 * Sanitize integer input
 */
if ( ! function_exists( 'attorney_sanitize_integer' ) ) :
	function attorney_sanitize_integer( $input ) {
		return absint($input);
	}
endif;


/**
* Apply Color Scheme
*/
if ( ! function_exists( 'attorney_apply_color' ) ) :
	function attorney_apply_color() {
		if ( get_theme_mod('attorney_color_settings') ) {
	?>
		<style>
			a, a:visited,
			nav[role=navigation] .menu ul li a:hover,
			.slide-content .slide-title,
			.slide-content .slide-title a,
			.entry-title a:hover,
			.commentlist .vcard cite.fn a,
			.commentlist .comment-meta a:hover,
			.post_content ul li:before,
			.post_content ol li:before,
			.colortxt,
			.cycle-pager span.cycle-pager-active,
			.att-meta-link abbr[title] { 
				color: <?php echo get_theme_mod('attorney_color_settings'); ?>;
			}
			
			#search-box-wrap,
			#social-media a,
			header[role=banner] #searchform input[type=submit],
			.go-button a,
			.go-button a:visited,
			.grnbar,
			.pagination a:hover,
			.pagination span.current,
			#respond #submit,
			a.more-link:after,
			.nav-next a:after,
			.next-image a:after,
			.nav-previous a:after,
			.previous-image a:after,
			.commentlist .comment-reply-link:after,
			.commentlist .comment-reply-login:after {
				background-color: <?php echo get_theme_mod('attorney_color_settings'); ?>;
			}
			
			nav[role=navigation],
			#sidebar .widget-title,
			#sidebar-home .widget-title,
			#sidebar-full .widget-title,
			#reply-title {
				border-top: 5px solid <?php echo get_theme_mod('attorney_color_settings'); ?>;
			}
			
			
			.gallery img:hover {
				border: 1px solid <?php echo get_theme_mod('attorney_color_settings'); ?>;
			}

		</style>
	<?php
		}
	}
endif;
add_action( 'wp_head', 'attorney_apply_color' );



/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
if ( ! function_exists( 'attorney_main_nav' ) ) :
function attorney_main_nav() {
	// display the wp3 menu if available
    wp_nav_menu( 
    	array( 
    		'menu' => '', /* menu name */
    		'theme_location' => 'primary', /* where in the theme it's assigned */
    		'container_class' => 'menu', /* container class */
    		'fallback_cb' => 'attorney_main_nav_fallback' /* menu fallback */
    	)
    );
}
endif;

if ( ! function_exists( 'attorney_footer_nav' ) ) :
function attorney_footer_nav() {
	// display the wp3 menu if available
    wp_nav_menu( 
    	array( 
    		'theme_location' => 'secondary', /* where in the theme it's assigned */
    		'container_class' => 'footer-menu', /* container class */
    		'fallback_cb' => false,
    	)
    );
}
endif;

if ( ! function_exists( 'attorney_main_nav_fallback' ) ) :
	function attorney_main_nav_fallback() { wp_page_menu( 'show_home=Home&menu_class=menu' ); }
endif;

if ( ! function_exists( 'attorney_enqueue_comment_reply' ) ) :
	function attorney_enqueue_comment_reply() {
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
					wp_enqueue_script( 'comment-reply' );
			}
	 }
endif;
add_action( 'comment_form_before', 'attorney_enqueue_comment_reply' );

if ( ! function_exists( 'attorney_page_menu_args' ) ) :
	function attorney_page_menu_args( $args ) {
		$args['show_home'] = true;
		return $args;
	}
endif;
add_filter( 'wp_page_menu_args', 'attorney_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
if ( ! function_exists( 'attorney_widgets_init' ) ) :
	function attorney_widgets_init() {
		register_sidebar( array(
			'name' => __( 'Sidebar Right', 'attorney' ),
			'id' => 'sidebar-right',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<div class="widget-title">',
			'after_title' => '</div>',
		) );
		
		register_sidebar( array(
			'name' => __( 'Sidebar for Alt_Homepage', 'attorney' ),
			'id' => 'sidebar-alt',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<div class="widget-title">',
			'after_title' => '</div>',
		) );
		
		register_sidebar( array(
			'name' => __( 'Sidebar for Full Width Template', 'attorney' ),
			'id' => 'sidebar-full',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<div class="widget-title">',
			'after_title' => '</div>',
		) );
		
		register_sidebar( array(
			'name' => __( 'Sidebar for Posts', 'attorney' ),
			'id' => 'sidebar-post',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<div class="widget-title">',
			'after_title' => '</div>',
		) );
	
	}
endif;
add_action( 'widgets_init', 'attorney_widgets_init' );

if ( ! function_exists( 'attorney_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 */
function attorney_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'attorney' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( 'Previous', 'Previous post link', 'attorney' ) . '</span>' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '<span class="meta-nav">' . _x( 'Next', 'Next post link', 'attorney' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'attorney' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'attorney' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif;


if ( ! function_exists( 'attorney_comment' ) ) :
/**
 * Template for comments and pingbacks.
 */
function attorney_comment( $comment, $args, $depth ) {

	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'attorney' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'attorney' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>">
			<footer class="clearfix comment-head">
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 60 ); ?>
					<?php printf( '%s', sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'attorney' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'attorney' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'attorney' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
                
                <div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div><!-- .reply -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif;

if ( ! function_exists( 'attorney_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function attorney_posted_on() {
	printf( __( '<div class="att-meta">Date <a href="%1$s" title="%2$s" rel="bookmark" class="att-meta-link"><time class="entry-date" datetime="%3$s">%4$s</time></a></div><div class="att-meta">Posted by <a class="url fn n att-meta-link" href="%5$s" title="%6$s" rel="author">%7$s</a></div>', 'attorney' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'attorney' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Adds custom classes to the array of body classes.
 */
if ( ! function_exists( 'attorney_body_classes' ) ) :
	function attorney_body_classes( $classes ) {
		// Adds a class of single-author to blogs with only 1 published author
		if ( ! is_multi_author() ) {
			$classes[] = 'single-author';
		}
	
		return $classes;
	}
endif;
add_filter( 'body_class', 'attorney_body_classes' );

/**
 * Returns true if a blog has more than 1 category
 */
if ( ! function_exists( 'attorney_categorized_blog' ) ) :
function attorney_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so attorney_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so attorney_categorized_blog should return false
		return false;
	}
}
endif;
/**
 * Flush out the transients used in attorney_categorized_blog
 */
if ( ! function_exists( 'attorney_category_transient_flusher' ) ) :
	function attorney_category_transient_flusher() {
		// Like, beat it. Dig?
		delete_transient( 'all_the_cool_cats' );
	}
endif;
add_action( 'edit_category', 'attorney_category_transient_flusher' );
add_action( 'save_post', 'attorney_category_transient_flusher' );

/**
 * Remove WP default gallery styling
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
if ( ! function_exists( 'attorney_enhanced_image_navigation' ) ) :
	function attorney_enhanced_image_navigation( $url ) {
		global $post, $wp_rewrite;
	
		$id = (int) $post->ID;
		$object = get_post( $id );
		if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
			$url = $url . '#main';
	
		return $url;
	}
endif;
add_filter( 'attachment_link', 'attorney_enhanced_image_navigation' );


if ( ! function_exists( 'attorney_excerpt' ) ) :
	function attorney_excerpt($limit) {
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
		} else {
		$excerpt = implode(" ",$excerpt);
		}	
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
		return $excerpt;
	}
endif;

if ( ! function_exists( 'attorney_content' ) ) :
	function attorney_content($limit) {
		$content = explode(' ', get_the_content(), $limit);
		if (count($content)>=$limit) {
		array_pop($content);
		$content = implode(" ",$content).'...';
		} else {
		$content = implode(" ",$content);
		}	
		$content = preg_replace('/\[.+\]/','', $content);
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		  return $content;
	}
endif;

function attorney_post_title($title) {
	if ($title == '') {
		return __('Untitled', 'attorney');
	} else {
		return $title;
	}
}
add_filter('the_title', 'attorney_post_title');

if ( ! function_exists( 'attorney_w3c_valid_rel' ) ) :
	function attorney_w3c_valid_rel( $text ) {
		$text = str_replace('rel="category tag"', 'rel="tag"', $text); return $text; 
	}
endif;
add_filter( 'the_category', 'attorney_w3c_valid_rel' );

if ( ! function_exists( 'attorney_modernizr_addclass' ) ) :
	function attorney_modernizr_addclass($output) {
		return $output . ' class="no-js"';
	}
endif;
add_filter('language_attributes', 'attorney_modernizr_addclass');

if ( ! function_exists( 'attorney_modernizr_script' ) ) :
	function attorney_modernizr_script() {
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/library/js/modernizr-2.6.2.min.js', false, '2.6.2');
	}  
endif;  
add_action('wp_enqueue_scripts', 'attorney_modernizr_script');

if ( ! function_exists( 'attorney_custom_scripts' ) ) :
	function attorney_custom_scripts() {
		wp_enqueue_script( 'attorney_cycle_js', get_template_directory_uri() . '/library/js/jquery.cycle2.min.js', array( 'jquery' ), '20130202' );
		wp_enqueue_script( 'attorney_cycle_tile_js', get_template_directory_uri() . '/library/js/jquery.cycle2.tile.min.js', array( 'jquery' ), '20121120' );
		wp_enqueue_script( 'attorney_cycle_scrollvert_js', get_template_directory_uri() . '/library/js/jquery.cycle2.scrollVert.min.js', array( 'jquery' ), '20121120' );
		wp_enqueue_script( 'attorney_custom_js', get_template_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '1.0.0' );
		wp_enqueue_style( 'attorney_style', get_stylesheet_uri() );
	}
endif;
add_action('wp_enqueue_scripts', 'attorney_custom_scripts');

?>