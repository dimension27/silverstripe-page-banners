<?php

class BannerGroup extends DataObject {

	static $db = array(
		'Title' => 'Varchar(255)',
		'Notes' => 'Text',
		'Identifier' => 'Varchar(255)',
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
				$this, 'Banners', 'Banner', 'Image'
			));
			UploadFolderManager::setDOMUploadFolder($field, $this->Identifier);
		}
		else {
			$fields->addFieldToTab('Root.Main', $field = new LiteralField(
				'SaveFirst', '<p>Please save to start uploading banners.</p>'
			));
		}
		return $fields;
	}

	public function onBeforeWrite() {
		parent::onBeforeWrite();
		if( !$this->Identifier ) {
			$this->Identifier = preg_replace('/[^a-z0-9_-]+/i', '', $this->Title);
		}
	}

	/**
	 * Return a random Banner.
	 */
	public function RandomBanner() {
		return $this->Banners(null, 'RAND()', null, 1)->pop();
	}

	public static function get_by_identifier( $id ) {
		return DataObject::get_one('BannerGroup', "Identifier = '$id'");
	}

}
