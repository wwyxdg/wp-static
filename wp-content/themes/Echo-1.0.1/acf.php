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
*/

define( 'ECHO_DIR', dirname(__FILE__) );
define( 'ECHO_RELATIVE_DIR', ECHO_DIR );
define( 'ECHO_VERSION', '1.0' );

// nc store check
if( !defined('NC_STORE_ROOT_PATH') ){

	add_action( 'admin_notices', 'echoinit_check' );
	function echoinit_check(){
		$script_url = get_template_directory_uri() . '/js/nc-store-install.js';
		$html = '<div class="notice notice-error">
			<p><b>错误：</b> Echo 主题 缺少依赖插件 <code>nicetheme 积木</code> 请先安装并启用 <code>nicetheme 积木</code> 插件。<a href="javascript:;" class="install-nc-store-now">现在安装？</a></p>
		</div><script type="text/javascript" src="' . $script_url . '"></script>';
		echo $html;
	}

	if( !is_admin() ){
		wp_die('Echo 主题 缺少依赖插件 <code>nicetheme 积木</code> 请先安装并启用 <a href="https://www.nicetheme.cn/jimu">nicetheme 积木</a> 插件。');
	}

} else {

	acf_add_options_sub_page(
		array(
			'page_title'      => 'Echo 主题设置',
			'menu_title'      => 'Echo 主题设置',
			'menu_slug'       => 'echo-options',
			'parent_slug'     => 'nc-modules-store',
			'capability'      => 'manage_options',
			'update_button'   => '保存',
			'updated_message' => '设置已保存！'
		)
	);

	add_filter('nc_save_json_paths', 'echo_acf_json_save_point');
	function echo_acf_json_save_point( $path ) {
	    // update path
	    $path[] = ECHO_DIR . '/conf';

	    // return
	    return $path;
	}

	add_filter('acf/settings/load_json', 'echo_acf_json_load_point');
	function echo_acf_json_load_point( $paths ) {
	    // append path
	    $paths[] = ECHO_DIR . '/conf';

	    // return
	    return $paths;
	}

	function echo_set_main_option() { 
		$field_group_json = 'group_5c4c7507f40p9.json'; 
		$option_config = json_decode(file_get_contents(ECHO_DIR . '/conf/' . $field_group_json), true); 
		$echo_option = get_all_custom_field_meta('option', $option_config);
		update_option('echo_option', $echo_option, true);
	} 
	add_action('acf/save_post', 'echo_set_main_option'); 

	$echo_option = get_option('echo_option');

	if (false == $echo_option) echo_set_main_option();
}