<?php
/**
 * The template for displaying Comments.
 */
?>
	<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'attorney' ); ?></p>
	</div><!-- #comments -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<div id="comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( '1' === $comments_number ) {
					printf( _x( 'One comment to &ldquo;%s&rdquo;', 'comments title', 'attorney' ), get_the_title() );
				} else {
					printf(
						_nx(
							'%1$s comment to &ldquo;%2$s&rdquo;',
							'%1$s comments to &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'attorney'
						),
						number_format_i18n( $comments_number ),
						get_the_title()
					);
				}
				?>
		</div>


		<ol class="commentlist">
			<?php
				/* Loop through and list the comments.
				 */
				wp_list_comments( array( 'callback' => 'attorney_comment' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'attorney' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'attorney' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'attorney' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are no comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'attorney' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->
