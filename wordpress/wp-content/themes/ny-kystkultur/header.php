<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ny_Kystkultur
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

  <script type="module">
    import { Application, Controller } from "https://unpkg.com/@hotwired/stimulus/dist/stimulus.js"
    window.Stimulus = Application.start()

    Stimulus.register("toggle", class extends Controller {
      static targets = ["button", "content"]
      static values = { controlsId: String }

      connect() {
        this.controlsId = this.controlsIdValue || this._generateId()
        this.contentTarget.setAttribute("id", this.controlsId)
        this.buttonTarget.setAttribute("aria-controls", this.controlsId)
        this.buttonTarget.setAttribute("aria-expanded", "false")
      }

      toggle() {
        this.buttonTarget.classList.toggle("toggled")
        this.contentTarget.classList.toggle("toggled")
        this.buttonTarget.setAttribute("aria-expanded", this.buttonTarget.classList.contains("toggled"))
      }

      _generateId() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
        let result = chars.charAt(Math.floor(Math.random() * 52)) // Start with a letter
        for (let i = 1; i < 16; i++) {
          result += chars.charAt(Math.floor(Math.random() * chars.length))
        }
        return document.getElementById(result) ? generateUniqueId() : result
      }
    })
  </script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'ny-kystkultur' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title offscreen"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title offscreen"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$ny_kystkultur_description = get_bloginfo( 'description', 'display' );
			if ( $ny_kystkultur_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $ny_kystkultur_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
        <span class="menu-toggle__open">
          <svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <line x1="1" y1="4" x2="19" y2="4" stroke="black" stroke-width="2"/>
          <line x1="1" y1="10" x2="19" y2="10" stroke="black" stroke-width="2"/>
          <line x1="1" y1="16" x2="19" y2="16" stroke="black" stroke-width="2"/>
        </svg>
        </span>
        <span class="menu-toggle__close">
          <svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <line x1="2" y1="2" x2="18" y2="18" stroke="black" stroke-width="2"/>
            <line x1="18" y1="2" x2="2" y2="18" stroke="black" stroke-width="2"/>
          </svg>
        </span>
      </button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
          'walker'         => new Custom_Walker_Nav_Menu(),
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
