<?php

class BXSlider extends ImageCarousel {

	public $template = 'BXSlider';

	public function forTemplate() {
		Requirements::javascript('banners/bxSlider/jquery.bxSlider.min.js');
		return $this->renderWith($this->template);
	}

}
