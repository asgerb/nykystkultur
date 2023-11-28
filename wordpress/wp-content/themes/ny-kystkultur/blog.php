<?php
/**
 * The template for displaying news
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * Template Name: Nyheder og Events
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Ny_Kystkultur
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

		endwhile; // End of the loop.
		?>

    <?php
      $args = array(
          'post_type' => 'post'
      );

      $post_query = new WP_Query($args);

      if ( $post_query->have_posts() ) {
        echo '<div class="blog content-width-m">';
        while ( $post_query->have_posts() ) {
          $post_query->the_post();
          ?>
          <article class="blog__post">
            <div class="blog__post_text">
              <header>
                <h2 class="blog__post_title type-l"><?php the_title(); ?></h2>
                <time class="blog__post_date" datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time>
              </header>
              <div class="blog__post_content"><?php the_content(); ?></div>
            </div>
            <div class="blog__post_thumbnail">
              <?php the_post_thumbnail(); ?>
            </div>
          </article>
          <?php
        }
        echo '</div>';
      }
    ?>

	</main><!-- #main -->

<?php
get_footer();
