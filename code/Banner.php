<?php

class Banner extends BetterImage {

	static $has_one = array (
		'BannerGroup' => 'BannerGroup',
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
