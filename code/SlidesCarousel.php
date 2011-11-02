<?php
/**
 *
	$('.slides-carousel').slides({
		preload: true,
		preloadImage: '/banners/images/loading.gif',
		play: 7000,
		pause: 5000,
		hoverPause: true,
		paginationClass: 'carousel-pagination',
		generatePagination: false
	});

 * @author simonwade
 *
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

	public function forTemplate() {
		// slides requires jQuery 1.4.4
		Requirements::javascript('ss-tools/javascript/jquery-1.4.4.js');
		// block older jQuery versions
		Requirements::block(SAPPHIRE_DIR . '/thirdparty/jquery/jquery.js');
		Requirements::block(THIRDPARTY_DIR.'/jquery/jquery-packed.js');
		Requirements::javascript('banners/slides/source/slides.min.jquery.js');
		return $this->renderWith($this->template);
	}

}
