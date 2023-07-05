<?php
defined( 'ABSPATH' ) || exit;

/**
 * Initial OneClick import for this theme
 */
if ( ! class_exists( 'Medizin_Import' ) ) {
	class Medizin_Import {

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			add_filter( 'insight_core_import_demos', array( $this, 'import_demos' ) );
			add_filter( 'insight_core_import_generate_thumb', '__return_false' );
			add_filter( 'insight_core_import_delete_exist_posts', '__return_true' );
		}

		public function import_demos() {
			$import_img_url = MEDIZIN_THEME_URI . '/assets/import';

			return array(
				'main' => array(
					'screenshot' => MEDIZIN_THEME_URI . '/screenshot.jpg',
					'name'       => esc_html__( 'Main', 'medizin' ),
					'url'        => 'https://www.dropbox.com/s/fgv8jolvohml9ia/medizin-insightcore-main-1.3.4.zip?dl=1',
				),
			);
		}
	}

	Medizin_Import::instance()->initialize();
}
