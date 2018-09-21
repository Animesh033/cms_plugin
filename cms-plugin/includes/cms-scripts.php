<?php
add_action( 'wp_enqueue_scripts', 'so_enqueue_scripts' );
function so_enqueue_scripts(){
  wp_register_script( 'ajaxHandle', plugins_url().'/cms-plugin/js/cms.js', array(), false, true );
  wp_enqueue_script( 'ajaxHandle' );
  wp_localize_script( 'ajaxHandle', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
  wp_localize_script( 'ajaxHandle', 'ajax_object2', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

  wp_enqueue_style('cms-style', plugins_url(). '/cms-plugin/css/cms-style.css');
}