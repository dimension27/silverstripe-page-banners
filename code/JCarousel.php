<?php

class JCarousel extends ImageCarousel {

	public $template = 'JCarousel';

	public function forTemplate() {
		// Requirements::javascript('banners/jcarousel/lib/jquery.jcarousel.min.js');
		/* debug */ Requirements::javascript('banners/jcarousel/lib/jquery.jcarousel.js');
		return $this->renderWith($this->template);
	}

}
