<?php

class ImageCarouselDecorator extends DataObjectDecorator {

	protected static $tabName = 'Root.Content.Images';

	/**
	 * Restricts the selection of banners to a single BannerGroup in the CMS fields
	 * @param BannerGroup $group May be a BannerGroup or its ID
	 */
	public static function setTabName( $tabName ) {
		self::$tabName = $tabName;
	}

	public function extraStatics() {
		return array(
			'has_many' => array(
				'ImageCarouselItems' => 'ImageCarouselItem',
			),
		);
	}

	public function updateCMSFields( FieldSet $fields ) {
		$fields->addFieldToTab($this->stat('tabName'), $field = new ImageDataObjectManager(
			$this, 'ImageCarouselItems', 'ImageCarouselItem', 'Image'
		));
	}

	public function ImageCarousel( $width = null, $height = null, $transform = 'SetRatioSize' ) {
		$carousel = new SlidesCarousel(ImageCarousel::getItemsForImages($this->AllBanners()));
		$carousel->setRatioSize($width, $height);
		return $carousel;
	}

}
