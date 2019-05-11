<?php 
/**
 * Template Name: Alt_HomePage, with Posts Slider
 * Description: An alternative homepage that displays the latest posts in the slider
 */
get_header(); ?>

    <div id="content" class="clearfix full-width-content">
        
        <div id="main" class="clearfix sldr" role="main">

			<div id="slide-wrap">
			  <?php 
                $args = array(
                    'posts_per_page' => 10,
					'post_status' => 'publish',
                );
                $fPosts = new WP_Query( $args );
				$countPosts = $fPosts->found_posts;
              ?>
    
                <?php if ( $fPosts->have_posts() ) : ?>
                  
                  <?php if ($countPosts > 1) : ?>
                  <div id="load-cycle"></div>
                  <div class="cycle-slideshow" <?php 
				  	if ( get_theme_mod('attorney_slider_effect') ) {
						echo 'data-cycle-fx="' . wp_kses_post( get_theme_mod('attorney_slider_effect') ) . '" data-cycle-tile-count="10"';
					} else {
						echo 'data-cycle-fx="scrollHorz"';
					}
				  ?> data-cycle-slides="> div.slides" <?php
                  	if ( get_theme_mod('attorney_slider_timeout') ) {
						$slider_timeout = wp_kses_post( get_theme_mod('attorney_slider_timeout') );
						echo 'data-cycle-timeout="' . $slider_timeout . '000"';
					} else {
						echo 'data-cycle-timeout="2500"';
					}
				  ?> data-cycle-pause-on-hover="true">
                  	
                    <?php /* Start the Loop */ ?>
                    <?php while ( $fPosts->have_posts() ) : $fPosts->the_post();  ?>

                    <div class="slides">
                      <div id="post-<?php the_ID(); ?>" <?php post_class('post-theme'); ?>>
                         <?php if ( has_post_thumbnail()) : ?>
                            <div class="slide-thumb" style="background-image:url(<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array(1000, 640), false, '' ); echo $src[0]; ?>)"></div>
                         <?php else : ?>
                         
                            <?php $postimgs =& get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
                            if ( !empty($postimgs) ) :
                                $firstimg = array_shift( $postimgs );
                                $my_image = wp_get_attachment_url( $firstimg->ID, array( 1000, 640 ), false, '' );
                            ?>
                            <div class="slide-thumb" style="background-image:url(<?php echo $my_image; ?>)"></div>
                            
                            <?php else : ?>
                            
                            <div class="slide-noimg"><?php _e('No featured image set for this post.', 'attorney') ?></div>
                            
                           <?php endif; ?>
                           
                         <?php endif; ?>
                         <div class="slide-content">
                            <div class="slide-copy">
                            <h2 class="slide-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'attorney' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                            <?php echo attorney_excerpt(25); ?>
                            </div>
                         </div>						
                      </div>
                    </div>
                    
                    <?php endwhile; ?>

                    <?php wp_reset_query(); // reset the query ?>

                  </div>
                  
                  <div class="slidernav">
                        <a id="sliderprev" href="#" title="<?php _e('Previous', 'attorney'); ?>"><?php _e('&#9664;', 'attorney'); ?></a>
                        <a id="slidernext" href="#" title="<?php _e('Next', 'attorney'); ?>"><?php _e('&#9654;', 'attorney'); ?></a>
                    </div>
                    
                    <div class="clearfix"></div>
                  
                  <?php else : ?>
                  
                  <?php /* Start the Loop */ ?>
                   <?php while ( $fPosts->have_posts() ) : $fPosts->the_post(); ?>
                  	<div class="slides">
                      <div id="post-<?php the_ID(); ?>" <?php post_class('post-theme'); ?>>
                         <?php if ( has_post_thumbnail()) : ?>
                            <div class="slide-thumb" style="background-image:url(<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array(1000, 640), false, '' ); echo $src[0]; ?>)"></div>
                         <?php else : ?>
                            <div class="slide-noimg"><?php _e('No featured image set for this post.', 'attorney') ?></div>
                         <?php endif; ?>
                         <div class="slide-content">
                         	<div class="slide-copy">
                            <h2 class="slide-title"><?php the_title(); ?></h2>
                         	<?php echo attorney_excerpt(25); ?>
                            </div>
                         </div>						
                      </div>
                    </div>
                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); // reset the query ?>
                  
                  <?php endif; ?>
                  
                <?php endif; ?>
                    
              </div>

        </div> <!-- end #main -->

        <?php get_sidebar('home'); ?>

    </div> <!-- end #content -->
        
<?php get_footer(); ?>