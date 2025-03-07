<?php
/**
 * Template Name: Full-width
 * Template Post Type: post
*/

get_header(); ?>
	<div id="primary" class="site-content mvoc-full-width-post">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>
				<nav class="nav-single">
					<div class="assistive-text"><?php _e( 'Post navigation', 'iconic-one' ); ?></div>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'iconic-one' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'iconic-one' ) . '</span>' ); ?></span>
				</nav><!-- .nav-single -->

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<!--?php get_sidebar(); ?-->
<?php get_footer(); ?>