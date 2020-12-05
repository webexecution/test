<section id="after-shop">
	<div>
		<?php 
		global $smart_shopper_option;	
			if ( class_exists( 'WP_Customize_Control' ) ) {
			$smart_shopper_option = wp_parse_args(  get_option( 'ecommerce_star_option', array() ) , ecommerce_star_settings());  
		}

		$smart_shopper_banner = $smart_shopper_option['after_shop'];
	
		$smart_shopper_args = array( 'post_type' => 'page','ignore_sticky_posts' => 1 , 'post__in' => array($smart_shopper_banner));
		$smart_shopper_result = new WP_Query($smart_shopper_args);
		while ( $smart_shopper_result->have_posts() ) :
			$smart_shopper_result->the_post();
			the_content();
		endwhile;
		wp_reset_postdata();

		 ?>
	</div>
</section> 