<?php
    add_action( 'wp_enqueue_scripts', 'dsignfly_child_theme_enqueue' );
    function dsignfly_child_theme_enqueue() {
        wp_enqueue_style( 'dsignfly_child_theme', get_template_directory_uri() . '/style.css',
            array( 'dsignfly_custom_css' ), 
            wp_get_theme()->get('Version') // this only works if you have Version in the style header
        );
    }