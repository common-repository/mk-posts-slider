<?php

/**
 * PostsSlider class.
 *
 * @category   Class
 * @package    DMAElementorPostsSlider
 * @subpackage WordPress
 * @author     Malak Younan <malaak4web@gmail.com>
 * @copyright  2023 Malak Younan
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(https://www.benmarshall.me/build-custom-elementor-widgets/,
 *             Build Custom Elementor Widgets)
 * @since      1.0.0
 * php version 7.3.9
 */

namespace DMAElementorPostsSlider\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * PostsSlider widget class.
 *
 * @since 1.0.0
 */
class PostsSlider extends Widget_Base
{
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct($data = array(), $args = null)
	{
		parent::__construct($data, $args);

		wp_register_script('PostsSliderJS', plugins_url('/assets/js/PostsSlider.js', DMA_ELEMENTOR_POSTS_SLIDER), [], '1.0.0', true);
		// wp_register_script( 'PostsSliderJS', plugins_url( '/assets/js/PostsSlider.js', DMA_ELEMENTOR_POSTS_SLIDER ), ['jquery', 'swiper'], '1.0.0', true );


		// wp_register_style('PostsSlider', plugins_url('/assets/css/PostsSlider.css', DMA_ELEMENTOR_POSTS_SLIDER), array(), '1.0.0');
	}

