<?php
/**
 * Requirements:
 * - Add SlidesCarousel::addRequirements() to your Controller::init() method.
 * - Add the following Javascript:
	$('.slides-carousel').slides({
		preload: true,
		preloadImage: '/banners/images/loading.gif',
		play: 7000,
		pause: 5000,
		hoverPause: true,
		paginationClass: 'carousel-pagination',
		generatePagination: false
	});
 * - Add $BannerMarkup([width], [height]) to your template
 * - You'll probably want to override SlidesCarousel.css by copying it into your theme
 * @author simonwade
 */
class SlidesCarousel extends ImageCarousel {

	public $template = 'SlidesCarousel';

	public static $options = array(
		'preload' => true,
		'preloadImage' => '/banners/images/loading.gif',
		'play' => 7000,
		'pause' => 5000,
		'hoverPause' => true,
		'paginationClass' => 'carousel-pagination',
		'generatePagination' => false,
	);

	public static $jQuery = 'ss-tools/javascript/jquery/jquery-1.4.4.js';

	public function forTemplate() {
		self::addRequirements();
		return $this->renderWith($this->template);
	}

	public static function addRequirements() {
		// slides requires jQuery 1.4.4
		$scripts = array(
				self::$jQuery,
				'banners/slides/source/slides.min.jquery.js'
		);
		foreach( $scripts as $script ) {
			Requirements::javascript($script);
		}
		// block older jQuery versions
		Requirements::block(SAPPHIRE_DIR . '/thirdparty/jquery/jquery.js');
		Requirements::block(THIRDPARTY_DIR.'/jquery/jquery-packed.js');
		return $scripts;
	}

}
