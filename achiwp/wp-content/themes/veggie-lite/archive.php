<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Veggie
 */

get_header(); ?>

	<div class="two-third">
		<div id="primary" class="content-area sidebar-right-layout">
			<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );

					if ( is_author() && '' !== get_the_author_meta( 'description' ) ) {
						echo '<div class="taxonomy-description">' . get_the_author_meta( 'description' ) . '</div><!-- .taxonomy-description -->';
					} else {
						the_archive_description( '<div class="taxonomy-description">', '</div><!-- .taxonomy-description -->' );
					}
				?>
			</header><!-- .page-header -->

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						 get_template_part( 'template-parts/content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php the_posts_navigation(); ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .two_third -->
	<div class="one-third lastcolumn">
		<?php get_sidebar(); ?>
	</div><!-- .one_third -->

<?php get_footer(); ?>