	public function get_script_depends()
	{
		return ['jquery', 'elementor-slider', 'swiper', 'elementor-frontend', 'PostsSliderJS'];
	}
	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'PostsSlider';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return __('Posts Slider', 'elementor-PostsSlider');
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-carousel';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return array('general');
	}

	/**
	 * Enqueue styles.
	 */
	public function get_style_depends()
	{
		return array('PostsSlider');
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls()
	{
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __('Content', 'elementor-PostsSlider'),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'   => __('Title', 'elementor-PostsSlider'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Title', 'elementor-PostsSlider'),
			)
		);


		$this->add_control(
			'type',
			array(
				'label'   => __('Post Type', 'elementor-PostsSlider'),
				'type'    => Controls_Manager::SELECT,
				'options' => get_post_types()
			)
		);

		$this->add_responsive_control(
			'number',
			[
				'label' => esc_html__('Posts Count', 'textdomain'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 10,
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => esc_html__('Show excerpt', 'textdomain'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'textdomain'),
				'label_off' => esc_html__('Hide', 'textdomain'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => esc_html__('Show image', 'textdomain'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'textdomain'),
				'label_off' => esc_html__('Hide', 'textdomain'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider',
			array(
				'label' => __('Slider', 'elementor-PostsSlider'),
			)
		);

		$this->add_responsive_control(
			'items',
			[
				'label' => esc_html__('Items Per Screen', 'textdomain'),
				'type'    => Controls_Manager::SELECT,
				'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6]
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label' => esc_html__('Space Between', 'textdomain'),
				'type'    => Controls_Manager::NUMBER,
			]
		);
		$this->add_control(
			'loop',
			[
				'label' => esc_html__('Loop', 'textdomain'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'textdomain'),
				'label_off' => esc_html__('Off', 'textdomain'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'pauseOnHover',
			[
				'label' => esc_html__('Pause On Hover', 'textdomain'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'textdomain'),
				'label_off' => esc_html__('Off', 'textdomain'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'dots',
			[
				'label' => esc_html__('Dots', 'textdomain'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'textdomain'),
				'label_off' => esc_html__('Off', 'textdomain'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => esc_html__('Arrows', 'textdomain'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'textdomain'),
				'label_off' => esc_html__('Off', 'textdomain'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => __('Slider Style', 'elementor-posts-slider'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bgColor',
			[
				'label' => esc_html__('Background Color', 'elementor-posts-slider'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .posts-slider-wrapper' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sliderPadding',
			[
				'label' => esc_html__('Padding', 'textdomain'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem', 'custom'],
				'selectors' => [
					'{{WRAPPER}} .posts-slider-wrapper  ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'titleColor',
			[
				'label' => esc_html__('Title Color', 'elementor-posts-slider'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .posts-slider-wrapper .posts-title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'slider_typography',
				'label'	=> "Title typography",
				'selector' => '{{WRAPPER}} .posts-slider-wrapper  .posts-title',
			]
		);
		$this->add_control(
			'arrowColor',
			[
				'label' => esc_html__('Arrow Color', 'elementor-posts-slider'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .posts-slider-wrapper .swiper-button-next,{{WRAPPER}} .posts-slider-wrapper  .swiper-button-prev' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'arrowPosition',
			[
				'label' => esc_html__('Arrow Position', 'elementor-posts-slider'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'selectors' => [
					'{{WRAPPER}} .posts-slider-wrapper .swiper-button-next' => 'right: {{VALUE}}px',
					'{{WRAPPER}} .posts-slider-wrapper  .swiper-button-prev' => 'left: {{VALUE}}px',
				],
			]
		);


		$this->add_control(
			'arrowSize',
			[
				'label' => esc_html__('Arrow Size', 'elementor-posts-slider'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next:after,{{WRAPPER}}  .swiper-button-prev:after' => 'font-size: {{VALUE}}px !important',
				],
			]
		);


		/* Add the options you'd like to show in this tab here */
		$this->end_controls_section();

		$this->start_controls_section(
			'postStyle',
			[
				'label' => __('Post Style', 'elementor-posts-slider'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'postBgColor',
			[
				'label' => esc_html__('Post Background Color', 'elementor-posts-slider'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-slide ' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'padding',
			[
				'label' => esc_html__('Padding', 'textdomain'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem', 'custom'],
				'selectors' => [
					'{{WRAPPER}} .posts-slider-wrapper .swiper-slide ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'postTitleColor',
			[
				'label' => esc_html__('Title Color', 'elementor-posts-slider'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .posts-slider-wrapper .swiper-slide  h4' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label'	=> "Title typography",
				'selector' => '{{WRAPPER}} .posts-slider-wrapper .swiper-slide  h4',
			]
		);

		$this->add_control(
			'descriptionColor',
			[
				'label' => esc_html__('Description Color', 'elementor-posts-slider'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .posts-slider-wrapper .swiper-slide  p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'label'	=> "description typography",
				'selector' => '{{WRAPPER}} .posts-slider-wrapper .swiper-slide  p',
			]
		);




		/* Add the options you'd like to show in this tab here */
		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes('title', 'none');
		$posts = get_posts([
			'post_type' 		=> $settings['type'],
			'posts_per_page'	=> $settings['number']
		]);

		$config = [
			'slidesToShowMobile' 	=> $settings['items_mobile'],
			'slidesToShowTablet' 	=> $settings['items_tablet'],
			'slidesToShowDesktop' 	=> $settings['items'],
			'loop'					=> $settings['loop'] == 'yes',
			'pauseOnHover'			=> $settings['pauseOnHover'] == 'yes',
			'dots'					=> $settings['dots'] == 'yes',
			'navigation'			=> $settings['navigation'] == 'yes',
		];


?>
		<div class="posts-slider-wrapper ">
			<h2 class="posts-title" <?php echo $this->get_render_attribute_string('title'); ?> > <?php _e($settings['title'], 'elementor-posts-slider'); ?></h2>
			<div class="swiper" data-settings='<?php echo wp_json_encode($config) ?>'>
				<div class=" swiper-wrapper">
					<?php foreach ($posts as $post) {
						$img = '';
						$excerpt = '';
						if ($settings['show_excerpt']) 	$excerpt 	= get_the_excerpt($post);
						if ($settings['show_image']) 	$img 		= get_the_post_thumbnail($post->ID, 'full', array('class' => 'postImage'));
					?>
						<div class="post swiper-slide">
							<!-- Title  -->
							<h4><?php _e($post->post_title, 'elementor-posts-slider') ?></h4>
							<!-- Image  -->
							<?php _e($img, 'elementor-posts-slider') ?>
							<!-- Excerpt -->
							<p>

								<?php _e($excerpt, 'elementor-posts-slider') ?>
							</p>
						</div>
					<?php } ?>

				</div>

				<?php
				if ($settings['dots'] == 'yes') {
					echo '<!-- If we need pagination -->
						<div class="swiper-pagination"></div>';
				}
				?>
				<?php
				if ($settings['navigation'] == 'yes') {
					echo '<!-- If we need navigation buttons -->
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>';
				}
				?>
			</div>
		</div>
<?php
	}

	/**
	 * <div class="swiper-pagination"></div>
					<div class="elementor-swiper-button elementor-swiper-button-prev">
						<i aria-hidden="true" class="eicon-chevron-left"></i> <span class="elementor-screen-only">Previous</span>
					</div>
					<div class="elementor-swiper-button elementor-swiper-button-next">
						<i aria-hidden="true" class="eicon-chevron-right"></i> <span class="elementor-screen-only">Next</span>
					</div>
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	/*
	protected function _content_template()
	{
	?>
		<# view.addInlineEditingAttributes( 'title' , 'none' ); view.addInlineEditingAttributes( 'description' , 'basic' ); view.addInlineEditingAttributes( 'content' , 'advanced' ); #>
			<h2 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h2>
			<div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ settings.description }}}</div>
			<div {{{ view.getRenderAttributeString( 'content' ) }}}>{{{ settings.content }}}</div>
	<?php
	}
	*/
}
