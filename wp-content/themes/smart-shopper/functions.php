<?php
/* 
 * Child theme main functions.
 */
	
define('SMART_SHOPPER_THEME_DOC', 'https://demo.ceylonthemes.com');
define('SMART_SHOPPER_THEME_URI', 'https://www.ceylonthemes.com/product/wordpress-storefront-theme/');

/* 
 * default settings
 */
require_once  get_stylesheet_directory().'/inc/default.php';

/*
 * get_parent theme settings and override with child theme settings
 */
$smart_shopper_option = wp_parse_args(  get_option( 'ecommerce_star_option', array() ) , ecommerce_star_settings()); 


function smart_shopper_styles() {
	//enqueue parent styles
	wp_enqueue_style( 'smart-shopper-parent-styles', get_template_directory_uri().'/style.css' );
} 

add_action( 'wp_enqueue_scripts', 'smart_shopper_styles' );



/**
 * Return rgb value of a $hex - hexadecimal color value with given $a - alpha value
**/
 
function smart_shopper_rgba($hex,$a){
 
	$r = hexdec(substr($hex,1,2));
	$g = hexdec(substr($hex,3,2));
	$b = hexdec(substr($hex,5,2));
	$result = 'rgba('.$r.','.$g.','.$b.','.$a.')';
	
	return $result;
}


/* 
 * allowed html tags 
 */
$smart_shopper_allowed_html = array(
		'a'          => array(
			'href'  => true,
			'title' => true,
			'class'  => true,			
		),
		'option'          => array(
			'selected'  => true,
			'value' => true,
			'class'  => true,			
		),		
		'p'          => array(
			'class'  => true,
		),		
		'abbr'       => array(
			'title' => true,
		),
		'acronym'    => array(
			'title' => true,
		),
		'b'          => array(),
		'blockquote' => array(
			'cite' => true,
		),
		'cite'       => array(),
		'code'       => array(),
		'del'        => array(
			'datetime' => true,
		),
		'em'         => array(),
		'i'          => array(),
		'q'          => array(
			'cite' => true,
		),
		's'          => array(),
		'strike'     => array(),
		'strong'     => array(),
	);

/* 
 * wp body open 
 */
function smart_shopper_body_open(){
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
}

add_action('smart_shopper_wp_body_open', 'smart_shopper_body_open');

require_once   get_stylesheet_directory().'/inc/news.php';

/*
 * override parent theme custom css
 */
function ecommerce_star_custom_css(){
	require_once  get_stylesheet_directory().'/inc/styles.php';
}

ecommerce_star_custom_css();

/*
 * header_background 
 */

add_action( 'customize_register', 'smart_shopper_customizer_settings' );

/*
 * load customizer control 
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	// Inlcude the Alpha Color Picker control file.
	require get_template_directory().'/inc/color-picker/alpha-color-picker.php';
}

function smart_shopper_customizer_settings( $wp_customize ) {

	//widgets section	
	$wp_customize->add_section( 'home_widgets' , array(
		'title'      => __( 'Home Header Widgets', 'smart-shopper' ),
		'priority'   => 1,
		'panel' => 'theme_options',
	) );	
	
	//top banner
	$wp_customize->add_setting('ecommerce_star_option[top_widgets]' , array(
		'default'    => 'col-sm-12',
		'sanitize_callback' => 'ecommerce_star_sanitize_select',
		'type'=>'option',

	));

	$wp_customize->add_control('ecommerce_star_option[top_widgets]' , array(
		'label' => __('Select Number of Widgets', 'smart-shopper' ),
		'section' => 'home_widgets',
		'type'=>'select',
		'choices'=>array(
			'col-sm-12'=> __('1 Widgets', 'smart-shopper' ),
			'col-sm-6'=> __('2 Widgets', 'smart-shopper' ),
			'col-sm-4'=> __('3 Widgets', 'smart-shopper' ),
			'col-sm-3'=> __('4 Widgets', 'smart-shopper' ),
			'col-sm-2'=> __('6 Widgets', 'smart-shopper' ),
		),
	) );
	
	//widgets section	
	$wp_customize->add_section( 'shop_page_section' , array(
		'title'      => __( 'Shop Page', 'smart-shopper' ),
		'priority'   => 2,
		'panel' => 'theme_options',
	) );
	
	//shop pages 1
	$wp_customize->add_setting('ecommerce_star_option[before_shop]' , array(
		'default'    => 0,
		'sanitize_callback' => 'absint',
		'type'=>'option',

	));

	$wp_customize->add_control('ecommerce_star_option[before_shop]' , array(
		'label' => __('Before Shop', 'smart-shopper' ),
		'section' => 'shop_page_section',
		'type'=> 'dropdown-pages',
	) );	

	
	//shop pages 2
	$wp_customize->add_setting('ecommerce_star_option[after_shop]' , array(
		'default'    => 0,
		'sanitize_callback' => 'absint',
		'type'=>'option',

	));

	$wp_customize->add_control('ecommerce_star_option[after_shop]' , array(
		'label' => __('After Shop', 'smart-shopper' ),
		'section' => 'shop_page_section',
		'type'=> 'dropdown-pages',
	) );
	
	// contact section header show / hide
	$wp_customize->add_setting( 'ecommerce_star_option[header_slider_nav]' , array(
	'default'    => 1,
	'sanitize_callback' => 'ecommerce_star_sanitize_checkbox',
	'type'=>'option',
	'priority'   => 2,
	));

	$wp_customize->add_control('ecommerce_star_option[header_slider_nav]' , array(
	'label' => __('Enable Home Product Slider|Navigation','smart-shopper' ),
	'section' => 'header_section',
	'type'=>'checkbox',
	) );
	
	// category
	$wp_customize->add_setting( 'ecommerce_star_option[slider_nav_cat]' , array(
	'default'    => "",
	'sanitize_callback' => 'ecommerce_star_sanitize_select',
	'type'=>'option'
	));

	$wp_customize->add_control('ecommerce_star_option[slider_nav_cat]' , array(
	'label' => __('Select Product Category','smart-shopper' ),
	'section' => 'header_section',
	'type'=>'select',
	'choices'=> smart_shopper_get_product_categories(),
	) );		


}


function smart_shopper_get_product_categories(){

	$args = array(
			'taxonomy' => 'product_cat',
			'orderby' => 'date',
			'order' => 'ASC',
			'show_count' => 1,
			'pad_counts' => 0,
			'hierarchical' => 0,
			'title_li' => '',
			'hide_empty' => 1,
	);

	$cats = get_categories($args);

	$arr = array();
	$arr[''] = esc_html__('All', 'smart-shopper');
	foreach($cats as $cat){
		$arr[$cat->term_id] = $cat->name;
	}
	return $arr;
}


//add child theme widget area

function smart_shopper_widgets_init(){

	/* header sidebar */
	global $smart_shopper_option;

	register_sidebar(
		array(
			'name'          => __( 'Home Header Widgets', 'smart-shopper' ),
			'id'            => 'header-banner',
			'description'   => __( 'Add widgets to appear in Header.', 'smart-shopper' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s '.esc_attr($smart_shopper_option['top_widgets']).' text-center">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

}
add_action( 'widgets_init', 'smart_shopper_widgets_init' );


/*
 * theme page
 */
require_once  get_stylesheet_directory().'/inc/help.php';

