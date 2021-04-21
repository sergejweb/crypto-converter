<?php

function pc_enqueue_scripts() {

    wp_register_style( 'pc_select2', plugins_url('/assets/css/select2.min.css', CRYPTO_PLUGIN_URL), [], time() );
    wp_register_style( 'pc_style', plugins_url('/assets/css/style.css', CRYPTO_PLUGIN_URL), ['pc_select2'], time() );

    wp_enqueue_style( 'pc_select2' );
    wp_enqueue_style( 'pc_style' );

    wp_register_script(
        'pc_select2_js', plugins_url( '/assets/js/select2.min.js', CRYPTO_PLUGIN_URL ), ['jquery'], time(), true
    );

    wp_register_script(
        'pc_main', plugins_url( '/assets/js/main.js', CRYPTO_PLUGIN_URL ), ['jquery', 'pc_select2_js'], time(), true
    );

    wp_localize_script( 'pc_main', 'pc_var_obj', [
        'ajax_url'      =>  admin_url( 'admin-ajax.php' )
    ]);

    wp_enqueue_script( 'pc_select2_js' );
    wp_enqueue_script( 'pc_main' );
}