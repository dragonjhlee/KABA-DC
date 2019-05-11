
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
      <?php if ( is_single() ) : ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'attorney' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
      <?php else : ?>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'attorney' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
      <?php endif; ?>

		<div class="entry-meta">
			<?php attorney_posted_on(); ?>
            <?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
            <div class="att-meta-com"><?php _e('Comments', 'attorney'); ?><span class="comments-link att-meta-link"><?php comments_popup_link( '0', '1', '%' ); ?></span></div>
            <?php endif; ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
    
    <?php if( has_shortcode( $post->post_content, 'gallery' ) ) : ?>
		<?php 
                $gallery = get_post_gallery( $post, false );
                $ids = explode( ",", $gallery['ids'] );
                $total_images = 0;
                foreach( $ids as $id ) {
                    $title = get_post_field('post_title', $id);
                    $meta = get_post_field('post_excerpt', $id);
                    $link = wp_get_attachment_url( $id );
                    $image  = wp_get_attachment_image( $id, array(640, 480) );
                    $total_images++;
                    
					if ($total_images == 1) {
						$first_img = $link;
					}
                }    
        ?>


	<div class="imgthumb" style="background-image:url(<?php echo $first_img; ?>)">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</div><!-- .gallery-thumb -->

    

	<?php if ( is_search() ) : // Only display Excerpts for search pages ?>
	<div class="entry-summary post_content">
    	<?php if ( has_post_thumbnail()) : ?>                
          <div class="imgthumb"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( array(640, 480) ); ?></a></div>               
        <?php endif; ?>
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content post_content">
		<?php if ( post_password_required() ) : ?>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'attorney' ) ); ?>
			<?php else : ?>
			<p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'attorney' ),
			'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'attorney' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
			number_format_i18n( $total_images )
		); ?></em></p>
			<?php the_excerpt(); ?>
		<?php endif; ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'attorney' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
