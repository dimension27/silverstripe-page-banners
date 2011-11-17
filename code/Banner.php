<?php

class Banner extends DataObject {

	static $has_one = array (
		'BannerGroup' => 'BannerGroup',
		'Image' => 'BetterImage',
	);

	/**
	 * @return FieldSet
	 */
	public function getCMSFields() {
		$fields = FormUtils::getFileCMSFields('Caption');
		LinkFields::addLinkFields($fields, null, 'Root.Link');
		$fields->removeByName('LinkLabel');
		return $fields;
	}

}
