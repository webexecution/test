<?php
if(!function_exists('ecommerce_star_submenu_page_callback')){
function ecommerce_star_submenu_page_callback() {
 ?>
<div class="wrap" >

	<div class="welcome-panel">
	
	<h2><?php esc_html_e("We have created a guide to get you started:", 'smart-shopper'); ?> </h2>
	
	<div class="welcome-panel-column">
	
	<h2 id="getting-started"><?php esc_html_e('Getting Started', 'smart-shopper'); ?> </h2>
	
	<br />
	<a class="button button-primary" href="<?php echo SMART_SHOPPER_THEME_DOC; ?>" target="_blank"><?php esc_html_e('See Tutorials & FREE DEMO', 'smart-shopper'); ?></a>

	
	<h3><?php echo esc_html__('Set Home Page :-', 'smart-shopper'); ?></h3>
	<p><?php echo esc_html__('Settings -> Reading -> Select a static page, select home page and save settings.', 'smart-shopper'); ?> </p>

	
	<h3><?php echo esc_html__('Create Menus :-', 'smart-shopper'); ?></h3>
	<p><?php echo esc_html__('Appearance > Menu and Click View all locations. Theme has 2 menu areas called Top and Footer. Create and assign menus. Click save.', 'smart-shopper'); ?> </p>			
	
	<h3><?php echo esc_html__('Add Wishlist, Compare support :-', 'smart-shopper'); ?></h3>
	<p><?php echo esc_html__('Install YITH WishList, YITH quick view and YITH Compare plugins.', 'smart-shopper'); ?> </p>
	
	</div>
	
	
	
	<div class="welcome-panel-column">
	
	<h2><?php esc_html_e('Next Steps', 'smart-shopper'); ?> </h2>
	
	<h3><?php echo esc_html__('Add Header Contact and Social links :-', 'smart-shopper'); ?></h3>
	<p><?php echo esc_html__('Customizer  -> Theme Options -> Header, Add phone, email, Work Hours Edit My Account Link', 'smart-shopper'); ?> </p>

	<h3><?php echo esc_html__('Add sub header with Image :-', 'smart-shopper'); ?></h3>
	<p><?php echo esc_html__('Customizer  -> Theme Options -> Sub Header.', 'smart-shopper'); ?> </p>
	
	<h3><?php echo esc_html__('Enable / Disable WooCommerce popup cart | my account :-', 'smart-shopper'); ?></h3>
	<p><?php echo esc_html__('Customizer  -> Theme Options -> Popup cart.', 'smart-shopper'); ?> </p>		
	
	<h3><?php echo esc_html__('Change site layout / Sidebar positions :-', 'smart-shopper'); ?></h3>
	<p><?php echo esc_html__('Customizer  -> Theme Options -> Layout', 'smart-shopper'); ?> </p>
	
	<h3><?php echo esc_html__('Format UI elements :-', 'smart-shopper'); ?></h3>
	<p><?php echo esc_html__('Customizer  -> Theme Options -> Buttons and UI elements', 'smart-shopper'); ?> </p>		

	
	<h3><?php echo esc_html__('Change Fonts :-', 'smart-shopper'); ?></h3>
	<p><?php echo esc_html__('Customizer  -> Theme Options -> Fonts. Change fonts', 'smart-shopper'); ?> </p>

	
	<h3><?php echo esc_html__('Change Footer Credits / Colours :-', 'smart-shopper'); ?></h3>
	<p><?php echo esc_html__('Customizer  -> Theme Options -> Footer. Edit text.', 'smart-shopper'); ?> </p>
	
	</div>
	
	
	<div class="welcome-panel-column">
		<h2><?php esc_html_e('More Actions', 'smart-shopper'); ?> </h2>
		
		<h3><?php echo esc_html__('Change Header style to Storefront / Sticky etc: :-', 'smart-shopper'); ?></h3>
		<p><?php echo esc_html__('Edit page. Righ hand side, you will find page options Select desired header style from page options.', 'smart-shopper'); ?> </p>
		
		<h3><?php echo esc_html__('Creating Product pages :-', 'smart-shopper'); ?></h3>
		<p><?php echo esc_html__('Add shortcode widget and use product shortcodes', 'smart-shopper'); echo esc_html__(' https://docs.woocommerce.com/document/woocommerce-shortcodes/', 'smart-shopper'); ?> </p>			
		
		<a class="button button-primary button-hero" href="<?php echo ECOMMERCE_STAR_THEME_URI; ?>" target="_blank"><?php esc_html_e('See Premium Features', 'smart-shopper'); ?></a>		
	</div>	
	

	</div>

</div> 
 <?php
 }
}
