<?php defined('SYSPATH') or die('No direct script access.');
/**
 * SocialMedoia Scheduler Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @subpackage Scheduler
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
*/

class S_Socialmedia_Controller extends Controller {

	public function __construct()
    {
        parent::__construct();
	}

	public function index()
	{
		$dispatch = Dispatch::controller("twitter", "");

		$keywords = array();
		$db_keywords = ORM::factory("socialmedia_keyword")->where("disabled", '0')->find_all();
		foreach ($db_keywords as $k) {
			$keywords[] = $k->keyword;
		}

		$location = array();
		if (socialmedia_helper::getSetting("enable_location")) {
			$location = array(
					"lat"		=> socialmedia_helper::getSetting("latitude"),
					"lon"		=> socialmedia_helper::getSetting("longitude"),
					"radius"	=> socialmedia_helper::getSetting("radius") * 1000,
					"radius_mi"	=> socialmedia_helper::getSetting("radius") * 1600,

				);
		}

		$config = array(
			"keywords"	=> $keywords,
			"location"	=> $location,
			"since"		=> socialmedia_helper::getSetting("start_date"),
			null,
			null  //just tricking dispatch to pass this array using php's native function
			);

		if ($dispatch instanceof Dispatch && method_exists($dispatch,'method'))
		{
			$dispatch->method("search", $config);
		}

		return true;
	}

}
