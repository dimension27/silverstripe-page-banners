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
		if( $banners = DataObject::get('Banner') ) { /* @var $banners DataObjectSet */
			$banners = $banners->map();
		}
		else {
			$banners = array('-- No banners have been created --');
		}
		if( $bannerGroups = DataObject::get('BannerGroup') ) { /* @var $bannerGroups DataObjectSet */
			$bannerGroups = $bannerGroups->map();
		}
		else {
			$bannerGroups = array('-- No banner groups have been created --');
		}
		$fields->addFieldToTab('Root.Content.Images', $field = new LiteralField('BannerImage', '<h3>Banner Image</h3>'.NL));
		$banner = new SelectionGroup('BannerType', array(
			'BannerGroup//Banner Group' => new DropdownField('BannerGroupID', '', $bannerGroups),
			'SingleBanner//Single Banner' => new DropdownField('SingleBannerID', '', $banners),
			'Image//Upload an Image' => $upload = new ImageUploadField('BannerImage', ''),
		));
		$upload->setUploadFolder('Uploads/Banners');
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
		if( !$rv ) {
			$rv = new Image();
		}
		return $rv;
	}

	public function BannerLink( $width, $height ) {
		$image = $this->Banner();
		if( $image->exists() ) {
			$image = $image->SetCroppedSize($width, $height);
			return $image->Filename;
		}
	}

	public function BannerCSS( $width, $height ) {
		if( $url = $this->BannerLink($width, $height) ) {
			return "background-image: url(".htmlspecialchars($url).")";
		}
	}
}
