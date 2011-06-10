<?php

class Banner extends BetterImage {

	static $has_one = array (
		'BannerGroup' => 'BannerGroup',
	);

	/**
	 * @return FieldSet
	 */
	public function getCMSFields() {
		return FormUtils::getFileCMSFields();
	}

}
