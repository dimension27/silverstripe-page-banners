<?php

class BannerGroup extends DataObject {

	static $db = array(
		'Title' => 'Varchar',
		'Notes' => 'Text'
	);

	static $indexes = array(
		'Title' => 'UNIQUE ("Title")',
	);

	static $has_many = array(
		'Banners' => 'Banner',
	);

	public function getCMSFields() {
		$fields = FormUtils::createMain();
		$fields->addFieldToTab('Root.Main', $field = new TextField('Title'));
		$fields->addFieldToTab('Root.Main', $field = new TextareaField('Notes'));
		if( $this->ID ) {
			$fields->addFieldToTab('Root.Main', $field = new ImageDataObjectManager(
				$this, 'Banners', 'Banner'
			));
			$field->uploadFolder = 'Uploads/Banners';
		}
		else {
			$fields->addFieldToTab('Root.Main', $field = new LiteralField(
				'SaveFirst', '<p>Please save to start uploading banners.</p>'
			));
		}
		return $fields;
	}

	/**
	 * Return a random Banner.
	 */
	public function RandomBanner() {
		return $this->Banners(null, 'RAND()', null, 1)->pop();
	}

}
