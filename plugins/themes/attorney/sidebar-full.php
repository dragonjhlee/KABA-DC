<?php
/**
 * The Sidebar containing the main widget areas for the homepage.
 */
?>
		<div id="sidebar-full" class="widget-area clearfix" role="complementary">

			<?php if ( ! dynamic_sidebar( 'sidebar-full' ) ) : ?>

				<aside id="recent-posts" class="widget">
					<div class="widget-title"><?php _e( 'Latest Posts', 'attorney' ); ?></div>
					<ul>
						<?php
							$args = array( 'numberposts' => '10' );
							$recent_posts = wp_get_recent_posts( $args );
							
							foreach( $recent_posts as $recent ){
								if ($recent["post_title"] == '') {
									 $recent["post_title"] = __('View Post', 'attorney');
								}
								echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' . $recent["post_title"] .'</a> </li> ';
							}
						?>
                    </ul>
				</aside>
                
                <aside id="categories" class="widget">
					<div class="widget-title"><?php _e( 'Categories', 'attorney' ); ?></div>
					<ul>
						<?php wp_list_categories( array( 
							'title_li' => '',
							'hierarchical' => 0
						) ); ?>
					</ul>
				</aside>
                
                <aside id="archives" class="widget">
					<div class="widget-title"><?php _e( 'Archives', 'attorney' ); ?></div>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</aside>
  
            <?php endif; // end sidebar widget area ?>

		</div><!-- #sidebar .widget-area -->
