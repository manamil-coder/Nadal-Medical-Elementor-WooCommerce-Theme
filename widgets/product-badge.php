<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Medizin_WP_Widget_Product_Badge' ) ) {
	class Medizin_WP_Widget_Product_Badge extends Medizin_Widget {

		public function __construct() {

			$badge_options = array(
				'new'     => esc_html__( 'New products', 'medizin' ),
				'on_sale' => esc_html__( 'On-sale products', 'medizin' ),
				'hot'     => esc_html__( 'Featured products', 'medizin' ),
			);

			$this->widget_id          = 'medizin-wp-widget-product-badge';
			$this->widget_cssclass    = 'medizin-wp-widget-product-badge';
			$this->widget_name        = esc_html__( '[Medizin] Product Badge', 'medizin' );
			$this->widget_description = esc_html__( 'Get List Badge', 'medizin' );
			$this->settings           = array(
				'title'              => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Title', 'medizin' ),
				),
				'show_badge_hot'     => array(
					'type'  => 'checkbox',
					'std'   => 1,
					'label' => esc_html__( 'Featured product', 'medizin' ),
				),
				'badge_hot_text'     => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Hot items', 'medizin' ),
					'label' => esc_html__( 'Hot Badge Text', 'medizin' ),
				),
				'show_badge_on_sale' => array(
					'type'  => 'checkbox',
					'std'   => 1,
					'label' => esc_html__( 'On sale product', 'medizin' ),
				),
				'badge_sale_text'    => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Sale', 'medizin' ),
					'label' => esc_html__( 'On sale Badge Text', 'medizin' ),
				),
				'show_badge_new'     => array(
					'type'  => 'checkbox',
					'std'   => 1,
					'label' => esc_html__( 'New product', 'medizin' ),
				),
				'badge_new_text'     => array(
					'type'  => 'text',
					'std'   => esc_html__( 'New Arrivals', 'medizin' ),
					'label' => esc_html__( 'New Badge Text', 'medizin' ),
				),
			);

			parent::__construct();
		}

		public function widget( $args, $instance ) {
			if ( ! is_singular( 'product' ) ) {
				return;
			}

			$badge_hot       = isset( $instance['show_badge_hot'] ) ? $instance['show_badge_hot'] : $this->settings['show_badge_hot']['std'];
			$badge_on_sale   = isset( $instance['show_badge_on_sale'] ) ? $instance['show_badge_on_sale'] : $this->settings['show_badge_on_sale']['std'];
			$badge_new       = isset( $instance['show_badge_new'] ) ? $instance['show_badge_new'] : $this->settings['show_badge_new']['std'];
			$badge_hot_text  = isset( $instance['badge_hot_text'] ) ? $instance['badge_hot_text'] : $this->settings['badge_hot_text']['std'];
			$badge_new_text  = isset( $instance['badge_new_text'] ) ? $instance['badge_new_text'] : $this->settings['badge_new_text']['std'];
			$badge_sale_text = isset( $instance['badge_sale_text'] ) ? $instance['badge_sale_text'] : $this->settings['badge_sale_text']['std'];

			/**
			 * @var WP_Post    $post
			 * @var WC_Product $product
			 */
			global $post;
			$product = wc_get_product( $post->ID );

			if ( ! $product ) {
				return;
			}

			$is_featured = $is_sale = $is_new = false;

			if ( $product->is_featured() ) {
				$is_featured = true;
			}

			if ( $product->is_on_sale() ) {
				$is_sale = true;
			}

			$new_days = Medizin::setting( 'shop_badge_new' );

			if ( '0' !== $new_days ) {
				$postdate        = get_the_time( 'Y-m-d', $product->get_id() );
				$post_date_stamp = strtotime( $postdate );

				if ( ( time() - ( 60 * 60 * 24 * $new_days ) ) < $post_date_stamp ) {
					$is_new = true;
				}
			}

			$this->widget_start( $args, $instance );
			?>
			<?php if ( $badge_hot || $badge_new || $badge_on_sale ) : ?>
				<ul class="medizin-wp-widget-product-badge-list">
					<?php if ( $badge_new ): ?>
						<li>
							<input type="checkbox" disabled <?php checked( $is_new ); ?>/>
							<span><?php echo esc_html( $badge_new_text ); ?></span>
						</li>
					<?php endif; ?>

					<?php if ( $badge_on_sale ): ?>
						<li>
							<input type="checkbox" disabled <?php checked( $is_sale ); ?>/>
							<span><?php echo esc_html( $badge_sale_text ); ?></span>
						</li>
					<?php endif; ?>

					<?php if ( $badge_hot ): ?>
						<li>
							<input type="checkbox" disabled <?php checked( $is_featured ); ?>/>
							<span><?php echo esc_html( $badge_hot_text ); ?></span>
						</li>
					<?php endif; ?>
				</ul>
			<?php endif; ?>
			<?php
			$this->widget_end( $args );
		}
	}
}
