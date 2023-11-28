<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Ny_Kystkultur
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php ny_kystkultur_post_thumbnail(); ?>

  <?php ny_kystkultur_breadcrumbs(); ?>

	<header class="entry-header content-width-m">
		<?php the_title( '<h1 class="entry-title type-xl text-center">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content content-width-m">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ny-kystkultur' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
