<?php

/*
            /$$
    /$$    /$$$$
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2018-10-14 14:36:48
  	@Last Modified by:   Dami
  	@Last Modified time: 2018-11-30 19:45:30

*/
if ( ! defined( 'ABSPATH' ) ) { exit; }
function nc_load_static(){
    wp_register_script( 'ncstore', NC_BASE_URL . 'library/static/ncstore.js', array('layer'), NC_STORE_VER ); 
    wp_register_script( 'layer', NC_BASE_URL . 'library/static/layer/layer.js', array('jquery'), NC_STORE_VER );  
    wp_register_style( 'nicetheme-style', NC_BASE_URL . 'library/static/style.css', array(), NC_STORE_VER, 'all'  );
    
    wp_enqueue_script( 'ncstore' ); 
    wp_enqueue_script( 'layer' );

    wp_enqueue_style('nicetheme-style');
}
add_action( 'admin_enqueue_scripts', 'nc_load_static' );

function nc_load_static_front() {
  wp_deregister_script('wp-mediaelement');
	wp_deregister_style('wp-mediaelement');
}
add_action( 'wp_enqueue_scripts', 'nc_load_static_front' );

function nc_load_experimental_static() {
    wp_register_script( 'vue', NC_BASE_URL . 'library/static/vue.min.js', array('jquery'), '2.6.10');

    if (!is_admin()) {
      wp_enqueue_script( 'vue' );
    }
}