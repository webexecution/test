<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package eighteen-tags
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">

				<div class="page-content">

					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'eighteen-tags' ); ?></h1>
					</header><!-- .page-header -->

					<p><?php esc_html_e( 'Nothing was found at this location. Try searching, or check out the links below.', 'eighteen-tags' ); ?></p>

					<?php
					if ( is_woocommerce_activated() ) {
						the_widget( 'WC_Widget_Product_Search' );
					} else {
						get_search_form();
					}
					?>

					<?php
					if ( is_woocommerce_activated() ) {

						echo '<div class="fourohfour-columns-2">';

							echo '<div class="col-1">';

								eighteen_tags_promoted_products();

							echo '</div>';

							echo '<div class="col-2">';

								echo '<h2>' . esc_html__( 'Product Categories', 'eighteen-tags' ) . '</h2>';

								the_widget( 'WC_Widget_Product_Categories', array(
															'count'		=> 1,
														) );
							echo '</div>';

						echo '</div>';

						echo '<h2>' . esc_html__( 'Popular Products', 'eighteen-tags' ) . '</h2>';

						echo eighteen_tags_do_shortcode( 'best_selling_products', array(
															'per_page' 	=> 4,
															'columns'	=> 4,
														) );
					}
					?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
