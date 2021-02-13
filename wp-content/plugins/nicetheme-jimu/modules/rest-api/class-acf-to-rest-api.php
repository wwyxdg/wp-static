<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ACF_To_REST_API' ) ) {

	class ACF_To_REST_API {

		const VERSION = '3.2.0';

		private static $old_request_version     = 2;
		private static $default_request_version = 3;
		private static $request_version;

		private static $instance = null;

		public static function init() {
			self::includes();
			self::hooks();
		}

		protected static function instance() {
			if ( is_null( self::$instance ) ) {
				$class = 'ACF_To_REST_API_V3';
				if ( class_exists( $class ) ) {
					self::$instance = new $class;
				}
			}
			return self::$instance;
		}

		private static function includes() {
			require_once dirname( __FILE__ ) . '/v3/class-acf-to-rest-api-v3.php';

			if ( self::is_plugin_active( 'all' ) ) {
				self::instance()->includes();
			}
		}

		public static function handle_request_version() {
			if ( is_null( self::$request_version ) ) {
				if ( defined( 'ACF_TO_REST_API_REQUEST_VERSION' ) ) {
					self::$request_version = (int) ACF_TO_REST_API_REQUEST_VERSION;
				} else {
					self::$request_version = (int) get_option( 'acf_to_rest_api_request_version', self::$default_request_version );
				}
			}
			return self::$request_version;
		}

		private static function hooks() {
			add_action( 'init', array( __CLASS__, 'load_plugin_textdomain' ) );

			if ( self::is_plugin_active( 'all' ) ) {
				add_action( 'rest_api_init', array( __CLASS__, 'create_rest_routes' ), 10 );
				if ( self::$default_request_version == self::handle_request_version() ) {
					ACF_To_REST_API_ACF_Field_Settings::hooks();
				}
			} else {
				add_action( 'admin_notices', array( __CLASS__, 'missing_notice' ) );
			}
		}

		public static function load_plugin_textdomain() {
			// do nothing
		}

		public static function create_rest_routes() {
			self::instance()->create_rest_routes();
		}

		public static function is_plugin_active( $plugin ) {
			if ( 'rest-api' == $plugin ) {
				return class_exists( 'WP_REST_Controller' );
			} elseif ( 'acf' == $plugin ) {
				return class_exists( 'acf' );
			} elseif ( 'all' == $plugin ) {
				return class_exists( 'WP_REST_Controller' ) && class_exists( 'acf' );
			}

			return false;
		}

		public static function missing_notice() {
			self::instance()->missing_notice();
		}
	}

	add_action( 'plugins_loaded', array( 'ACF_To_REST_API', 'init' ) );

}