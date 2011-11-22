<?php

class BannerDecorator extends DataObjectDecorator {

	protected static $restrictToGroup;
	protected static $tabName;
	protected static $inheritFromParent = true;

	/**
	 * Restricts the selection of banners to a single BannerGroup in the CMS fields
	 * @param BannerGroup $group May be a BannerGroup or its ID
	 */
	public static function restrictToGroup( $group ) {
		self::$restrictToGroup = 
			is_object($group) ? $group
				: is_string($group) ? BannerGroup::get_by_identifier($group)
					: DataObject::get_by_id('BannerGroup', $group);
	}

	/**
	 * Restricts the selection of banners to a single BannerGroup in the CMS fields
	 * @param BannerGroup $group May be a BannerGroup or its ID
	 */
	public static function setTabName( $tabName ) {
		self::$tabName = $tabName;
	}

	public static function setInheritFromParent( $bool = true ) {
		self::$inheritFromParent = $bool;
	}

	public function extraStatics() {
		return array(
			'db' => array(
				'BannerType' => 'Enum("Image, SingleBanner, BannerGroup")',
				'BannerCarousel' => 'Int',
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
		Requirements::css('banners/css/BannerDecorator.css');
		$filter = self::$restrictToGroup ? "BannerGroupID = '".self::$restrictToGroup->ID."'" : '';
		if( $banners = DataObject::get('Banner', $filter) ) { /* @var $banners DataObjectSet */
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
		if( isset(self::$tabName) ) {
			$tabName = self::$tabName;
		}
		else {
			$tabName = $this->owner instanceof Page ? 'Root.Content.Images' : 'Root.Images';
		}
		$fields->addFieldToTab($tabName, $field = new LiteralField('BannerImage', '<h3>Banner Image</h3>'.NL));
		$options = array();
		if( !self::$restrictToGroup ) {
			$options['BannerGroup//Banner Group'] = new CompositeField(array(
				new DropdownField('BannerGroupID', '', $bannerGroups),
				new CheckboxField('BannerCarousel', 'Display the banners in a scrolling image carousel'),
			));
		}
		$options['SingleBanner//Single banner'] = new DropdownField('SingleBannerID', '', $banners);
		$options['Image//Upload an image'] = $upload = new ImageUploadField('BannerImage', '');
		$banner = new SelectionGroup('BannerType', $options);
		$upload->setUploadFolder('Uploads/Banners');
		$fields->addFieldToTab($tabName, $banner);
	}

	public function Banner() {
		$rv = false;
		switch( $this->owner->BannerType ) {
			case 'Image':
				$rv = new Banner();
				$rv->Image = $this->owner->BannerImage();
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
		if( !$rv || !$rv->Image()->fileExists() ) {
			if( self::$inheritFromParent && $this->owner->Parent ) {
				$rv = $this->owner->Parent->Banner();
			}
		}
		if( !$rv ) {
			$rv = new Image();
		}
		return $rv;
	}

	public function BannerLink( $width, $height ) {
		return $this->BannerURL($width, $height);
	}

	public function BannerURL( $width, $height ) {
		$image = $this->Banner()->Image();
		if( $image->exists() && file_exists($image->getFullPath()) ) {
			$image = $image->SetCroppedSize($width, $height);
			return $image->Filename;
		}
	}

	public function BannerCSS( $width, $height ) {
		if( $url = $this->BannerURL($width, $height) ) {
			return "background-image: url(".htmlspecialchars($url).")";
		}
	}

	public function AllBanners() {
		$rv = false;
		switch( $this->owner->BannerType ) {
			case 'Image':
				$image = $this->owner->BannerImage();
				break;
			case 'SingleBanner':
				$image = $this->owner->SingleBanner();
				break;
			case 'BannerGroup':
				if( $group = $this->owner->BannerGroup() ) { /* @var $group BannerGroup */
					$set = $group->Banners(null, 'SortOrder ASC');
				}
				break;
		}
		if( isset($image) && is_file($image->getFullPath()) ) {
			$set = new DataObjectSet(array($image));
		}
		if( (!$set || !$set->Count()) && self::$inheritFromParent && $this->owner->Parent ) {
			$set = $this->owner->Parent->AllBanners();
		}
		return $set;
	} 

	public function BannerMarkup( $width = null, $height = null, $transform = 'SetRatioSize' ) {
		if( ($this->owner->BannerType == 'BannerGroup') && $this->owner->BannerCarousel ) {
			$items = new DataObjectSet();
			foreach( $this->AllBanners() as $banner ) {
				$item = new ImageCarouselItem();
				$item->setImage($banner->Image());
				$item->Title = $banner->Title;
				$items->push($item);
			}
			$carousel = new SlidesCarousel($items);
			$carousel->setRatioSize($width, $height);
			return $carousel;
		}
		else {
			return $this->Banner();
		}
	}

}
