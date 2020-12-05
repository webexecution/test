<?php

/**
 * Plugin Name: Business Directory Post types and Texonomies
 * Description: Simple plugin to create custom post types
 * Plugin URI: 
 * Author: Sani
 * Author URI: https://agnosticoder.me
 * Version: 0.1
 * License: GNU General Public License v2.0
 * Text Domain: free-images
 *
 * @package Free Images
 */

if( !defined('WPINC')){
    die;
}

define('LIL VERSION', '1.0.0');
define('LILDOMAIN', 'lil-post-types');
define('LILPATH', plugin_dir_path(__FILE__));

//Business Post Type
require_once(LILPATH . '/post-types/register.php');
add_action('init', 'lil_register_business_type');

// Texonomies
require_once(LILPATH . '/texonomies/register.php');
add_action('init', 'lil_register_size_texonomy');