<?php

class BannerDecorator extends DataObjectDecorator {

	public function extraStatics() {
		return array(
			'db' => array(
				'BannerType' => 'Enum("Image, SingleBanner, BannerGroup")'
			),
			'has_one' => array(
				'BannerImage' => 'BetterImage',
				'SingleBanner' => 'Banner',
				'BannerGroup' => 'BannerGroup',
			),
			'defaults' => array(
				'BannerType' => 'BannerGroup'
			)
		);
	}

	public function updateCMSFields( FieldSet $fields ) {
		$banners = DataObject::get('Banner'); /* @var $bannerGroups DataObjectSet */
		$bannerGroups = DataObject::get('BannerGroup'); /* @var $bannerGroups DataObjectSet */
		
		$fields->addFieldToTab('Root.Content.Images', $field = new LiteralField('BannerImage', '<h3>Banner Image</h3>'.NL));
		$banner = new SelectionGroup('BannerType', array(
			'BannerGroup//Banner Group' => new DropdownField('BannerGroupID', '', $bannerGroups->map()),
			'SingleBanner//Single Banner' => new DropdownField('SingleBannerID', '', $banners->map()),
			'Image//Upload an Image' => new ImageUploadField('Image', ''),
		));
		$fields->addFieldToTab('Root.Content.Images', $banner);
	}

	public function Banner() {
		$rv = false;
		switch( $this->owner->BannerType ) {
			case 'Image':
				$rv = $this->owner->BannerImage();
				break;
			case 'SingleBanner':
				$rv = $this->owner->SingleBanner();
				break;
			case 'BannerGroup':
				if( $group = $this->owner->BannerGroup() ) { /* @var $group BannerGroup */
					$rv = $group->RandomBanner();
				}
				break;
		}
		if( !$rv || !is_file($rv->getFullPath()) ) {
			if( $this->owner->Parent ) {
				$rv = $this->owner->Parent->Banner();
			}
		}
		return $rv;
	}
	
}
