<?php

class ImageCarousel extends ViewableData {

	protected $items;

	public function __construct( $items ) {
		$this->items = $items;
	}

	public function CarouselItems() {
		$items = new DataObjectSet;
		foreach( $this->items as $item ) {
			if( ($image = $item->Image()) && $image->fileExists() ) {
				$items->push($item);
			}
		}
		return $items;
	}

	public function setWidth( $width ) {
		$this->resizeImages('SetWidth', $height);
	}

	public function setHeight( $height ) {
		$this->resizeImages('SetHeight', $height);
	}

	public function setRatioSize($width, $height) {
		$this->resizeImages('SetRatioSize', $width, $height);
	}

	public function setCroppedSize($width, $height) {
		$this->resizeImages('SetCroppedSize', $width, $height);
	}

	public function SetPaddedSize($width, $height) {
		$this->resizeImages('SetPaddedSize', $width, $height);
	}

	public function resizeImages( $method, $arg1, $arg2 = null ) {
		foreach( $this->items as $item ) {
			$image = $item->Image(); /* @var $image BetterImage */
			if( $image && $image->fileExists() ) {
				$item->setImage($image->$method($arg1, $arg2));
			}
		}
	}

	public function NumItemsBy( $widthPerItem, $suffix = null ) {
		return $this->CarouselItems()->Count() * $widthPerItem.$suffix;
	}

}

interface ImageCarouselItem {

	/**
	 * @return Image
	 */
	function Image();

	/**
	 * Used to allow ImageCarousel to provide support for resizing.
	 * @param Image $image
	 */
	function setImage( $image );

	function LinkURL();
	function Title();

}

