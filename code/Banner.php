<?php

class Banner extends DataObject {

	static $db = array(
		'Title' => 'Varchar(255)'
	);

	static $has_one = array (
		'BannerGroup' => 'BannerGroup',
		'Image' => 'BetterImage',
	);

	/**
	 * @return FieldSet
	 */
	public function getCMSFields() {
		$fields = FormUtils::createMain();
		$fields->addFieldToTab('Root.Main', $field = new TextField('Title'));
		$fields->addFieldToTab('Root.Main', $field = new ImageUploadField('Image'));
		UploadFolderManager::setUploadFolder($this, $field);
		return $fields;
	}

}
