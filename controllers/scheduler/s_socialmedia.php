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

		$config = array(
			"keywords"	=> array("new zealand", "nz"),
			"location"	=> null,
			"since_id"	=> null,
			"count"		=> 100,
			"hokey"		=> "pokey"  //just tricking dispatch to pass this array using php's native function
			);

		if ($dispatch instanceof Dispatch && method_exists($dispatch,'method'))
		{
			$dispatch->method("search", $config);
		}

		var_dump("called!");
	}

}
