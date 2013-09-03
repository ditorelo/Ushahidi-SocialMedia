<?php defined('SYSPATH') or die('No direct script access.');
/**
 * SocialMedia Settings Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
*
*/

class SocialMedia_Controller extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->this_page = 'settings';

		// If user doesn't have access, redirect to dashboard
		if ( ! $this->auth->has_permission("manage"))
		{
			url::redirect(url::site().'admin/dashboard');
		}
	}

	public function index()
	{
		$this->template->content = new View('admin/settings/socialmedia/main');
		$this->template->content->title = Kohana::lang('ui_admin.settings');
		// Display all maps
		$this->themes->api_url = Kohana::config('settings.api_url_all');
		// Current Default Country
		$current_country = Kohana::config('settings.default_country');
		$this->themes->js = new View('admin/settings/settings_js');

		$this->template->content->form_error = null;
		$this->template->content->form_saved = null;

		$radius_options = array("" => "");
		for ($i = 10; $i < 100; $i += 10) {
			$radius_options[$i] = $i . "km (" . number_format($i/1.6, 2) . " mi)";
		}

		for ($i = 100; $i <= 1000; $i += 100) {
			$radius_options[$i] = $i . "km (" . number_format($i/1.6, 2) . " mi)";
		}

		$this->template->content->form = null;
		$this->template->content->radius_options = $radius_options;
	}

	/**
	 * Generate Report Sub Tab Menus
	 * @param string $this_sub_page
	 * @return string $menu
	 */
	public static function subtabs($this_sub_page = FALSE)
	{
		$menu = "<li><a href='" . url::site() . "admin/settings/socialmedia'" . ($this_sub_page == "main" ? null : " class='active'") . ">General</a></li>";

		echo $menu;

		// Action::socialmedia.settings_subtabs - Add items to the social media settings page
		Event::run('socialmedia.settings_subtabs', $this_sub_page);
	}
}