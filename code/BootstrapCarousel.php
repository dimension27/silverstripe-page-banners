<?php
/**
 * Requirements:
 * - Include bootstrap requirements in your page
 * - Add $BannerMarkup([width], [height]) to your template
 * @author simonwade
 */
class BootstrapCarousel extends ImageCarousel {

	public $template = 'BootstrapCarousel';
	public $ShowIndicators = true;
	public $DOMId = 'bootstrap-carousel';

	public function forTemplate() {
		self::addRequirements();
		return $this->renderWith($this->template);
	}

}
