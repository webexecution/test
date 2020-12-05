<?php
/**
 * The template for displaying woocommerce pages
 *
 * @since 1.0

 */

get_header(); 

$smart_shopper_content = 'col-sm-8 col-md-8 col-lg-9';
$smart_shopper_sidebar = '';
if ( ! is_active_sidebar( 'sidebar-woocommerce' ) ) {
	$smart_shopper_content = 'col-sm-12 col-md-12 col-lg-12';
	$smart_shopper_sidebar = 'hide-content';	
}	
?>

<div class="container background">
   <div class="row">
   
   			<div class="col-md-4 col-sm-4 col-lg-3 col-xs-12 floateleft  <?php echo $smart_shopper_sidebar; ?>" > 
				<?php get_template_part('sidebar','woocommerce'); ?>			
			</div>
 
	<div id="primary" class="<?php echo $smart_shopper_content; ?>   content-area">
		<main id="main" class="site-main" role="main">

		<?php if (class_exists('WooCommerce') && is_woocommerce()) : ?>	
			<?php woocommerce_breadcrumb(); ?>	
		<?php endif; ?>		

		<?php woocommerce_content(); ?>

		</main><!-- #main --> 

	</div><!-- #primary -->



  </div>		
</div><!-- .container -->

<?php
get_footer();
