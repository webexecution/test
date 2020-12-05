<?php

function twentyninteen_child_scripts() {
    wp_enqueue_script("extra-js", get_stylesheet_directory_uri()  . '/js/extra.js');
}

add_action('wp_enqueue_scripts', 'twentyninteen_child_scripts');

function twentyninteen_child_widget_init(){
    register_sidebar(
        array(
            'name' => 'Agnosticoder New Widget Area',
            'id' => 'agnosticoder_new_widget_area',
            'before_widget' => '<aside>',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        )
    );
}

add_action('widgets_init', 'twentyninteen_child_widget_init');

function twentyninteen_child_register_menu(){
    register_nav_menu('new-menu', __('Our New Menu'));
}

add_action('init', 'twentyninteen_child_register_menu');
?>