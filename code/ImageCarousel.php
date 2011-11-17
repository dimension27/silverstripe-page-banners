<?php
/**
 * Various jQuery carousel plugins are available in this module:
 * 
 * - Slides: Best option, but doesn't support showing more than one slide at a time
 *   - See http://slidesjs.com/
 * - jCarousel: Okay, but does support showing more than one slide at a time.
 *   - Have had problems extending it in the past
 *   - No support for showing pagination
 *   - Benefit is that it works out how many slides to display based on the widths of the slides 
 *   - See http://sorgalla.com/projects/jcarousel/
 *   - Does dumb things like removing your classes
 * - BXSlider: Supports more than one slide at a time but requires a width to be specified for each item
 *   - Also, the number of slides to display at once is pre-defined - doesn't adapt to the width
 * 
 * @author simonwade
 */
class ImageCarousel extends ViewableData {

	public static $options = array();
	public static $includeScriptInBody = true;
	public $template;
	protected $items;

	public function __construct( $items ) {
		$this->items = $items;
	}

	public function CarouselItems() {
		$items = new DataObjectSet();
		if( $this->items ) {
			foreach( $this->items as $item ) {
				if( ($image = $item->Image()) && $image->fileExists() ) {
					$items->push($item);
				}
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
		if( $this->items ) {
			foreach( $this->items as $item ) {
				$image = $item->Image(); /* @var $image BetterImage */
				if( $image && $image->fileExists() ) {
					$item->setImage($image->$method($arg1, $arg2));
				}
			}
		}
	}

	public function NumItemsBy( $widthPerItem, $suffix = null ) {
		return $this->CarouselItems()->Count() * $widthPerItem.$suffix;
	}

	public function CarouselOptions() {
		return json_encode(self::$options);
	}

	public function IncludeScriptInBody() {
		return self::$includeScriptInBody;
	}

	public static function getItemsForImages( $images ) {
		$items = new DataObjectSet();
		foreach( $images as $image ) {
			$items->push(new ImageCarouselItem($image));
		}
		return $items;
	}

}

class ImageCarouselItem {

	public $dataObject, $image, $LinkUrl, $Title, $Caption;

	function __construct( $dataObject, $LinkURL = null, $Title = null, $Caption = null ) {
		$this->image = $image;
		$this->LinkURL = $LinkURL;
		$this->Title = $Title;
		$this->Caption = $Caption;
	}

	/**
	 * @return Image
	 */
	function Image() {
		return $this->image ? $this->image
				: $this->dataObject instanceof Image ? $this->dataObject
						: $this->dataObject->Image();
	}

	/**
	 * Used to allow ImageCarousel to provide support for resizing.
	 * @param Image $image
	 */
	function setImage( $image ) {
		$this->image = $image;
	}

	function __get( $property ) {
		if( isset($this->dataObject->$property) ) {
			return $this->dataObject->$property;
		}
		else if( method_exists($this->dataObject, $method = "get$property") ) {
			return $this->dataObject->$method();
		}
	}

}

