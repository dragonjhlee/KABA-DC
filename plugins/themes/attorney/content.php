
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'attorney' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php attorney_posted_on(); ?>
            <?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
            <div class="att-meta-com"><?php _e('Comments', 'attorney'); ?><span class="comments-link att-meta-link"><?php comments_popup_link( '0', '1', '%' ); ?></span></div>
            <?php endif; ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
    
   
	<?php if ( has_post_thumbnail()) : ?>
    
    <div class="imgthumb" style="background-image:url(<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array(640, 480), false, '' ); echo $src[0]; ?>)"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>

    <?php endif; ?>
    
		
    
    
	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
    	
		<?php if ( has_post_format( 'gallery' ) ) : ?>
			<?php
                $images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
                if ( $images ) :
                    $total_images = count( $images );
                    $image = array_shift( $images );
                    $image_img_tag = wp_get_attachment_url( $image->ID, array(640, 480), false );
            ?>
            <div class="imgthumb" style="background-image:url(<?php echo $image_img_tag; ?>)">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </div><!-- .gallery-thumb -->
            <?php endif; ?>
            
            
        <?php endif; ?>
        
	<div class="entry-summary post_content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
    
	<?php else : ?>
	<div class="entry-content post_content">
		<?php the_content( __( 'Continue reading', 'attorney' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'attorney' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	
</article><!-- #post-<?php the_ID(); ?> -->
