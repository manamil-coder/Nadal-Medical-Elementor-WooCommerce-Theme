<?php

namespace Medizin_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

defined( 'ABSPATH' ) || exit;

class Widget_Product_Carousel extends Posts_Carousel_Base {

	public function get_name() {
		return 'tm-product-carousel';
	}

	public function get_title() {
		return esc_html__( 'Product Carousel', 'medizin' );
	}

	public function get_icon_part() {
		return 'eicon-posts-carousel';
	}

	public function get_keywords() {
		return [ 'product', 'carousel' ];
	}

	protected function get_post_type() {
		return 'product';
	}

	protected function register_controls() {
		$this->add_layout_section();

		$this->add_thumbnail_style_section();

		$this->add_caption_style_section();

		parent::register_controls();

		$this->update_controls();
	}

	private function update_controls() {
		$this->update_responsive_control( 'swiper_items', [
			'default'        => '5',
			'tablet_default' => '3',
			'mobile_default' => '2',
		] );

		$this->update_responsive_control( 'swiper_gutter', [
			'default' => 20,
		] );
	}

	private function add_layout_section() {
		$this->start_controls_section( 'layout_section', [
			'label' => esc_html__( 'Layout', 'medizin' ),
		] );

		$this->add_control( 'style', [
			'label'       => esc_html__( 'Style', 'medizin' ),
			'type'        => Controls_Manager::SELECT,
			'options'     => array(
				'grid-01' => esc_html__( 'Style 01', 'medizin' ),
				'grid-02' => esc_html__( 'Style 02', 'medizin' ),
				'carousel' => esc_html__( 'Style 03', 'medizin' ),
			),
			'default'     => 'grid-01',
			'render_type' => 'template',
		] );

		$this->add_control( 'title_text', [
			'label'       => esc_html__( 'Title', 'medizin' ),
			'type'        => Controls_Manager::TEXT,
			'dynamic'     => [
				'active' => true,
			],
			'default'     => esc_html__( 'This is the heading', 'medizin' ),
			'placeholder' => esc_html__( 'Enter your title', 'medizin' ),
			'label_block' => true,
			'condition' => [
				'style' => 'carousel',
			],
		] );


		$this->add_control( 'thumbnail_default_size', [
			'label'        => esc_html__( 'Use Default Thumbnail Size', 'medizin' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '1',
			'return_value' => '1',
			'separator'    => 'before',
		] );

		$this->add_group_control( Group_Control_Image_Size::get_type(), [
			'name'      => 'thumbnail',
			'default'   => 'full',
			'condition' => [
				'thumbnail_default_size!' => '1',
			],
		] );

		$this->end_controls_section();
	}

	private function add_thumbnail_style_section() {
		$this->start_controls_section( 'thumbnail_style_section', [
			'label' => esc_html__( 'Thumbnail', 'medizin' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'thumbnail_height', [
			'label'          => esc_html__( 'Height', 'medizin' ),
			'type'           => Controls_Manager::SLIDER,
			'default'        => [
				'unit' => 'px',
			],
			'tablet_default' => [
				'unit' => 'px',
			],
			'mobile_default' => [
				'unit' => 'px',
			],
			'size_units'     => [ 'px', '%', 'vw' ],
			'range'          => [
				'%'  => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
				'vw' => [
					'min' => 1,
					'max' => 100,
				],
			],
			'selectors'      => [
				'{{WRAPPER}} .post-thumbnail img' => 'height: {{SIZE}}{{UNIT}};',
			],
			'render_type'    => 'template',
		] );

		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'thumbnail_css_filters',
			'selector' => '{{WRAPPER}} .post-thumbnail img',
		] );

		$this->end_controls_section();
	}

	private function add_caption_style_section() {
		$this->start_controls_section( 'caption_style_section', [
			'label' => esc_html__( 'Caption', 'medizin' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'caption_padding', [
			'label'      => esc_html__( 'Padding', 'medizin' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .post-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'caption_text_align', [
			'label'     => esc_html__( 'Text Align', 'medizin' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => Widget_Utils::get_control_options_text_align(),
			'selectors' => [
				'{{WRAPPER}} .post-info' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_control( 'title_style_heading', [
			'label'     => esc_html__( 'Title', 'medizin' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'label'    => esc_html__( 'Typography', 'medizin' ),
			'selector' => '{{WRAPPER}} .post-info .post-title',
		] );

		$this->start_controls_tabs( 'title_color_tabs' );

		$this->start_controls_tab( 'title_color_normal_tab', [
			'label' => esc_html__( 'Normal', 'medizin' ),
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Color', 'medizin' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .post-info .post-title' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'title_color_hover_tab', [
			'label' => esc_html__( 'Hover', 'medizin' ),
		] );

		$this->add_control( 'title_hover_color', [
			'label'     => esc_html__( 'Color', 'medizin' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .post-info .post-title:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'category_style_heading', [
			'label'     => esc_html__( 'Category', 'medizin' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'category_typography',
			'label'    => esc_html__( 'Typography', 'medizin' ),
			'selector' => '{{WRAPPER}} .post-info .post-categories',
		] );

		$this->start_controls_tabs( 'category_color_tabs' );

		$this->start_controls_tab( 'category_color_normal_tab', [
			'label' => esc_html__( 'Normal', 'medizin' ),
		] );

		$this->add_control( 'category_color', [
			'label'     => esc_html__( 'Color', 'medizin' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .post-info .post-categories' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'category_color_hover_tab', [
			'label' => esc_html__( 'Hover', 'medizin' ),
		] );

		$this->add_control( 'category_hover_color', [
			'label'     => esc_html__( 'Color', 'medizin' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .post-info .post-categories a:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function print_slide( array $settings ) {
		?>
		<div class="swiper-slide">
			<?php
			/**
			 * For some reasons Elementor ignore remove_action.
			 * Then we will do it again. Fix for duplicate content.
			 */
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

			set_query_var( 'settings', $settings );
			wc_get_template_part( 'content-product', $settings['style'] );
			?>
		</div>
		<?php
	}

	public function before_slider() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( self::SLIDER_KEY, 'class', 'medizin-product style-' . $settings['style'] );

		echo '<h3>' . $settings['title_text'] . '</h3>';
	}

	public function print_title(array $settings) {
		if( empty( $settings['title_text'] ) ) {
			return;
		}

		$this->add_render_attribute( 'title_text', 'class', 'title' );

		$this->add_inline_editing_attributes( 'title_text', 'none' );

		$title_html = $settings['title_text'];

		printf( '<%1$s %2$s>%3$s</%1$s>', $settings['title_size'], $this->get_render_attribute_string( 'title_text' ), $title_html );
	}
}
