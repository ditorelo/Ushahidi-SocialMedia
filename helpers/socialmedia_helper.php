<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Sharing helper class.
 *
 * @package	   Sharing
 * @author	   Ushahidi Team
 * @copyright  (c) 2008 Ushahidi Team
 * @license	   http://www.ushahidi.com/license.html
 */
class socialmedia_helper_Core {
	protected static $settings = array();

	static private function getSettingObject($name) {
		if (isset($settings[$name])) {
			return $settings[$name];
		}

		$item = ORM::factory('socialmedia_settings')
					->where('setting', $name)
					->find();

		$settings[$name] = $item;

		return $item;
	}

	static public function getSetting($name) {
		$item = self::getSettingObject($name);

		if (! is_null($item->value))
		{
			return $item->value;
		}

		return false;
	}

	static public function setSetting($name, $value) {
		$item = self::getSettingObject($name);

		$item->setting = $name;
		$item->value = $value;
		return $item->save();
	}
}