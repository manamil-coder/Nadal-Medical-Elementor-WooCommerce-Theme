<?php
defined( 'ABSPATH' ) || exit;

/**
 * Plugin installation and activation for WordPress themes
 */
if ( ! class_exists( 'Medizin_Register_Plugins' ) ) {
	class Medizin_Register_Plugins {

		protected static $instance = null;

		const GOOGLE_DRIVER_API = 'AIzaSyBQsxIg32Eg17Ic0tmRvv1tBZYrT9exCwk';

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function initialize() {
			add_filter( 'insight_core_tgm_plugins', array( $this, 'register_required_plugins' ) );
		}

		public function register_required_plugins( $plugins ) {
			/*
			 * Array of plugin arrays. Required keys are name and slug.
			 * If the source is NOT from the .org repo, then source is also required.
			 */
			$new_plugins = array(
				array(
					'name'     => esc_html__( 'Insight Core', 'medizin' ),
					'slug'     => 'insight-core',
					'source'   => 'https://www.dropbox.com/s/u4o8qjg3pzk26xz/insight-core-2.6.4.zip?dl=1',
					'version'  => '2.6.4',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'Elementor', 'medizin' ),
					'slug'     => 'elementor',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'Elementor Pro', 'medizin' ),
					'slug'     => 'elementor-pro',
					'source'   => 'https://www.dropbox.com/s/iw023g15spgoyye/elementor-pro-3.9.2.zip?dl=1',
					'version'  => '3.9.2',
					'required' => true,
				),
				array(
					'name'    => esc_html__( 'Revolution Slider', 'medizin' ),
					'slug'    => 'revslider',
					'source'  => 'https://www.dropbox.com/s/citq4q974z0069m/revslider-6.6.14.zip?dl=1',
					'version' => '6.6.14',
				),
				array(
					'name' => esc_html__( 'Contact Form 7', 'medizin' ),
					'slug' => 'contact-form-7',
				),
				array(
					'name' => esc_html__( 'MailChimp for WordPress', 'medizin' ),
					'slug' => 'mailchimp-for-wp',
				),
				array(
					'name' => esc_html__( 'WooCommerce', 'medizin' ),
					'slug' => 'woocommerce',
				),
				array(
					'name'    => esc_html__( 'Insight Swatches', 'medizin' ),
					'slug'    => 'insight-swatches',
					'source'  => 'https://www.dropbox.com/s/sk7bt4mneusbhlb/insight-swatches-1.4.0.zip?dl=1',
					'version' => '1.4.0',
				),
				array(
					'name'    => esc_html__( 'WooCommerce Brands Pro', 'medizin' ),
					'slug'    => 'woo-brand',
					'source'  => 'https://www.dropbox.com/s/9rysk710yz9jxmy/woo-brand-4.5.0.zip?dl=1',
					'version' => '4.5.0',
				),
				array(
					'name' => esc_html__( 'WPC Smart Compare for WooCommerce', 'medizin' ),
					'slug' => 'woo-smart-compare',
				),
				array(
					'name' => esc_html__( 'WPC Smart Wishlist for WooCommerce', 'medizin' ),
					'slug' => 'woo-smart-wishlist',
				),
				array(
					'name' => esc_html__( 'WP-PostViews', 'medizin' ),
					'slug' => 'wp-postviews',
				),
				array(
					'name'    => esc_html__( 'Instagram Feed', 'medizin' ),
					'slug'    => 'elfsight-instagram-feed-cc',
					'source'  => 'https://www.dropbox.com/s/o55sjvh8fs2nmoq/elfsight-instagram-feed-cc-4.0.3.zip?dl=1',
					'version' => '4.0.3',
				),
			);

			$plugins = array_merge( $plugins, $new_plugins );

			return $plugins;
		}
	}

	Medizin_Register_Plugins::instance()->initialize();
}
