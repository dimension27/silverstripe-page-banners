<?php

class BannerAdmin extends ModelAdmin {

	public static $managed_models = array(
		'BannerGroup' => array('title' => 'Banners'),
	);

	static $url_segment = 'banners';
	static $menu_title = 'Banners';

	public function __construct() {
		$this->showImportForm = false;
		parent::__construct();
	}

	public function handleAction($request) {
		if( class_exists('Subsite') ) {
			Subsite::temporarily_set_subsite(0);
			Subsite::disable_subsite_filter();
		}
		return parent::handleAction($request);
	}

}
