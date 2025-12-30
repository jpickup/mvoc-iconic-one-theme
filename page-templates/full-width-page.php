<?php
/**
 * Template Name: Full-width-page
*/
get_header(); ?>

	<div id="primary" class="site-content mvoc-full-width-post">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<!-- No side-bar on full-width --?php get_sidebar(); ?-->
<?php get_footer(); ?>