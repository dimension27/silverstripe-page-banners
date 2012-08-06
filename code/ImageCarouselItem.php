<?php

class ImageCarouselItem extends DataObject {

	static $extensions = array('LinkFieldsDecorator');

	static $db = array(
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
	);

	static $has_one = array(
		'Page' => 'SiteTree',
		'Image' => 'BetterImage',
	);

	protected $resizedImage;

	public function initFromDataObject( $dataObject, $imageField = 'Image' ) {
		$this->setCarouselImage($dataObject->$imageField());
		foreach( self::database_fields(get_class($this)) as $field => $type ) {
			if( $dataObject->hasField($field) ) {
				$this->$field = $dataObject->$field;
			}
		}
	}

	/**
	 * @return FieldSet
	 */
	public function getCMSFields() {
		$fields = FormUtils::getFileCMSFields(true);
		LinkFields::addLinkFields($fields, null, 'Root.Link');
		$fields->removeByName('LinkLabel');
		return $fields;
	}

	/**
	 * Used to allow ImageCarousel to provide support for resizing.
	 * @param Image $image
	 */
	function setCarouselImage( $image ) {
		$this->resizedImage = $image;
	}

	/**
	 * @return Image
	 */
	function CarouselImage() {
		return isset($this->resizedImage) ? $this->resizedImage : $this->Image();
	}

	function setLinkTarget( $siteTree ) {
		$this->LinkType = 'Internal';
		$this->LinkTargetID = $siteTree->ID;
	}

}
