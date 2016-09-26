<?php

namespace OCA\template_manager\Service;
use OCP\IConfig;

class SettingsService {

	private $settings;
	private $appName;

	public function __construct(IConfig $settings, $AppName) {
		$this->settings = $settings;
		$this->appName = $AppName;
	}

	public function get() {
		$settings = array(
			// System setting
			'theme' => (string)$this->settings->getSystemValue('theme')
		);
		return $settings;
	}
	public function getKey($key) {
		return $settings.$key;
	}
	public function set($setting, $value) {
		if ($value == 'themename_none') {
			$value = '';
		}
		return $this->settings->setSystemValue($setting, $value);
	}
}
